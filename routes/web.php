<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::controller('ShopController')->prefix('shops')->as('shops.')->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/{shop}', 'show')->name('show');
});

Route::controller('ShoppingCartController')->prefix('shopping-cart')->as('shoppingCart.')->group(function(){
    Route::get('/show', 'show')->name('show');
    Route::post('/add-to-cart/{product}', 'add')->name('add');
    Route::patch('/update-cart', 'update')->name('update');
    Route::delete('/remove-from-cart', 'remove')->name('remove');
});

Route::controller('OrderController')->prefix('orders')->as('orders.')->group(function(){
    Route::get('/', 'myOrders')->name('myOrders');
    Route::post('/generate', 'generate')->name('generate');
    Route::get('/{order}', 'show')->name('show');
});