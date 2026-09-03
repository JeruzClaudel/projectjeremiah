<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminHotlineController;
use App\Http\Controllers\Admin\AdminServicesController;
use App\Http\Controllers\Admin\AdminConsultationController;
use App\Http\Controllers\Admin\AdminCounselorController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\FreedomwallController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\User\HotlineController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\AdminSupportResourceController;
use App\Http\Controllers\Admin\AdminResourceController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\Auth\StudentReactivateController;



Route::middleware(['check-admin', 'check-maintenance'])
    ->get('/', [HomeController::class, 'index'])
    ->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/* STUDENT AUTH */
Route::middleware('check-maintenance')->group(function () {
    Route::get('student/register', [StudentAuthController::class, 'showRegister'])->name('student.register');
    Route::post('student/register',[StudentAuthController::class, 'register'])->name('student.register.post')->middleware('throttle:10,1');
    Route::get('student/register/verify', [StudentAuthController::class, 'showRegisterVerify'])->name('student.register.verify');
    Route::post('student/register/verify', [StudentAuthController::class, 'verifyRegisterOtp'])->name('student.register.verify.post')->middleware('throttle:10,1');
    Route::post('student/register/resend', [StudentAuthController::class, 'resendRegisterOtp'])->name('student.register.resend')->middleware('throttle:5,1');

    /* OTP Reactivation */
    Route::get('student/reactivate',         [StudentReactivateController::class, 'showRequest'])->name('student.reactivate.request');
    Route::post('student/reactivate/send',   [StudentReactivateController::class, 'sendOtp'])->name('student.reactivate.send')->middleware('throttle:10,1');
    Route::get('student/reactivate/verify',  [StudentReactivateController::class, 'showVerify'])->name('student.reactivate.verify');
    Route::post('student/reactivate/verify', [StudentReactivateController::class, 'verifyOtp'])->name('student.reactivate.verify.post')->middleware('throttle:10,1');
    Route::post('student/reactivate/resend', [StudentReactivateController::class, 'resendOtp'])->name('student.reactivate.resend')->middleware('throttle:5,1');
});

Route::redirect('gsoadmin', 'admin/dashboard');

Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'verified', 'can:allow_admin', 'check-term'])->group(function() {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    /* HOTLINE */
    Route::get('hotlines', [AdminHotlineController::class, 'index'])->name('admin.hotline.dashboard');
    Route::get('hotlines/add', [AdminHotlineController::class, 'add'])->name('admin.hotline.add');
    Route::get('hotlines/{id}/edit', [AdminHotlineController::class, 'edit'])->name('admin.hotline.edit');
    Route::get('hotlines/{id}', [AdminHotlineController::class, 'show'])->name('admin.hotline.details');
    Route::post('hotlines/add', [AdminHotlineController::class, 'store']);
    Route::put('hotlines/{id}', [AdminHotlineController::class, 'update']);
    Route::delete('hotlines/{id}', [AdminHotlineController::class, 'delete'])->name('admin.hotline.delete');

    /* CONSULTATION */
    Route::get('consultation', [AdminConsultationController::class, 'index'])->name('admin.consultation.dashboard');
    Route::get('consultation/add', [AdminConsultationController::class, 'add'])->name('admin.consultation.add');
    Route::get('consultation/{id}/edit', [AdminConsultationController::class, 'edit'])->name('admin.consultation.edit');
    Route::get('consultation/{id}', [AdminConsultationController::class, 'show'])->name('admin.consultation.details');
    Route::post('consultation/add', [AdminConsultationController::class, 'store']);
    Route::put('consultation/{id}', [AdminConsultationController::class, 'update']);
    Route::delete('consultation/{id}', [AdminConsultationController::class, 'delete'])->name('admin.consultation.delete');

    /* SERVICES */
    Route::get('services', [AdminServicesController::class, 'indexService'])->name('admin.services.dashboard');
    Route::get('services/add', [AdminServicesController::class, 'addService'])->name('admin.services.add');
    Route::get('services/{id}/edit', [AdminServicesController::class, 'editService'])->name('admin.services.edit');
    Route::get('services/{id}', [AdminServicesController::class, 'showService'])->name('admin.services.details');
    Route::post('services/add', [AdminServicesController::class, 'store'])->name('admin.services.store');
    Route::put('services/{id}', [AdminServicesController::class, 'update'])->name('admin.services.update');
    Route::delete('services/{id}', [AdminServicesController::class, 'delete'])->name('admin.services.delete');

    /* COUNSELOR */
    Route::get('counselor', [AdminCounselorController::class, 'index'])->name('admin.counselor.dashboard');
    Route::get('counselor/add', [AdminCounselorController::class, 'add'])->name('admin.counselor.add');
    Route::get('counselor/export', [AdminCounselorController::class, 'export'])->name('admin.counselor.export');
    Route::post('counselor/import', [AdminCounselorController::class, 'import'])->name('admin.counselor.import');
    Route::get('counselor/{id}/edit', [AdminCounselorController::class, 'edit'])->name('admin.counselor.edit');
    Route::get('counselor/{id}', [AdminCounselorController::class, 'show'])->name('admin.counselor.details');
    Route::post('counselor/add', [AdminCounselorController::class, 'store'])->name('admin.counselor.store');
    Route::put('counselor/{id}', [AdminCounselorController::class, 'update'])->name('admin.counselor.update');
    Route::delete('counselor/{id}', [AdminCounselorController::class, 'delete'])->name('admin.counselor.delete');

    /* SAFE SPACE / e-Hayag — fixed: specific paths before {id} wildcard */
    Route::get('freedomwall', [FreedomwallController::class, 'index'])->name('admin.freedomwall.freedomwall');
    Route::get('freedomwall/analytics', [FreedomwallController::class, 'analytics'])->name('admin.freedomwall.analytics');
    Route::get('freedomwall/high-risk', [FreedomwallController::class, 'highRiskPosts'])->name('admin.freedomwall.highrisk');
    Route::get('freedomwall/export', [FreedomwallController::class, 'export'])->name('admin.freedomwall.export');
    Route::get('freedomwall/analytics-export', [FreedomwallController::class, 'analyticsExport'])->name('admin.freedomwall.analytics_export');
    Route::post('freedomwall/ai-bulk-analyze', [FreedomwallController::class, 'aiBulkAnalyze'])->name('admin.freedomwall.ai_bulk_analyze');
    Route::post('freedomwall/send-high-risk-alert', [FreedomwallController::class, 'sendHighRiskAlert'])->name('admin.freedomwall.send_alert');
    Route::get('freedomwall/{id}/details', [FreedomwallController::class, 'details'])->name('admin.freedomwall.details');
    Route::delete('freedomwall/{id}', [FreedomwallController::class, 'destroy'])->name('admin.freedomwall.destroy');
    Route::post('freedomwall/{id}/ai-analyze', [FreedomwallController::class, 'aiAnalyzePost'])->name('admin.freedomwall.ai_analyze');

    /* QUOTE */
    Route::get('quote', [QuoteController::class, 'index'])->name('admin.quote.index');
    Route::get('quote/{id}/details', [QuoteController::class, 'details'])->name('admin.quote.details');
    Route::delete('quote/{id}', [QuoteController::class, 'destroy'])->name('admin.quote.destroy');
    Route::get('quote/add', [QuoteController::class, 'add'])->name('admin.quote.add');
    Route::post('quote/add', [QuoteController::class, 'store'])->name('admin.quote.store');
    Route::put('quote/{id}', [QuoteController::class, 'update'])->name('admin.quote.update');
    Route::get('quote/{id}/edit', [QuoteController::class, 'edit'])->name('admin.quote.edit');
    Route::post('quote/ai-generate', [QuoteController::class, 'aiGenerate'])->name('admin.quote.ai_generate');

    /* LINKS */
    Route::get('links', [LinkController::class, 'index'])->name('admin.link.index');
    Route::get('links/add', [LinkController::class, 'add'])->name('admin.link.add');
    Route::post('links/add', [LinkController::class, 'store'])->name('admin.link.store');
    Route::get('links/{id}/edit', [LinkController::class, 'edit'])->name('admin.link.edit');
    Route::put('links/{id}', [LinkController::class, 'update'])->name('admin.link.update');
    Route::get('links/{id}/details', [LinkController::class, 'details'])->name('admin.link.details');
    Route::delete('links/{id}', [LinkController::class, 'destroy'])->name('admin.link.destroy');

    /* SUPPORT RESOURCES */
    Route::get('support-resources', [AdminSupportResourceController::class, 'index'])->name('admin.support.index');
    Route::get('support-resources/add', [AdminSupportResourceController::class, 'add'])->name('admin.support.add');
    Route::post('support-resources/add', [AdminSupportResourceController::class, 'store'])->name('admin.support.store');
    Route::get('support-resources/{id}/edit', [AdminSupportResourceController::class, 'edit'])->name('admin.support.edit');
    Route::put('support-resources/{id}', [AdminSupportResourceController::class, 'update'])->name('admin.support.update');
    Route::delete('support-resources/{id}', [AdminSupportResourceController::class, 'delete'])->name('admin.support.delete');
    Route::get('support-resources/{id}', [AdminSupportResourceController::class, 'show'])->name('admin.support.details');

    /* RESOURCES */
    Route::get('resources', [AdminResourceController::class, 'index'])->name('admin.resources.index');

    /* ACCOUNTS */
    Route::get('accounts', [AdminAccountController::class, 'index'])->name('admin.accounts.index');
    Route::get('accounts/create', [AdminAccountController::class, 'create'])->name('admin.accounts.create');
    Route::post('accounts', [AdminAccountController::class, 'store'])->name('admin.accounts.store');
    Route::get('accounts/{account}/edit', [AdminAccountController::class, 'edit'])->name('admin.accounts.edit');
    Route::put('accounts/{account}', [AdminAccountController::class, 'update'])->name('admin.accounts.update');
    Route::delete('accounts/{account}', [AdminAccountController::class, 'destroy'])->name('admin.accounts.destroy');

    /* SYSTEM SETTINGS */
    Route::get('settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
    Route::post('settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
    Route::post('settings/toggle-maintenance', [AdminSettingController::class, 'toggleMaintenance'])->name('admin.settings.toggle_maintenance');
    Route::post('settings/deactivate-all-students', [AdminSettingController::class, 'deactivateAllStudents'])->name('admin.settings.deactivate_students');
    Route::post('settings/activate-all-students', [AdminSettingController::class, 'activateAllStudents'])->name('admin.settings.activate_students');
    Route::post('settings/alert-recipients', [AdminSettingController::class, 'updateAlertRecipients'])->name('admin.settings.alert_recipients');

    /* STUDENT ACCOUNTS */
    Route::get('students', [AdminStudentController::class, 'index'])->name('admin.students.index');
    Route::post('students/{student}/toggle-active', [AdminStudentController::class, 'toggleActive'])->name('admin.students.toggle_active');
    Route::delete('students/{student}', [AdminStudentController::class, 'destroy'])->name('admin.students.destroy');

    /* SENTIMENT KEYWORDS */
    Route::get('sentiment-keywords', [FreedomwallController::class, 'keywords'])->name('admin.sentiment.keywords');
    Route::post('sentiment-keywords/store', [FreedomwallController::class, 'storeKeyword'])->name('admin.sentiment.keywords.store');
    Route::delete('sentiment-keywords/{id}', [FreedomwallController::class, 'deleteKeyword'])->name('admin.sentiment.keywords.delete');
    Route::put('sentiment-keywords/{id}', [FreedomwallController::class, 'updateKeyword'])->name('admin.sentiment.keywords.update');
});

/* USER / PUBLIC */
Route::middleware('check-maintenance')->group(function () {
    Route::get('hotlines', [HotlineController::class, 'index'])->name('user.hotline');
    Route::get('hotlines/{id}', [HotlineController::class, 'show'])->name('user.hotline.details');
    Route::get('freedomwall', [FreedomwallController::class, 'add'])->name('user.freedomwall.add');
    Route::get('freedomwall/create', [FreedomwallController::class, 'create'])->name('user.freedomwall.create');
    Route::post('freedomwall/add', [FreedomwallController::class, 'store'])->name('freedomwall.store')->middleware('throttle:5,1');
    Route::get('freedomwall/submitted', [FreedomwallController::class, 'submitted'])->name('user.freedomwall.submitted');

    Route::get('services', [ServicesController::class, 'index'])->name('user.services');
    Route::get('services/{id}', [ServicesController::class, 'showService'])->name('user.services.details');
    Route::get('counselors/{id}', [CounselorController::class, 'showCounselor'])->name('user.counselors.details');
});

Route::fallback(function () {
    return response()->view('fallback.index', [], 404);
});
