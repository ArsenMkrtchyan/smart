<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Project;
use Carbon\Carbon;
use DB;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FinanceController extends Controller
{


    public function index()
    {
        // Просто возвращаем вид, AJAX запросы будут идти на другие методы.
        return view('finances.index');
    }
    public function searchProjects(Request $request)
    {
        // Получаем из запроса выбранный месяц и поисковую строку
        $monthYear = $request->input('monthYear');
        $query = $request->input('query');

        if (!$monthYear) {
            // Если месяц не передан, возвращаем пустой результат
            return response()->json([]);
        }

        // Транслитерационная карта для армянских символов → английские
        $translitMap = [
            'Ա' => 'A', 'Բ' => 'B', 'Գ' => 'G', 'Դ' => 'D', 'Ե' => 'E',
            'Զ' => 'Z', 'Է' => 'E', 'Ը' => 'Y', 'Թ' => 'T', 'Ժ' => 'Zh',
            'Ի' => 'I', 'Լ' => 'L', 'Խ' => 'Kh', 'Ծ' => 'Ts', 'Կ' => 'K',
            'Հ' => 'H', 'Ձ' => 'Dz', 'Ղ' => 'Gh', 'Ճ' => 'Ch', 'Մ' => 'M',
            'Յ' => 'Y', 'Ն' => 'N', 'Շ' => 'Sh', 'Ո' => 'O', 'Չ' => 'Ch',
            'Պ' => 'P', 'Ջ' => 'J', 'Ռ' => 'R', 'Ս' => 'S', 'Վ' => 'V',
            'Տ' => 'T', 'Ր' => 'R', 'Ց' => 'Ts', 'Ւ' => 'V', 'Փ' => 'P',
            'Ք' => 'Q', 'Օ' => 'O', 'Ֆ' => 'F',
        ];

        // Функция для транслитерации (заменяет армянские символы на соответствующие английские)
        $transliterate = function($text) use ($translitMap) {
            return strtr($text, $translitMap);
        };

        // Если есть поисковый запрос, получаем его транслитерированную версию
        $queryTrans = $query ? $transliterate($query) : '';

        // Строим запрос к модели Finance (фильтруем по выбранному месяцу)
        $financesQuery = Finance::where('month', $monthYear)
            ->with('project'); // Отношение должно быть настроено в модели Finance

        // Если поисковая строка не пуста, добавляем фильтр по связанному проекту
        if ($query) {
            $financesQuery->whereHas('project', function($q) use ($query, $queryTrans) {
                $q->where('firm_name', 'iLIKE', "%{$query}%")
                    ->orWhere('firm_name', 'iLIKE', "%{$queryTrans}%")
                    ->orWhere('brand_name', 'iLIKE', "%{$query}%")
                    ->orWhere('brand_name', 'iLIKE', "%{$queryTrans}%");
            });
        }

        // Получаем результаты
        $finances = $financesQuery->get();

        // Формируем массив данных для ответа
        $data = $finances->map(function($finance) {
            return [
                'finance_id'   => $finance->id,
                // Если firm_name задан, выводим его, иначе brand_name
                'project_name' => $finance->project ? ($finance->project->firm_name ?: $finance->project->brand_name) : null,
                'amount'       => $finance->amount,
            ];
        });

        return response()->json($data);
    }

    public function getYears()
    {
        // Предполагается, что month хранится в формате "December_2024"
        $allMonths = Finance::select('month')->distinct()->get()->pluck('month');
        $years = $allMonths->map(function($m) {
            $parts = explode('_', $m);
            return end($parts);
        })->unique()->sort()->values();

        return response()->json($years);
    }

    public function getMonths(Request $request)
    {
        $year = $request->input('year');
        if (!$year) {
            return response()->json([]);
        }

        // Сгенерируем все месяцы для данного года, проверим по базе сумму amount всех finance этого месяца
        // Предполагаем, что для подсчёта суммы за месяц можно сделать sum(amount) по всем finance с month = ...
        $monthsData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthName = Carbon::create($year, $m, 1)->format('F');
            $monthYear = $monthName . '_' . $year;

            $totalAmount = Finance::where('month', $monthYear)->sum('amount');
            $monthsData[] = [
                'monthYear' => $monthYear,
                'amount' => $totalAmount,
            ];
        }

        return response()->json($monthsData);
    }

    public function getProjects(Request $request)
    {
        $monthYear = $request->input('monthYear');
        if (!$monthYear) {
            return response()->json([]);
        }

        $finances = Finance::where('month', $monthYear)->with('projecte')->get(['id','project_id','amount']);



        $data = $finances->map(function($f) {
            if ($f->project->firm_name != null){
                return [
                    'finance_id' => $f->id,
                    'project_id' => $f->project ? $f->project->firm_name : null,
                    'amount' => $f->amount,
                ];

        }else{
                return [
                    'finance_id' => $f->id,
                    'project_id' => $f->project ? $f->project->brand_name : null,
                    'amount' => $f->amount,
                ];

            }
        });

        return response()->json($data);
    }
}
