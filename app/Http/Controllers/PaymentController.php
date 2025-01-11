<?php
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use App\Models\Finance;
//use App\Models\Payment;
//
//class PaymentController extends Controller
//{
//    public function create(Finance $finance)
//    {
//        // Здесь мы можем отобразить форму, где пользователь выбирает сумму и описание
//        // $finance уже получен по ID
//        return view('payments.create', compact('finance'));
//    }
//
//    public function store(Request $request)
//    {
//        $request->validate([
//            'finance_id' => 'required|exists:finances,id',
//            'amount' => 'required|numeric|min:0',
//            'description' => 'nullable|string',
//        ]);
//
//        $finance = Finance::findOrFail($request->finance_id);
//        $projectId = $finance->project_id;
//
//        // Считаем уже оплаченную сумму для этого finance
//        $alreadyPaid = Payment::where('finance_id', $finance->id)->sum('amount');
//
//        // Остаток, который ещё нужно оплатить по этому finance
//        $remaining = $finance->amount - $alreadyPaid;
//
//        $paymentAmount = $request->amount;
//        $description = $request->description;
//
//        if ($paymentAmount <= $remaining) {
//            // Вся оплата уходит в этот finance
//            Payment::create([
//                'finance_id' => $finance->id,
//                'project_id' => $projectId,
//                'amount' => $paymentAmount,
//                'description' => $description,
//            ]);
//        } else {
//            // Платёж больше, чем осталось оплатить по finance
//            // Сначала закроем этот finance, если remaining > 0
//            if ($remaining > 0) {
//                Payment::create([
//                    'finance_id' => $finance->id,
//                    'project_id' => $projectId,
//                    'amount' => $remaining,
//                    'description' => $description,
//                ]);
//            }
//
//            // Остаток суммы идёт как оплата без finance_id, но с project_id
//            $overPayment = $paymentAmount - $remaining;
//            if ($overPayment > 0) {
//                Payment::create([
//                    'finance_id' => null,
//                    'project_id' => $projectId,
//                    'amount' => $overPayment,
//                    'description' => $description . ' (Overpayment)',
//                ]);
//            }
//        }
//
//        return redirect()->route('finances.index', ['monthYear' => $finance->month])
//            ->with('success', 'Payment recorded successfully.');
//    }
//
////    public function show(Finance $finance)
////    {
////        $payments = $finance->payments;
////        return view('payments.show', compact('finance', 'payments'));
////    }
//}


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Project;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Страница со всеми проектами и общей статистикой
//    public function index()
//    {
//        // Получаем все проекты
//        $projects = Project::all();
//
//        // Считаем общий долг (сумма всех finance.amount по всем проектам)
//        $totalNeeded = Finance::sum('amount');
//
//        // Считаем общую оплату (сумма всех payments.amount)
//        $totalPaid = Payment::sum('amount');
//
//        // Для каждого проекта считаем сумму finance и сумму payments
//        $projectData = $projects->map(function ($project) {
//            $projectId = $project->id;
//            $needed = Finance::where('project_id', $projectId)->sum('amount');
//            $paid = Payment::where('project_id', $projectId)->sum('amount');
//
//            return [
//                'project' => $project,
//                'needed' => $needed,
//                'paid' => $paid,
//            ];
//        });
//
//        return view('payments.index', compact('projectData', 'totalNeeded', 'totalPaid'));
//    }

    public function index()
    {
        $projects = Project::with(['finances', 'payments'])->get();

        $totalNeeded = Finance::sum('amount');
        $totalPaid = Payment::sum('amount');

        $projectData = $projects->map(function ($project) {
            $needed = $project->finances->sum('amount');
            $paid = $project->payments->sum('amount');

            return [
                'project' => $project,
                'needed' => $needed,
                'paid' => $paid,
            ];
        });

        return view('payments.index', compact('projectData', 'totalNeeded', 'totalPaid'));
    }

//    protected function parseMonthYear($monthYear)
//    {
//        [$monthName, $year] = explode('_', $monthYear);
//        $dt = Carbon::parse("1 $monthName $year");
//        return [$dt->month, (int)$year];
//    }
//
//    // Метод для проверки, находится ли monthYear раньше currentMonthYear
//    protected function isBefore($monthYear, $currentMonthYear)
//    {
//        [$m1, $y1] = $this->parseMonthYear($monthYear);
//        [$m2, $y2] = $this->parseMonthYear($currentMonthYear);
//        return ($y1 < $y2) || ($y1 == $y2 && $m1 < $m2);
//    }
//    public function index()
//    {
//        $currentMonthYear = "January_2025";
//
//        $projects = Project::all();
//
//        $totalNeeded = Finance::sum('amount');
//        $totalPaid = Payment::sum('amount');
//
//        // Сначала получаем все finances до currentMonthYear
//        $allFinances = Finance::all();
//        $allFinancesBefore = $allFinances->filter(function($f) use ($currentMonthYear) {
//            return $this->isBefore($f->month, $currentMonthYear);
//        });
//        $financesBeforeSum = $allFinancesBefore->sum('amount');
//
//        // Аналогично для платежей "до currentMonthYear"
//        // Логика получения payments "до currentMonthYear" может быть сложной.
//        // Для примера возьмём просто все payments,
//        // но в реальности нужно будет фильтровать по соответствующим finance.month.
//
//        // Упростим: Посчитаем лишь finances до currentMonthYear.
//        $financeIdsBefore = $allFinancesBefore->pluck('id');
//
//        // Все payments, где finance_id есть в financeIdsBefore
//        $paymentsBefore = Payment::whereIn('finance_id', $financeIdsBefore)->sum('amount');
//        // Депозиты (finance_id=null) не привязаны к месяцу,
//        // если нужно учитывать их до currentMonthYear — логику фильтрации нужно определять отдельно.
//
//        // Для простоты сейчас не будем учитывать депозитные платежи для расчёта debt "до currentMonthYear",
//        // или считаем, что депозиты всегда после.
//
//        $allPaymentsBefore = $paymentsBefore;
//
//        $totalDebt = $financesBeforeSum - $allPaymentsBefore;
//
//        $projectData = $projects->map(function ($project) use ($currentMonthYear) {
//            $projectId = $project->id;
//            $needed = Finance::where('project_id', $projectId)->sum('amount');
//            $paid = Payment::where('project_id', $projectId)->sum('amount');
//
//            $projectFinances = Finance::where('project_id', $projectId)->get();
//            $projectFinancesBefore = $projectFinances->filter(function($f) use ($currentMonthYear) {
//                return $this->isBefore($f->month, $currentMonthYear);
//            });
//            $projectFinancesBeforeSum = $projectFinancesBefore->sum('amount');
//
//            $projectFinanceIdsBefore = $projectFinancesBefore->pluck('id');
//
//            $projectPaymentsBefore = Payment::where('project_id', $projectId)
//                ->where(function($q) use ($projectFinanceIdsBefore) {
//                    $q->whereIn('finance_id', $projectFinanceIdsBefore)
//                        ->orWhereNull('finance_id');
//                })->sum('amount');
//
//            $projectDebt = $projectFinancesBeforeSum - $projectPaymentsBefore;
//
//            return [
//                'project' => $project,
//                'needed' => $needed,
//                'paid' => $paid,
//                'debt' => $projectDebt,
//            ];
//        });
//
//        return view('payments.index', compact('projectData', 'totalNeeded', 'totalPaid', 'totalDebt', 'currentMonthYear'));
//    }

    // Страница со всеми платежами по конкретному проекту
    public function projectPayments(Project $project)
    {
        $projectId = $project->id;
        // Сколько всего нужно оплатить
        $needed = Finance::where('project_id', $projectId)->sum('amount');
        // Сколько уже оплачено
        $paid = Payment::where('project_id', $projectId)->sum('amount');

        // Все платежи этого проекта
        $payments = Payment::where('project_id', $projectId)->with('finance')->get();

        return view('payments.project', compact('project', 'payments', 'needed', 'paid'));
    }

    public function create(Finance $finance)
    {
        return view('payments.create', compact('finance'));
    }

    // Дополнительный метод для создания платежа без finance_id (по проекту)
    public function createForProject(Project $project)
    {
        // В этом случае finance_id нет, но мы передадим в форму $project_id
        return view('payments.create_for_project', compact('project'));
    }

//    public function store(Request $request)
//    {
//        $request->validate([
//            'finance_id' => 'nullable|exists:finances,id',
//            'project_id' => 'required|exists:projects,id',
//            'amount' => 'required|numeric|min:0',
//            'description' => 'nullable|string',
//        ]);
//
//        $financeId = $request->finance_id;
//        $projectId = $request->project_id;
//
//        if ($financeId) {
//            $finance = Finance::findOrFail($financeId);
//            $alreadyPaid = Payment::where('finance_id', $finance->id)->sum('amount');
//            $remaining = $finance->amount - $alreadyPaid;
//
//            $paymentAmount = $request->amount;
//            $description = $request->description;
//
//            if ($paymentAmount <= $remaining) {
//                Payment::create([
//                    'finance_id' => $finance->id,
//                    'project_id' => $projectId,
//                    'amount' => $paymentAmount,
//                    'description' => $description,
//                ]);
//            } else {
//                if ($remaining > 0) {
//                    Payment::create([
//                        'finance_id' => $finance->id,
//                        'project_id' => $projectId,
//                        'amount' => $remaining,
//                        'description' => $description,
//                    ]);
//                }
//                $overPayment = $paymentAmount - $remaining;
//                if ($overPayment > 0) {
//                    Payment::create([
//                        'finance_id' => null,
//                        'project_id' => $projectId,
//                        'amount' => $overPayment,
//                        'description' => $description . ' (Overpayment)',
//                    ]);
//                }
//            }
//
//            return redirect()->route('finances.show', ['monthYear' => $finance->month])
//                ->with('success', 'Payment recorded successfully.');
//
//        } else {
//            // Оплата без finance_id (депозит)
//            Payment::create([
//                'finance_id' => null,
//                'project_id' => $projectId,
//                'amount' => $request->amount,
//                'description' => $request->description,
//            ]);
//
//            // Возвращаем на страницу проекта, где видны все его платежи
//            return redirect()->route('payments.projectPayments', ['project' => $projectId])
//                ->with('success', 'Deposit payment recorded successfully.');
//        }
//    }
    public function store(Request $request)
    {
        $request->validate([
            'finance_id' => 'nullable|exists:finances,id',
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $financeId = $request->finance_id;
        $projectId = $request->project_id;
        $paymentAmount = $request->amount;
        if ( $request->description == null ) {
            $description = 'no description';

        }else{
            $description = $request->description;

        }
    
        if ($financeId) {
            // Логика из старого кода для оплаты по конкретному finance
            $finance = Finance::findOrFail($financeId);
            $alreadyPaid = Payment::where('finance_id', $finance->id)->sum('amount');
            $remaining = $finance->amount - $alreadyPaid;

            if ($paymentAmount <= $remaining) {
                // Вся оплата уходит в этот finance
                Payment::create([
                    'finance_id' => $finance->id,
                    'project_id' => $projectId,
                    'amount' => $paymentAmount,
                    'description' => $description,
                ]);
            } else {
                // Платёж больше, чем осталось оплатить по finance
                if ($remaining > 0) {
                    Payment::create([
                        'finance_id' => $finance->id,
                        'project_id' => $projectId,
                        'amount' => $remaining,
                        'description' => $description,
                    ]);
                }

                $overPayment = $paymentAmount - $remaining;
                if ($overPayment > 0) {
                    Payment::create([
                        'finance_id' => null,
                        'project_id' => $projectId,
                        'amount' => $overPayment,
                        'description' => $description . ' (Overpayment)',
                    ]);
                }
            }

            return redirect()->route('finances.index', ['monthYear' => $finance->month])
                ->with('success', 'Payment recorded successfully.');

        } else {
            // Новая логика для оплаты без finance_id (депозит)
            Payment::create([
                'finance_id' => null,
                'project_id' => $projectId,
                'amount' => $paymentAmount,
                'description' => $description,
            ]);

            return redirect()->route('payments.index', ['project' => $projectId])
                ->with('success', 'Deposit payment recorded successfully.');
        }
    }


    public function searchPage()
    {
        return view('payments.pay');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $projects = [];
        if ($query) {
            $projects = Project::where('brand_name', 'LIKE', "%{$query}%")->get();
        }

        return view('payments.search', compact('projects', 'query'));
    }

    public function storeForProject(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Payment::create([
            'finance_id' => null,
            'project_id' => $request->project_id,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }
}
