<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schedule;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('calculate:monthly-payments')->monthlyOn(1, '00:00');
Schedule::command('monthly:generate')->monthlyOn(1, '00:00');

Schedule::command('calculate:finance')->daily();
Schedule::command('db:fix-sequences')->daily();
