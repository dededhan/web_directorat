<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() {
        Storage::extend('local', function ($app, $config) {
            return new \Illuminate\Filesystem\FilesystemAdapter(
                new \Illuminate\Filesystem\Filesystem,
                $config['root'],
                File::mimeType(...)
            );
        });
    }
}
