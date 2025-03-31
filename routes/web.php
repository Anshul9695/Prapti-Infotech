<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LoginController;
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

Route::get('/', function () {
    return view('Frontend/Home/index');
});


// Route::get('dashboard', function () {
//     return view('Backend/dashboard/dashboard');
// });


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('loginPost', [LoginController::class, 'loginPost'])->name('loginPost');


Route::group(['middleware' => ['checkUserLogin']], function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('register', [LoginController::class, 'register'])->name('register');
    Route::post('registerPost', [LoginController::class, 'registerPost'])->name('registerPost');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
});
