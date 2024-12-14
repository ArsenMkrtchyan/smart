<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\Finance;
use Carbon\Carbon;

class CalculateMonthlyPayments extends Command
{
    protected $signature = 'calculate:monthly-payments';
    protected $description = 'Calculate monthly payments for projects and save them in the finances table';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $projects = Project::with('price')->whereNotNull('paymanagir_start')->get();

        foreach ($projects as $project) {
            $paymanagirStart = Carbon::parse($project->paymanagir_start);
            $paymanagirEnd = $project->paymanagir_end ? Carbon::parse($project->paymanagir_end) : null;

            $this->calculateMonthlyPayments($project, $paymanagirStart, $paymanagirEnd);
        }
    }

    protected function calculateMonthlyPayments($project, $start, $end)
    {
        $currentDate = Carbon::now();
        $endDate = $end ? $end->copy()->endOfMonth() : $currentDate->copy()->subMonth()->endOfMonth();

        for ($date = $start->copy()->startOfMonth(); $date->lessThanOrEqualTo($endDate); $date->addMonth()) {
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            if ($date->month == $start->month && $date->year == $start->year) {
                $startOfMonth = $start;
            }

            if ($end && $date->month == $end->month && $date->year == $end->year) {
                $endOfMonth = $end;
            }

            $monthYear = $date->format('F-Y');

            $existingRecord = Finance::where('project_id', $project->id)
                ->where('month', $monthYear)
                ->first();

            if ($existingRecord) {
                continue;
            }

            $daysInPeriod = $startOfMonth->diffInDays($endOfMonth);
            $pricePerDay = $project->price->amount / $date->daysInMonth;
            $payment = $pricePerDay * $daysInPeriod;

            Finance::create([
                'project_id' => $project->id,
                'month' => $monthYear,
                'amount' => round($payment, 2),

            ]);
        }
    }
}
