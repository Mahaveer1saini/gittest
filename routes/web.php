<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AcconutController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['account'], function () {

    Route::group(['middleware' => 'guest'], function () {

        Route::get('/frontRegister', [AcconutController::class, 'register'])->name('frontRegister');
        Route::post('/front-Register', [AcconutController::class, 'processRegister'])->name('account.processRegister');
        Route::get('/frontLogin', [AcconutController::class, 'login'])->name('frontLogin');
        Route::post('/login', [AcconutController::class, 'authenticate'])->name('account.authenticate');

    });
});

Route::group(['account'], function () {

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/profile', [AcconutController::class, 'profile'])->name('account.profile');
        Route::put('/update-profile', [AcconutController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/update-Pic', [AcconutController::class, 'updatePic'])->name('account.updatePic');
        Route::get('/logout', [AcconutController::class, 'logout'])->name('account.logout');
        Route::get('/create-Jod', [AcconutController::class, 'createJod'])->name('account.createJod');
        Route::post('/create-Jod', [AcconutController::class, 'SaveJob'])->name('account.SaveJob');
        Route::get('/my-Jod', [AcconutController::class, 'myJod'])->name('account.myJod');
        Route::get('/my-Jod/edit/{jodId}', [AcconutController::class, 'editJod'])->name('account.editJod');
        Route::post('/update-jod/{jodId}', [AcconutController::class, 'updateJob'])->name('account.updateJob');
        Route::get('/delete-jod/{id}', [AcconutController::class, 'deleteJob'])->name('account.deleteJob');

     });
});

