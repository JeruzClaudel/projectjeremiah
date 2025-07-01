<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminHotlineController;
use App\Http\Controllers\Admin\AdminServicesController;
use App\Http\Controllers\Admin\AdminConsultationController;
use App\Http\Controllers\Admin\AdminCounselorController;
use App\Http\Controllers\AdminServicesController as ControllersAdminServicesController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\FreedomwallController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\User\HotlineController;
use App\Http\Controllers\User\ServiceController;
use League\CommonMark\Extension\SmartPunct\Quote;

Route::middleware('check-admin')->get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::redirect('admin', 'admin/dashboard');

Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'verified', 'can:allow_admin'])->group(function() {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

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
    Route::get('counselor/{id}/edit', [AdminCounselorController::class, 'edit'])->name('admin.counselor.edit');
    Route::get('counselor/{id}', [AdminCounselorController::class, 'show'])->name('admin.counselor.details');
    Route::post('counselor/add', [AdminCounselorController::class, 'store'])->name('admin.counselor.store');
    Route::put('counselor/{id}', [AdminCounselorController::class, 'update'])->name('admin.counselor.update');
    Route::delete('counselor/{id}', [AdminCounselorController::class, 'delete'])->name('admin.counselor.delete');
    
    
    /* SAFE SPACE */
    Route::get('freedomwall', [FreedomwallController::class, 'index'])->name('admin.freedomwall.freedomwall');
    Route::get('/freedomwall/{id}/details', [FreedomwallController::class, 'details'])->name('admin.freedomwall.details');
    Route::delete('/freedomwall/{id}', [FreedomwallController::class, 'destroy'])->name('admin.freedomwall.destroy');

    /* QUOTE */
    Route::get('/quote', [QuoteController::class, 'index'])->name('admin.quote.index');
    Route::get('/quote/{id}/details', [QuoteController::class, 'details'])->name('admin.quote.details');
    Route::delete('/quote/{id}', [QuoteController::class, 'destroy'])->name('admin.quote.destroy');
    Route::get('quote/add', [QuoteController::class, 'add'])->name('admin.quote.add');
    Route::post('quote/add', [QuoteController::class, 'store'])->name('admin.quote.store');
    Route::put('quote/{id}', [QuoteController::class, 'update'])->name('admin.quote.update');
    Route::get('quote/{id}/edit', [QuoteController::class, 'edit'])->name('admin.quote.edit');

    
});


/* USER */
Route::namespace('User')->prefix('/')->group(function() {
    Route::get('hotlines', [HotlineController::class, 'index'])->name('user.hotline');
    Route::get('hotlines/{id}', [HotlineController::class, 'show'])->name('user.hotline.details');
    Route::get('freedomwall/add', [FreedomwallController::class, 'add'])->name('user.freedomwall.add');
    Route::get('freedomwall', [FreedomwallController::class, 'index'])->name('user.freedomwall.index');
    Route::get('freedomwall/create', [FreedomwallController::class, 'create'])->name('user.freedomwall.create');
    Route::post('freedomwall/add', [FreedomwallController::class, 'store'])->name('freedomwall.store');
    Route::get('freedomwall/submitted', [FreedomwallController::class, 'submitted'])->name('user.freedomwall.submitted');
    
    
    Route::get('services', [ServicesController::class, 'index'])->name('user.services');
    Route::get('/services/{id}', [ServicesController::class, 'showService'])->name('user.services.details');
    Route::get('/counselors/{id}', [CounselorController::class, 'showCounselor'])->name('user.counselors.details');

});
