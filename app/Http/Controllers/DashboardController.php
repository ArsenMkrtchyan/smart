<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        // Текущий год и месяц
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $lastMonth = Carbon::now()->subMonth();  // Carbon дата прошлого месяца

        // 1. Четыре верхние карточки:

        // Всего проектов
        $totalProjects = Project::count();
        // Количество проектов на конец прошлого месяца для сравнения
        $projectsLastMonth = Project::whereDate('created_at', '<=', $lastMonth->endOfMonth())->count();
        $projectsDiff = $totalProjects - $projectsLastMonth;

        // Общий доход (сумма всех платежей)
        $totalIncome = Payment::sum('amount');

        // Доход текущего месяца
        $currentMonthIncome = Payment::whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->sum('amount');
        // Доход прошлого месяца
        $lastMonthIncome = Payment::whereYear('date', $lastMonth->year)
            ->whereMonth('date', $lastMonth->month)
            ->sum('amount');
        // Процент роста (или падения) относительно прошлого месяца
        if ($lastMonthIncome > 0) {
            $incomeGrowthPercent = round((($currentMonthIncome - $lastMonthIncome) / $lastMonthIncome) * 100);
        } else {
            $incomeGrowthPercent = null; // нет данных за прошлый месяц (предположим null, обработается в шаблоне)
        }

        // Ожидаемый доход за прошлый месяц (сумма finances.amount для предыдущего месяца)
        $lastMonthLabel = $lastMonth->format('F_Y');  // например "March_2025" для апреля 2025
        $expectedLastMonth = Finance::where('month', $lastMonthLabel)->sum('amount');

        // 2. Данные для графика 1 (Bar Chart) по месяцам текущего года:
        $chart1Data = $this->getYearlyExpectedActualDebt($currentYear);
        // В результате $chart1Data содержит ключи: 'categories', 'expected', 'paid', 'debt'

        // 3. Данные для графика 2 (Area Chart) – по умолчанию текущий год (помесячно):
        $yearlyData = $this->aggregatePaymentsByMonth($currentYear);
        // $yearlyData содержит 'categories', 'sums', 'counts' для графика 2 при выбранном только году

        // 4. Список доступных лет для селектора года (на основе таблицы payments):
        $years = Payment::selectRaw("EXTRACT(YEAR FROM date) as year")
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // 5. Передача данных в представление
        return view('dashboard', [
            // Метрики для карточек:
            'totalProjects'      => $totalProjects,
            'projectsDiff'       => $projectsDiff,
            'totalIncome'        => $totalIncome,
            'currentMonthIncome' => $currentMonthIncome,
            'incomeGrowthPercent'=> $incomeGrowthPercent,
            'expectedLastMonth'  => $expectedLastMonth,
            // Данные для графика 1:
            'monthsCategories'   => $chart1Data['categories'],
            'expectedData'       => $chart1Data['expected'],
            'paidData'           => $chart1Data['paid'],
            'debtData'           => $chart1Data['debt'],
            // Данные для графика 2 (текущий год помесячно):
            'yearlyCategories'   => $yearlyData['categories'],
            'yearlySums'         => $yearlyData['sums'],
            'yearlyCounts'       => $yearlyData['counts'],
            // Список лет для выпадающего списка:
            'years'              => $years,
            'currentYear'        => $currentYear
        ]);
    }

    public function chartData(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');  // может быть null или пустым

        if (!$year) {
            return response()->json(['error' => 'Year is required'], 400);
        }

        if ($month) {
            // Если указан год и месяц – агрегировать по дням выбранного месяца
            $data = $this->aggregatePaymentsByDay($year, $month);
        } else {
            // Если указан только год – агрегировать по месяцам
            $data = $this->aggregatePaymentsByMonth($year);
        }

        return response()->json($data);
    }

    /**
     * Приватный метод для получения данных графика 1:
     * "Ожидалось" (expected), "Оплачено" (paid) и "Долг" по месяцам заданного года.
     */
    private function getYearlyExpectedActualDebt($year)
    {
        $now = Carbon::now();
        $currentYear = $now->year;
        // Определяем, до какого месяца брать данные:
        $lastMonthNum = ($year == $currentYear) ? $now->month : 12;

        $months = [];
        $expectedArr = [];
        $paidArr = [];
        $debtArr = [];

        // Получаем суммы оплаченных платежей по всем месяцам года одним запросом
        $paymentsByMonth = Payment::whereYear('date', $year)
            ->selectRaw("EXTRACT(MONTH FROM date) as month, SUM(amount) as total_paid")
            ->groupBy('month')
            ->pluck('total_paid', 'month')
            ->toArray();

        // Подготовим список меток предыдущих месяцев для ожиданий:
        $prevMonthLabels = [];
        for ($m = 1; $m <= $lastMonthNum; $m++) {
            // Вычисляем предыдущий месяц и год для месяца $m
            if ($m == 1) {
                $prev = Carbon::create($year - 1, 12, 1);  // декабрь предыдущего года
            } else {
                $prev = Carbon::create($year, $m - 1, 1);
            }
            $prevMonthLabels[] = $prev->format('F_Y');
        }
        // Получаем суммы "ожидалось" по нужным месяцам (группируем по метке месяца)
        $expectedByLabel = Finance::whereIn('month', $prevMonthLabels)
            ->select('month', DB::raw('SUM(amount) as total_expected'))
            ->groupBy('month')
            ->pluck('total_expected', 'month')
            ->toArray();

        // Формируем данные по каждому месяцу до $lastMonthNum
        for ($m = 1; $m <= $lastMonthNum; $m++) {
            // Название месяца (аббревиатура для оси X)
            $monthName = Carbon::create($year, $m, 1)->format('M');  // Jan, Feb, ...
            $months[] = $monthName;
            // Метка предыдущего месяца
            if ($m == 1) {
                $prevLabel = Carbon::create($year - 1, 12, 1)->format('F_Y');
            } else {
                $prevLabel = Carbon::create($year, $m - 1, 1)->format('F_Y');
            }
            // Ожидалось: берем из $expectedByLabel, если нет – 0
            $expected = isset($expectedByLabel[$prevLabel]) ? (float)$expectedByLabel[$prevLabel] : 0;
            // Оплачено: из $paymentsByMonth (данные по payments), если нет – 0
            $paid = isset($paymentsByMonth[$m]) ? (float)$paymentsByMonth[$m] : 0;
            // Долг: разница (ожидалось - оплачено), минимум 0 (не показываем отрицательный долг)
            $debt = ($expected > $paid) ? $expected - $paid : 0;

            $expectedArr[] = round($expected, 2);
            $paidArr[] = round($paid, 2);
            $debtArr[] = round($debt, 2);
        }

        return [
            'categories' => $months,
            'expected'   => $expectedArr,
            'paid'       => $paidArr,
            'debt'       => $debtArr,
        ];
    }

    /**
     * Приватный метод для агрегирования платежей по месяцам данного года.
     * Возвращает категории (месяцы) и массивы сумм и количества транзакций по месяцам.
     */
    private function aggregatePaymentsByMonth($year)
    {
        $now = Carbon::now();
        $currentYear = $now->year;
        // До какого месяца включительно показывать данные:
        $lastMonthNum = ($year == $currentYear) ? $now->month : 12;

        $months = [];
        $sumArr = [];
        $countArr = [];

        // Получаем из БД сумму и количество платежей по каждому месяцу данного года
        $results = Payment::whereYear('date', $year)
            ->selectRaw("EXTRACT(MONTH FROM date) as month, SUM(amount) as total_sum, COUNT(*) as total_count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Преобразуем результаты в удобные словари
        $sumByMonth = [];
        $countByMonth = [];
        foreach ($results as $row) {
            $monthNum = (int) $row->month;
            $sumByMonth[$monthNum] = (float) $row->total_sum;
            $countByMonth[$monthNum] = (int) $row->total_count;
        }

        // Формируем последовательность месяцев
        for ($m = 1; $m <= $lastMonthNum; $m++) {
            $months[] = Carbon::create($year, $m, 1)->format('M');
            $sumArr[] = isset($sumByMonth[$m]) ? round($sumByMonth[$m], 2) : 0;
            $countArr[] = isset($countByMonth[$m]) ? $countByMonth[$m] : 0;
        }

        return [
            'categories' => $months,
            'sums'       => $sumArr,
            'counts'     => $countArr,
        ];
    }

    /**
     * Приватный метод для агрегирования платежей по дням указанного месяца и года.
     * Возвращает категории (дни) и массивы сумм и количества транзакций по дням.
     */
    private function aggregatePaymentsByDay($year, $month)
    {
        $year = (int) $year;
        $month = (int) $month;
        $now = Carbon::now();

        // Определяем количество дней для выборки:
        if ($year == $now->year && $month == $now->month) {
            // Если выбран текущий месяц текущего года – берем дни до сегодняшнего
            $daysInMonth = $now->day;
        } else {
            // Иначе – полный месяц (количество дней в месяце)
            $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
        }

        $days = [];
        $sumArr = [];
        $countArr = [];

        // Диапазон дат начала и конца выбранного месяца
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        // Получаем сумму и количество платежей по каждому дню
        $results = Payment::whereBetween('date', [$startOfMonth, $endOfMonth])
            ->selectRaw("EXTRACT(DAY FROM date) as day, SUM(amount) as total_sum, COUNT(*) as total_count")
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        // Сохраняем результаты в словари для удобства
        $sumByDay = [];
        $countByDay = [];
        foreach ($results as $row) {
            $dayNum = (int) $row->day;
            $sumByDay[$dayNum] = (float) $row->total_sum;
            $countByDay[$dayNum] = (int) $row->total_count;
        }

        // Формируем массивы для каждого дня месяца
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $days[] = $d;  // метка дня (число)
            $sumArr[] = isset($sumByDay[$d]) ? round($sumByDay[$d], 2) : 0;
            $countArr[] = isset($countByDay[$d]) ? $countByDay[$d] : 0;
        }

        return [
            'categories' => $days,
            'sums'       => $sumArr,
            'counts'     => $countArr,
        ];
    }
}
