<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Counselor;
use App\Models\Admin\Hotline;
use App\Models\Admin\Services;
use App\Models\FreedomWall;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPosts       = FreedomWall::count();
        $todayPosts       = FreedomWall::whereDate('created_at', today())->count();
        $highRiskToday    = FreedomWall::where(function($q) {
            $q->where('sentiment', 'high_risk')
              ->orWhere('ai_sentiment', 'high_risk')
              ->orWhere('ai_flagged', true);
        })->whereDate('created_at', today())->count();
        $totalCounselors  = Counselor::count();
        $totalStudents    = User::where('roles', 'user')->count();
        $activeStudents   = User::where('roles', 'user')->where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'totalPosts', 'todayPosts', 'highRiskToday',
            'totalCounselors', 'totalStudents', 'activeStudents'
        ));
    }
}
