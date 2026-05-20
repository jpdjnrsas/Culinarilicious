<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| HOME REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard');
})->name('home');

/*
|--------------------------------------------------------------------------
| BUYER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AccountController::class, 'index']);
    Route::post('/account/update', [AccountController::class, 'update']);
    Route::post('/account/password', [AccountController::class, 'updatePassword']);
    Route::get('/foods', [FoodController::class, 'index']);

    Route::post('/cart/add/{id}', [FoodController::class, 'addToCart']);
    Route::get('/cart', [FoodController::class, 'cart']);
    Route::post('/checkout', [FoodController::class, 'checkout']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::get('/orders', [OrderController::class, 'myOrders']);
    Route::post('/reviews', [OrderController::class, 'storeReview']);
    Route::get('/orders/{id}/receipt', [OrderController::class, 'receipt']);
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::get('/foods', [AdminController::class, 'foods']);
    Route::post('/foods', [AdminController::class, 'storeFood']);

    Route::get('/foods/{id}/edit', [FoodController::class, 'edit']);
    Route::post('/foods/{id}/update', [FoodController::class, 'update']);

    Route::get('/orders', [AdminController::class, 'orders']);
    Route::get('/orders/{id}', [AdminController::class, 'showOrder']);
    Route::post('/orders/{id}/assign', [AdminController::class, 'assignRider']);

    Route::get('/sales', [AdminController::class, 'sales']);
    Route::get('/reviews', [AdminController::class, 'reviews']);
    Route::get('/foods/create', [FoodController::class, 'create']);
    Route::delete('/foods/{id}', [FoodController::class, 'destroy'])->name('food.destroy');
    Route::get('/foods/delete-page', [AdminController::class, 'deleteFoods']);
});
/*
|--------------------------------------------------------------------------
| RIDER ROUTES (✅ FIXED - THIS REMOVES YOUR 404)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:rider'])->prefix('rider')->group(function () {
    Route::get('/orders', [RiderController::class, 'orders']);
    Route::post('/orders/{id}/update', [RiderController::class, 'updateStatus']);
    Route::get('/orders/{id}', [RiderController::class, 'show']);
});