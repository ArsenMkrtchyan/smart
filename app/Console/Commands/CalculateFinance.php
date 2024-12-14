<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance;
use App\Models\Project;
use Carbon\Carbon;

class CalculateFinance extends Command
{
    protected $signature = 'calculate:finance';
    protected $description = 'Calculate and save financial data for projects';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();

        // Получить все активные проекты
        $projects = Project::where('active', 1)->get();

        foreach ($projects as $project) {
            $startDate = Carbon::parse($project->paymanagir_start);
            $endDate = $project->paymanagir_end ? Carbon::parse($project->paymanagir_end) : null;
            $pricePerDay = $project->price->amount / $startDate->daysInMonth;

            if ($today->greaterThanOrEqualTo($startDate)) {
                $month = $today->format('F');
                $daysInMonth = $today->daysInMonth;

                if ($endDate && $today->greaterThan($endDate)) {
                    $daysCount = $endDate->diffInDays($today) + 1;
                    $amount = $pricePerDay * $daysCount;
                    $project->update(['active' => 0]);
                } else {
                    $daysCount = $today->diffInDays($startDate) + 1;
                    $amount = $pricePerDay * $daysCount;
                }

                Finance::create([
                    'project_id' => $project->id,
                    'mouth' => $month,
                    'payment' => $amount
                ]);
            }
        }
    }
}
