<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\InstagramApiController;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('instagram:fetch')
    ->everySixHours()
    ->appendOutputTo(storage_path('logs/instagram-fetch.log'))
    ->description('Fetch Instagram posts automatically');
