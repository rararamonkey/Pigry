<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| 会員登録（未ログインのみ）
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/register/step1', [RegisterController::class, 'index']);
    Route::post('/register/step1', [RegisterController::class, 'confirm']);

    Route::get('/register/step2', [RegisterController::class, 'step2']);
    Route::post('/register/step2', [RegisterController::class, 'store']);

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| ログイン後のみ
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 目標体重（先に書く）
    |--------------------------------------------------------------------------
    */
    Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'goalSetting'])
        ->name('goal.setting');

    Route::post('/weight_logs/goal_setting', [WeightLogController::class, 'updateTarget'])
        ->name('goal.update');

    /*
    |--------------------------------------------------------------------------
    | 🔥 検索（これ先に書く）
    |--------------------------------------------------------------------------
    */
    Route::get('/weight_logs/search', [WeightLogController::class, 'search']);

    /*
    |--------------------------------------------------------------------------
    | 体重ログ
    |--------------------------------------------------------------------------
    */
    Route::get('/weight_logs', [WeightLogController::class, 'index']);
    Route::post('/weight_logs', [WeightLogController::class, 'store']);
    Route::put('/weight_logs/{id}', [WeightLogController::class, 'update']);
    Route::delete('/weight_logs/{id}', [WeightLogController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | ログアウト
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/register/step1');
    })->name('logout');
});