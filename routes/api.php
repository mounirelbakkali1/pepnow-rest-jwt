<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlanteController;
use Illuminate\Support\Facades\Route;






Route::group(['prefix'=>'v1'],function (){
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('users/{user}', 'userInfo');
        Route::put('users/{user}', 'updateUser');
        Route::get('users/{user}', 'userInfo');
        Route::post('users/{user}/password', 'resetPassword');

    });

    Route::apiResource('plantes', PlanteController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::get('categories/{category}/plantes',[CategoryController::class,'getPlantesByCategory']);
});

