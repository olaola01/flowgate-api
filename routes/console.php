<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('flowgate:aggregate-hourly')->everyFiveMinutes();
Schedule::command('flowgate:aggregate-daily')->dailyAt('00:05');
Schedule::command('flowgate:expire-logs')->dailyAt('00:20');
Schedule::command('flowgate:warm-cache')->everyTenMinutes();
