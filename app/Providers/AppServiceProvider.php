<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Gate;
use App\Models\Berita;
use App\Policies\BeritaPolicy;

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
    public function boot() 
    {
        // Register policies
        Gate::policy(Berita::class, BeritaPolicy::class);
        
        Storage::extend('local', function ($app, $config) {
            $adapter = new LocalFilesystemAdapter(
                $config['root']
            );
            
            return new \Illuminate\Filesystem\FilesystemAdapter(
                new Filesystem($adapter, $config),
                $adapter,
                $config
            );
        });
    }
}