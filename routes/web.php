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
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/homeuser', [HomeController::class, 'homeuser'])->name('homeuser');
Route::resource('food', FoodController::class);
// Pastikan URL sama dengan yang dipanggil melalui AJAX
Route::post('/update-food-status/{id}', [FoodController::class, 'updateStatus'])->name('food.updateStatus');
Route::resource('drink', DrinkController::class);
Route::post('/update-drink-status/{id}', [DrinkController::class, 'updateStatus'])->name('drink.updateStatus');
Route::resource('snack', SnackController::class);
Route::post('/update-snack-status/{id}', [SnackController::class, 'updateStatus'])->name('snack.updateStatus');
Route::resource('user', UserController::class);

Route::resource('admin', AdminController::class);
Route::get('admin.user', [AdminController::class, 'user'])->name('admin.user');
Route::get('admin.user.topup', [AdminController::class, 'topup'])->name('admin.user.topup');
Route::post('admin.user.topupstore', [AdminController::class, 'topupstore'])->name('admin.user.topupstore');
Route::post('admin.user.checksaldo', [AdminController::class, 'checkSaldo'])->name('admin.user.checksaldo');
Route::get('admin.canteen', [AdminController::class, 'canteen'])->name('admin.canteen');
Route::get('admin.canteen.wd', [AdminController::class, 'wd'])->name('admin.canteen.wd');
Route::post('admin.canteen.wdstore', [AdminController::class, 'wdstore'])->name('admin.canteen.wdstore');
Route::post('admin.canteen.checksaldo', [AdminController::class, 'checkSaldo'])->name('admin.canteen.checksaldo');

// Route::resource('/api/check-rfid', SaldoController::class);
// Route::post('/check-rfid', [OrderController::class, 'checkRFID'])->name('api.check-rfid');
Route::resource('order', OrderController::class);
Route::get('order.report', [OrderController::class, 'report'])->name('order.report');
Route::resource('topup', TopupController::class);
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
