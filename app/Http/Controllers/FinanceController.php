<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finance;
use App\Models\Project;
use Carbon\Carbon;
use DB;

class FinanceController extends Controller
{
    public function index()
    {
        // Просто возвращаем вид, AJAX запросы будут идти на другие методы.
        return view('finances.index');
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

        $finances = Finance::where('month', $monthYear)->get(['id','project_id','amount']);

        $data = $finances->map(function($f) {
            return [
                'finance_id' => $f->id,
                'project_id' => $f->project_id,
                'amount' => $f->amount,
            ];
        });

        return response()->json($data);
    }
}
