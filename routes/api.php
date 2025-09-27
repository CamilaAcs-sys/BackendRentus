<?php

use Illuminate\Http\Request;

use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RentalRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas de la API

// USERS
Route::get('users', [UserController::class, 'index']);         // Listar todos
Route::post('users', [UserController::class, 'store']);        // Crear nuevo
Route::get('users/{id}', [UserController::class, 'show']);     // Ver uno
Route::put('users/{id}', [UserController::class, 'update']);   // Actualizar
Route::delete('users/{id}', [UserController::class, 'destroy']); // Eliminar

// PROPERTIES
Route::get('properties', [PropertyController::class, 'index']);
Route::post('properties', [PropertyController::class, 'store']);
Route::get('properties/{id}', [PropertyController::class, 'show']);
Route::put('properties/{id}', [PropertyController::class, 'update']);
Route::delete('properties/{id}', [PropertyController::class, 'destroy']);

// CONTRACTS
Route::get('contracts', [ContractController::class, 'index']);
Route::post('contracts', [ContractController::class, 'store']);
Route::get('contracts/{id}', [ContractController::class, 'show']);
Route::put('contracts/{id}', [ContractController::class, 'update']);
Route::delete('contracts/{id}', [ContractController::class, 'destroy']);

// PAYMENTS
Route::get('payments', [PaymentController::class, 'index']);
Route::post('payments', [PaymentController::class, 'store']);
Route::get('payments/{id}', [PaymentController::class, 'show']);
Route::put('payments/{id}', [PaymentController::class, 'update']);
Route::delete('payments/{id}', [PaymentController::class, 'destroy']);

// RATINGS
Route::get('ratings', [RatingController::class, 'index']);
Route::post('ratings', [RatingController::class, 'store']);
Route::get('ratings/{id}', [RatingController::class, 'show']);
Route::put('ratings/{id}', [RatingController::class, 'update']);
Route::delete('ratings/{id}', [RatingController::class, 'destroy']);

// MAINTENANCES
Route::get('maintenances', [MaintenanceController::class, 'index']);
Route::post('maintenances', [MaintenanceController::class, 'store']);
Route::get('maintenances/{id}', [MaintenanceController::class, 'show']);
Route::put('maintenances/{id}', [MaintenanceController::class, 'update']);
Route::delete('maintenances/{id}', [MaintenanceController::class, 'destroy']);

// REPORTS
Route::get('reports', [ReportController::class, 'index']);
Route::post('reports', [ReportController::class, 'store']);
Route::get('reports/{id}', [ReportController::class, 'show']);
Route::put('reports/{id}', [ReportController::class, 'update']);
Route::delete('reports/{id}', [ReportController::class, 'destroy']);

// RENTAL REQUESTS
Route::get('rental-requests', [RentalRequestController::class, 'index']);
Route::post('rental-requests', [RentalRequestController::class, 'store']);
Route::get('rental-requests/{id}', [RentalRequestController::class, 'show']);
Route::put('rental-requests/{id}', [RentalRequestController::class, 'update']);
Route::delete('rental-requests/{id}', [RentalRequestController::class, 'destroy']);
