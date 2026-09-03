<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\User;
use App\Models\Admin\Link;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Admin gate — requires role=admin AND active account
        Gate::define('allow_admin', function (User $user) {
            return $user->roles === 'admin' && $user->is_active !== false;
        });

        // Share active quick links with the public user layout
        // so they appear in the footer on every public page
        View::composer('layouts.user', function ($view) {
            try {
                $footerLinks = Link::where('is_active', true)->latest()->get();
            } catch (\Exception $e) {
                $footerLinks = collect();
            }
            $view->with('footerLinks', $footerLinks);
        });

        // Share today's high-risk count with the admin layout for the sidebar bubble
        View::composer('layouts.app', function ($view) {
            try {
                $highRiskTodayCount = \App\Models\FreedomWall::where(function ($q) {
                    $q->where('sentiment', 'high_risk')
                      ->orWhere('ai_sentiment', 'high_risk')
                      ->orWhere('ai_flagged', true);
                })->whereDate('created_at', now()->toDateString())->count();
            } catch (\Exception $e) {
                $highRiskTodayCount = 0;
            }
            $view->with('highRiskTodayCount', $highRiskTodayCount);
        });
    }
}
