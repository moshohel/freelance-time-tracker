<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Define rate limits for API routes
        RateLimiter::for('api-authenticated', function ($request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
        // Define rate limits for web routes
        RateLimiter::for('web', function () {
            return Limit::perMinute(100); // Allow 100 requests per minute
        });

        parent::boot();
    }
}
