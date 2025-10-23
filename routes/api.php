<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MaintenanceController,
    ContractController,
    PaymentController,
    PropertyController,
    RatingController,
    RentalRequestController,
    ReportController,
    UserController,
    AuthController
};

// ============================================
// 🌐 API V1 BASE
// ============================================
Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('auth.register');
        Route::post('login', 'login')->name('auth.login');
    });

    Route::middleware(['jwt.auth'])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('profile', 'profile')->name('auth.profile');
            Route::post('logout', 'logout')->name('auth.logout');
            Route::post('refresh', 'refresh')->name('auth.refresh');
        });

        Route::apiResources([
            'users' => UserController::class,
            'properties' => PropertyController::class,
            'contracts' => ContractController::class,
            'payments' => PaymentController::class,
            'ratings' => RatingController::class,
            'maintenances' => MaintenanceController::class,
            'reports' => ReportController::class,
            'rental-requests' => RentalRequestController::class,
        ]);
    });
});

