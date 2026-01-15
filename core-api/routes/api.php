<?php

use App\Http\Controllers\App\AppointmentsController;
use App\Http\Controllers\App\CustomersController;
use App\Http\Controllers\App\TransactionsController;
use App\Http\Controllers\Billing\WebhookController;
use App\Http\Middleware\EnsureTenantIsActiveMiddleware;
use App\Http\Middleware\TenantResolverMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('api/master')->group(function () {
    Route::post('auth/login', fn () => response()->json(['token' => 'master-token']));
    Route::get('tenants', fn () => response()->json(['data' => []]));
    Route::post('tenants', fn () => response()->json(['data' => []], 201));
    Route::patch('tenants/{id}', fn () => response()->json(['data' => []]));
    Route::get('plans', fn () => response()->json(['data' => []]));
    Route::post('plans', fn () => response()->json(['data' => []], 201));
    Route::get('subscriptions', fn () => response()->json(['data' => []]));
    Route::post('subscriptions/{tenant}/start', fn () => response()->json(['data' => []]));
    Route::post('subscriptions/{tenant}/cancel', fn () => response()->json(['data' => []]));
    Route::get('charges', fn () => response()->json(['data' => []]));
});

Route::prefix('api/app')
    ->middleware([TenantResolverMiddleware::class, EnsureTenantIsActiveMiddleware::class])
    ->group(function () {
        Route::post('auth/login', fn () => response()->json(['token' => 'tenant-token']));
        Route::get('me', fn () => response()->json(['data' => []]));
        Route::apiResource('customers', CustomersController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::apiResource('appointments', AppointmentsController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::apiResource('transactions', TransactionsController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
        Route::get('settings', fn () => response()->json(['data' => []]));
        Route::put('settings', fn () => response()->json(['data' => []]));
    });

Route::post('api/billing/webhook/{gateway}', WebhookController::class);
