<?php

use App\Http\Controllers\backend\Auth\ForgotPasswordController;
use App\Http\Controllers\backend\Auth\LoginController;
use App\Http\Controllers\backend\adminsController;
use App\Http\Controllers\backend\dashboardController;
use App\Http\Controllers\backend\rolesController;
use App\Http\Controllers\backend\usersController;
use App\Http\Controllers\backend\settingsController;

use App\Http\Controllers\Book\BooksController;
use App\Http\Controllers\Book\CategoryController;

use App\Http\Controllers\frontend\homeController;

use Illuminate\Support\Facades\Auth;
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

Route::resource('/',homeController::class, ['names' => 'home']);

Auth::routes();
// Login Routes
Route::get('/login', [LoginController::class,'showLoginForm'])->name('admin.login');
Route::post('/login/submit', [LoginController::class,'login'])->name('admin.login.submit');

// Logout Routes
Route::post('/logout/submit', [LoginController::class,'logout'])->name('admin.logout.submit');

// Forget Password Routes
Route::get('/password/reset', [ForgotPasswordController ::class,'showLinkRequestForm'])->name('admin.password.request');
Route::post('/password/reset/submit', [ForgotPasswordController ::class,'reset'])->name('admin.password.update');

//Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//categories
Route::resource('categories',CategoryController::class, ['names' => 'categories']);
//Books
Route::resource('books',BooksController::class, ['names' => 'books']);


//admin
Route::group(['prefix' => 'panel'], function () {

    //Route::resource('dashboard', [dashboardController::class,  ['names' => 'admin.dashboard']]);
    Route::resource('dashboard',dashboardController::class, ['names' => 'admin.dashboard']);
    Route::resource('roles',rolesController::class, ['names' => 'admin.roles']);
    //Route::resource('users',usersController::class, ['names' => 'admin.users']);
    Route::resource('users',adminsController::class, ['names' => 'admin.admins']);

    Route::resource('settings/site',settingsController::class, ['names' => 'settings.site']);
});

Route::get('/{cat}/{subcat}',[homeController::class, 'show_book_category']);

Route::get('/optimize',function(){
    \Artisan::call('optimize:clear');
    echo 'optimize done';
});
