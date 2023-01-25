<?php

use App\Http\Controllers\AdditionController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\SnackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function(){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/food/get', [FoodController::class, 'getAllProducts'])->name('food.get');
    Route::get('/drink/get', [DrinkController::class, 'getAllProducts'])->name('drinks.get');
    Route::get('/snack/get', [SnackController::class, 'getAllProducts'])->name('snacks.get');
    Route::get('/other/get', [OtherController::class, 'getAllProducts'])->name('others.get');
    Route::get('/food/add/{food}/', [FoodController::class, 'addProductToOrder'])->name('food.add');
    Route::get('/drinks/add/{drink}', [DrinkController::class, 'addProductToOrder'])->name('drinks.add');
    Route::get('/snacks/add/{snack}', [SnackController::class, 'addProductToOrder'])->name('snacks.add');
    Route::get('/other/add/{other}', [OtherController::class, 'addProductToOrder'])->name('other.add');
    Route::post('/product/increase', [OrderController::class, 'increaseAmount'])->name('amount.increase');
    Route::post('/product/decrease', [OrderController::class, 'decreaseAmount'])->name('amount.decrease');
    Route::post('/product/remove', [OrderController::class, 'removeProduct'])->name('product.remove');
    Route::post('/food/add/addition', [FoodController::class, 'addAddition'])->name('addition.food.add');
    Route::post('/snack/add/addition', [SnackController::class, 'addAddition'])->name('addition.snacks.add');
    Route::post('/food/add/product/additions/{food}', [FoodController::class, 'addProductWithAdditionsToOrder'])->name('food.add.with.additions');
    Route::post('/snack/add/product/additions/{snack}', [SnackController::class, 'addProductWithAdditionsToOrder'])->name('snack.add.with.additions');
    Route::get('/order/show_current', [OrderController::class, 'showCurrentOrder'])->name('order.show_current');



    Route::resource('/food', FoodController::class);
    Route::resource('/drink', DrinkController::class);
    Route::resource('/snack', SnackController::class);
    Route::resource('/other', OtherController::class);
    Route::resource('/order', OrderController::class);
    Route::resource('/addition', AdditionController::class);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


Auth::routes();
Route::get('/auth/google/login', [SocialLoginController::class, 'initGoogleLogin'])->name('google.login');
Route::get('/auth/google/login/callback', [SocialLoginController::class, 'googleLoginCallback'])->name('google.login.callback');

