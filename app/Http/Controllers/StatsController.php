<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Payment;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    /* ---------- страница -------------------------------------------------- */
    public function index()
    {
        // вьюха ничего не знает о данных – всё приходит по AJAX
        return view('stats.dashboard');
    }

    /* ---------- 4 KPI карточки -------------------------------------------- */
    public function apiKpi(Request $r)
    {
        $now            = Carbon::now();
        $year           = $now->year;
        $prevYear       = $year - 1;
        $month          = $now->month;
        $prevMonth      = $now->copy()->subMonth();

        /* 1. Projects & Δ */
        $projectsThis   = Project::whereYear('created_at',$year)->count();
        $projectsPrev   = Project::whereYear('created_at',$prevYear)->count();
        $projectsDelta  = $projectsPrev ? round(($projectsThis-$projectsPrev)/$projectsPrev*100,1) : 100;

        /* 2. Total revenue */
        $totalRevenue   = Payment::sum('amount');

        /* 3. This‑month revenue & Δ */
        $monthRevenue   = Payment::whereYear('date',$year)->whereMonth('date',$month)->sum('amount');
        $prevMonthRev   = Payment::whereYear('date',$prevMonth->year)->whereMonth('date',$prevMonth->month)->sum('amount');
        $monthDelta     = $prevMonthRev ? round(($monthRevenue-$prevMonthRev)/$prevMonthRev*100,1) : 100;

        /* 4. Expected this month (план‑факт) */
        $monthName      = $now->format('F').'_'.$year;               // «January_2025»
        $planned        = Finance::where('month',$monthName)->sum('amount');
        $expected       = $planned - $monthRevenue;

        return response()->json([
            'projects'      => $projectsThis,
            'projectsDelta' => $projectsDelta,
            'totalRevenue'  => $totalRevenue,
            'monthRevenue'  => $monthRevenue,
            'monthDelta'    => $monthDelta,
            'expected'      => $expected
        ]);
    }

    /* ---------- годовые данные (бар‑чарт) --------------------------------- */
    public function apiYear(int $year)
    {
        $labels   = [];
        $planned  = [];
        $paid     = [];
        $countPay = [];

        for ($m=1;$m<=12;$m++){
            $monthName      = Carbon::create($year,$m,1)->format('F');
            $monthYearKey   = $monthName.'_'.$year;

            $labels[]       = $monthName;
            $planned[]      = (float) Finance::where('month',$monthYearKey)->sum('amount');

            $paidQuery      = Payment::whereYear('date',$year)->whereMonth('date',$m);
            $paid[]         = (float) $paidQuery->sum('amount');
            $countPay[]     = $paidQuery->count();
        }

        return response()->json(compact('labels','planned','paid','countPay'));
    }

    /* ---------- помесячные данные (area‑чарт) ------------------------------ */
    public function apiMonth(int $year,int $month)
    {
        $daysInMonth = Carbon::create($year,$month,1)->daysInMonth;
        $labels=[]; $paid=[]; $countPay=[];

        for ($d=1;$d<=$daysInMonth;$d++){
            $labels[] = $d;
            $query    = Payment::whereYear('date',$year)
                ->whereMonth('date',$month)
                ->whereDay('date',$d);

            $paid[]      = (float) $query->sum('amount');
            $countPay[]  = $query->count();
        }

        return response()->json(compact('labels','paid','countPay'));
    }
}
