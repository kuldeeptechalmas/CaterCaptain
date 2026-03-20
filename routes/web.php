<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('logins');
});

Route::middleware('guest')->group(function (): void {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('logins');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.submit');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/notifications', [AuthController::class, 'notifications'])->name('notifications');
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/material-report', [AuthController::class, 'materialReport'])->name('material.report');
    Route::get('/material-report/pdf', [AuthController::class, 'materialReportPdf'])->name('material.report.pdf');
    Route::get('/material-report/pdf/download', [AuthController::class, 'materialReportPdfDownload'])->name('material.report.pdf.download');

    Route::get('/petty-cash-report', [AuthController::class, 'pettyCashReport'])->name('petty-cash.report');
    Route::get('/petty-cash-report/pdf', [AuthController::class, 'pettyCashReportPdf'])->name('petty-cash.report.pdf');
    Route::get('/petty-cash-report/pdf/download', [AuthController::class, 'pettyCashReportPdfDownload'])->name('petty-cash.report.pdf.download');
    Route::post('/petty-cash-issue', [AuthController::class, 'pettyCashIssueStore'])->name('petty-cash.issue.store');

    Route::middleware('superadmincheck')->group(function (): void {
        Route::get('/hq-profile', [AuthController::class, 'hqProfile'])->name('hq.profile');
        Route::get('/gst-settings', [AuthController::class, 'gstSettings'])->name('gst.settings');
        Route::get('/staff-management', [AuthController::class, 'staffManagement'])->name('staff.management');

        Route::get('/units', [AuthController::class, 'unitsIndex'])->name('masters.units');
        Route::get('/categories', [AuthController::class, 'categoriesIndex'])->name('masters.categories');
        Route::get('/dishes', [AuthController::class, 'dishesIndex'])->name('masters.dishes');
        Route::get('/event-types', [AuthController::class, 'eventTypesIndex'])->name('masters.event-types');
    });


    Route::get('/wastege-record', [AuthController::class, 'wastegeRecord'])->name('wastege.record');
    Route::get('/wastage/pdf/download', [AuthController::class, 'wastagePdfDownload'])->name('wastage.pdf.download');
    Route::get('/material-pricing', [AuthController::class, 'materialPricing'])->name('material.pricing');
    Route::get('/material-pricing/pdf/download', [AuthController::class, 'materialPricingPdfDownload'])->name('material.pricing.pdf.download');


    Route::get('/inventory', [AuthController::class, 'inventoryManagement'])->name('inventory.management');
    Route::get('/inventory/pdf', [AuthController::class, 'inventoryManagementPdf'])->name('inventory.management.pdf');
    Route::get('/inventory/pdf/download', [AuthController::class, 'inventoryManagementPdfDownload'])->name('inventory.management.pdf.download');


    // Material Request Route
    Route::get('/material-request', [AuthController::class, 'materialRequest'])->name('material.request');
});
