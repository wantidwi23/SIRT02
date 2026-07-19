<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GeminiChatbotService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GeminiChatbotService::class, function ($app) {
            return new GeminiChatbotService();
        });
    }

    public function boot(): void
    {
        //
    }
}
