<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTermDeactivation
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $deactivationDate = SystemSetting::get('deactivation_date', '');
            $alreadyDone      = SystemSetting::get('deactivation_done', '0');

            if (! empty($deactivationDate) && $alreadyDone !== '1') {
                if (now()->toDateString() >= $deactivationDate) {
                    // Use DB transaction to prevent race condition on simultaneous requests
                    \Illuminate\Support\Facades\DB::transaction(function () {
                        // Re-check inside transaction to prevent double-fire
                        $done = SystemSetting::where('key', 'deactivation_done')->value('value');
                        if ($done !== '1') {
                            User::where('roles', 'user')
                                ->where('is_active', true)
                                ->update(['is_active' => false]);
                            SystemSetting::set('deactivation_done', '1');
                        }
                    });
                }
            }
        } catch (\Exception $e) {
            // Never block admin access
            \Illuminate\Support\Facades\Log::error('CheckTermDeactivation failed: ' . $e->getMessage());
        }

        return $next($request);
    }
}
