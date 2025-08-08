<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Paginator::useBootstrap(4);
        app(SettingsService::class)->setGlobalSettings();

        // $keys = ['pusher_app_id', 'pusher_cluster', 'pusher_key', 'pusher_secret'];
        // $pusherConf = Setting::whereIn('key', $keys)->pluck('value', 'key');

        config(['broadcasting.connections.pusher.key' => config('settings.pusher_key')]);
        config(['broadcasting.connections.pusher.secret' => config('settings.pusher_secret')]);
        config(['broadcasting.connections.pusher.app_id' => config('settings.pusher_app_id')]);
        config(['broadcasting.connections.pusher.options.cluster' => config('settings.pusher_cluster')]);
    }
}