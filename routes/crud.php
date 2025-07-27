<?php

          Route::group(['as'=>'admin.', 'prefix' => 'admin', 'middleware' => 'auth:admin' ], function(){
          Route::resource('dinning-months', \App\Http\Controllers\Admin\DinningMonthController::class);
          Route::resource('dinning-students', \App\Http\Controllers\Admin\DinningStudentController::class);
          Route::resource('student-sessions', \App\Http\Controllers\Admin\StudentSessionController::class);
          Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class);
          Route::resource('meals', \App\Http\Controllers\Admin\MealController::class);
          Route::resource('meal-tokens', \App\Http\Controllers\Admin\MealTokenController::class);
          Route::resource('refund-requests', \App\Http\Controllers\Admin\RefundRequestController::class);
          Route::resource('today-meals', \App\Http\Controllers\Admin\RefundMealController::class);
          Route::resource('monthly-meal-details', \App\Http\Controllers\Admin\MonthlyMealDetailController::class);

          });
   