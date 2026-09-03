<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $maintenance = SystemSetting::get('maintenance_mode', '0');
            if ($maintenance === '1') {
                return response()->view('maintenance', [], 503);
            }
        } catch (\Exception $e) {
            // DB not ready — allow through
        }

        return $next($request);
    }
}
