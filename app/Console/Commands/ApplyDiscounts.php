<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance;
use Carbon\Carbon;

class ApplyDiscounts extends Command
{
    protected $signature = 'apply:discounts';
    protected $description = 'Apply discounts and update payments on 16th of each month';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
//        $currentDate = Carbon::now();
//
//        if ($currentDate->day != 16) {
//            $this->error('This command should only be run on the 16th of the month.');
//            return;
//        }

        $finances = Finance::where('payment', '>', 0)->get();

        foreach ($finances as $finance) {
            if ($finance->discount == 0) {
                $finance->discount += 5; // Increase discount by 5 only once
            }

            // Adjust payment based on the current discount
            $finance->payment = round($finance->payment * (1 + $finance->discount / 100), 2);
            $finance->save();
        }

        $this->info('Discounts applied and payments updated.');
    }
}
