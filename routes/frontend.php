<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\MyDinningController;
use App\Http\Controllers\Frontend\StudentMealController;
use App\Http\Controllers\Frontend\StudentRefundRequestController;

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Available Meal Selection
// Route::middleware('auth')->prefix('student')->group(function () {
//     Route::get('/meal-selection', [::class, 'showMealSelection'])->name('student.meal.select');
//     Route::post('/meal-selection', [StudentMealController::class, 'storeMealSelection'])->name('student.meal.store');
// });


Route::group(['as' => 'student.', 'prefix' => 'student', 'middleware' => 'auth'], function () {
    Route::resource('select-meals', StudentMealController::class);
    Route::get('my-dinning', [MyDinningController::class, 'index'])->name('my-dinning');

    Route::get('refund-request', [StudentRefundRequestController::class, 'index'])->name('refund-request.index');
    Route::post('refund-request', [StudentRefundRequestController::class, 'store'])->name('refund-request.store');
    Route::get('monthly-meal-details', [StudentMealController::class, 'monthlyMealDetails'])->name('monthly-meal-details');
    Route::get('daily-meal-details/{date}', [StudentMealController::class, 'dailyMealDetails'])->name('daily-meal-details');

    

});

