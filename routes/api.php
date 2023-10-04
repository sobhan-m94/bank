<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Middleware\ConvertNumbersToEnglish;
use App\Http\Middleware\LoginUsingId;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([ConvertNumbersToEnglish::class, LoginUsingId::class])->get('withdraw', [TransactionController::class, 'withdraw']);
Route::get('/report/most-active-users', [ReportController::class, 'mostActiveUsers']);
