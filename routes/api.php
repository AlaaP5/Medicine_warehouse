<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\BothController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ManufactureContorller;
use App\Http\Controllers\OrderContorller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('loginAdmin', [AdminController::class, 'login']);

Route::post('RegisterUser', [UserController::class, 'register']);
Route::post('loginUser', [UserController::class, 'login']);


Route::middleware('auth:api')->group(function () {

    //both action
    Route::prefix('category')->group(function () {

        Route::get('all', [ManufactureContorller::class, 'all']);
        Route::get('content/{id}', [ManufactureContorller::class, 'showDrugsByCategory']);
        Route::get('search/{name?}', [ManufactureContorller::class, 'search']);

    });
    
    Route::prefix('drug')->group(function () {

        Route::get('search/{name?}', [DrugController::class, 'search']);
        Route::get('show/{id}', [DrugController::class, 'show']);

    });

    Route::get('order/show/{id}', [OrderContorller::class, 'show']);

    //admin action
    Route::middleware('check_Admin')->group(function () {

        Route::prefix('order')->group(function () {

            Route::get('all', [OrderContorller::class, 'all']);
            Route::post('editStatus', [OrderContorller::class, 'editStatus']);
            Route::post('editPayment', [OrderContorller::class, 'paymentStatus']);
            
        });
        Route::post('sentNot',[AdminController::class, 'sentNot']);
        Route::post('drug/store', [DrugController::class, 'store']);
        Route::get('logoutAdmin', [BothController::class, 'logout']);
    });

    //pharmacist action
    Route::middleware('check_pharmacist')->group(function () {

        Route::prefix('order')->group(function () {

            Route::post('add', [OrderContorller::class, 'add']);
            Route::get('my_order', [OrderContorller::class, 'myOrders']);
            Route::post('history',[OrderContorller::class, 'history']);
        });

        Route::prefix('favorite')->group(function () {

            Route::post('add', [FavoriteController::class, 'add']); 
            Route::post('delete', [FavoriteController::class, 'delete']);
            Route::get('index', [FavoriteController::class, 'index']);
        });

        Route::get('userinfo', [UserController::class, 'info']);
        Route::get('logoutUser', [BothController::class, 'logout']);
    });
});
