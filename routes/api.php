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
        UserController
    };

    // USERS
    Route::apiResource('users', UserController::class);

    // PROPERTIES
    Route::apiResource('properties', PropertyController::class);

    // CONTRACTS
    Route::apiResource('contracts', ContractController::class);

    // PAYMENTS
    Route::apiResource('payments', PaymentController::class);

    // RATINGS
    Route::apiResource('ratings', RatingController::class);

    // MAINTENANCES
    Route::apiResource('maintenances', MaintenanceController::class);

    // REPORTS
    Route::apiResource('reports', ReportController::class);

    // RENTAL REQUESTS
    Route::apiResource('rental-requests', RentalRequestController::class);
