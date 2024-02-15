<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WdController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\SnackController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\OrderDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]); // Consider enabling verification if not already done

// Shared Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('user', UserController::class)->except(['create', 'store']); // Assuming 'user' creation is managed elsewhere
});

// Pengelola Specific Routes
Route::middleware(['auth', 'pengelola'])->group(function () {
    Route::get('/homeuser', [HomeController::class, 'homeuser'])->name('homeuser');
    Route::resource('food', FoodController::class);
    Route::resource('drink', DrinkController::class);
    Route::resource('snack', SnackController::class);
    Route::resource('order', OrderController::class);
    Route::post('order.checksaldo', [OrderController::class, 'checkSaldo'])->name('order.checksaldo');
    Route::get('order.report', [OrderController::class, 'report'])->name('order.report');

    // Status Update Routes
    Route::post('/update-food-status/{id}', [FoodController::class, 'updateStatus'])->name('food.updateStatus');
    Route::post('/update-drink-status/{id}', [DrinkController::class, 'updateStatus'])->name('drink.updateStatus');
    Route::post('/update-snack-status/{id}', [SnackController::class, 'updateStatus'])->name('snack.updateStatus');
});

// Admin Specific Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin', AdminController::class);
    Route::get('admin.user', [AdminController::class, 'user'])->name('admin.user');
    Route::get('admin.user.topup', [AdminController::class, 'topup'])->name('admin.user.topup');
    Route::post('admin.user.topupstore', [AdminController::class, 'topupstore'])->name('admin.user.topupstore');
    Route::get('admin.canteen', [AdminController::class, 'canteen'])->name('admin.canteen');
    Route::get('admin.canteen.wd', [AdminController::class, 'wd'])->name('admin.canteen.wd');
    Route::post('admin.canteen.wdstore', [AdminController::class, 'wdstore'])->name('admin.canteen.wdstore');
    Route::post('admin.user.checksaldo', [AdminController::class, 'checkSaldo'])->name('admin.user.checksaldo');
    // Topup and Withdrawal (Wd) Management
    Route::resource('topup', TopupController::class);
    // Route::resource('wd', WdController::class);
    Route::get('topup.filter', [TopupController::class, 'filter'])->name('topup.filter');
    Route::get('topup.print', [TopupController::class, 'print'])->name('topup.print');
    Route::resource('wd', WdController::class);
    Route::get('wd.filter', [WdController::class, 'filter'])->name('wd.filter');
    Route::get('wd.print', [WdController::class, 'print'])->name('wd.print');
    Route::resource('sales', OrderController::class);
    Route::get('sales.report', [OrderController::class, 'raport'])->name('sales.report');
    Route::get('sales.filter', [OrderController::class, 'filter'])->name('sales.filter');
    Route::get('sales/detail/{id}', [OrderController::class, 'detail'])->name('sales.detail');
    Route::get('sales.print', [OrderController::class, 'print'])->name('sales.print');
    // Sales Reporting and Management
    //Route::resource('sales', OrderController::class)->only(['index', 'show']);
    // Route::get('sales.report', [OrderController::class, 'report'])->name('sales.report');
});

// Remove redundant or duplicate routes
// Keep your routes file clean and focused on defining access rights and redirect logic
