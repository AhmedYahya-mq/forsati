<?php

use App\Console\Commands\CleanTempFiles;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::command(CleanTempFiles::class)->everyMinute();
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());

})->purpose('Display an inspiring quote')->hourly();

