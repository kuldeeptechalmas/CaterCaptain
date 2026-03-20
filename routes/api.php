<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\MastersController;
use App\Http\Controllers\Api\PettyCashController;
use App\Http\Controllers\api\RawMaterialController;
use App\Http\Controllers\api\StaffController;
use App\Http\Controllers\PettyCash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Route::get('/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [AuthController::class, 'currentUser']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {

    // Dashboard
    Route::post('/dashboard', [AuthController::class, 'dashboard']);

    Route::middleware('role:catercaptain')->group(function () {
        // Raw Material Request
        Route::post('/raw-material-request', [RawMaterialController::class, 'rawMaterialRequest']);
    });

    Route::middleware('role:superadmin')->group(function () {

        // Raw Material Request Decision
        Route::post('/raw-material-request-decision', [RawMaterialController::class, 'rawMaterialRequestDecision']);

        // Raw Material
        Route::post('/raw-material-add', [RawMaterialController::class, 'rawMaterialAdd']);
        Route::post('/raw-material-price-add', [RawMaterialController::class, 'rawMaterialPriceAdd']);
        Route::post('/raw-material-list', [RawMaterialController::class, 'showRawMaterialList']);
        Route::post('/raw-material-moments', [RawMaterialController::class, 'rawMaterialMoments']);


        // Staff Managenet
        Route::post('/staff-add', [StaffController::class, 'staffAdd']);
        Route::post('/staff-modify', [StaffController::class, 'staffModify']);
        Route::post('/staff-remove', [StaffController::class, 'staffRemove']);

        // Masters API
        // Dishes
        Route::post('/dish-add', [MastersController::class, 'dishesAdd']);
        Route::post('/dish-remove', [MastersController::class, 'dishesRemove']);
        Route::post('/dish-modify', [MastersController::class, 'dishesModify']);

        // Categories
        Route::post('/categories-add', [MastersController::class, 'categoriesAdd']);
        Route::post('/categories-remove', [MastersController::class, 'categoriesRemove']);
        Route::post('/categories-modify', [MastersController::class, 'categoriesModify']);

        // Units
        Route::post('/unit-add', [MastersController::class, 'unitAdd']);
        Route::post('/unit-remove', [MastersController::class, 'unitRemove']);
        Route::post('/unit-modify', [MastersController::class, 'unitModify']);

        // Event Type
        Route::post('/event-type-add', [MastersController::class, 'eventTypeAdd']);
        Route::post('/event-type-remove', [MastersController::class, 'eventTypeRemove']);
        Route::post('/event-type-modify', [MastersController::class, 'eventTypeModify']);
    });

    // Wastage Entery
    Route::post('/wastage-entery', [EventController::class, 'wastageRawMaterial']);

    // Event
    Route::post('/event', [EventController::class, 'eventAddInfo']);
    Route::post('/event-service', [EventController::class, 'eventServiceInfo']);
    Route::post('/event-manu-item', [EventController::class, 'eventMenuItems']);
    Route::post('/event-raw-material', [EventController::class, 'eventRawMaterial']);
    Route::post('/event-service-remove/{id}', [EventController::class, 'eventServiceRemove']);

    // Petty Cash
    Route::post('/petty-cash-dashboard', [PettyCashController::class, 'pettyCashDashboard']);

    // Issue
    Route::post('/petty-cash-issue', [PettyCashController::class, 'pettyCashAdd']);
    Route::post('/petty-cash-issue-remove', [PettyCashController::class, 'pettyCashRemove']);
    Route::post('/petty-cash-issue-list', [PettyCashController::class, 'pettyCashShowList']);

    // Spend
    Route::post('/petty-cash-spend', [PettyCashController::class, 'pettyCashSpend']);
    Route::post('/petty-cash-spend-remove', [PettyCashController::class, 'pettyCashSpendRemove']);
    Route::post('/petty-cash-spend-list', [PettyCashController::class, 'pettyCashSpendList']);
});


Route::post('/raw-material-stock', [RawMaterialController::class, 'RawMaterialStock']);
