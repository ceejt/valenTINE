<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProposalController;

// Proposal routes
Route::prefix('proposal')->group(function () {
    Route::post('/choice', [ProposalController::class, 'storeChoice']);
    Route::get('/choices', [ProposalController::class, 'getChoices']);
});

// Health check
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});