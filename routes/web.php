<?php

use App\Http\Controllers\CDirector;
use App\Http\Controllers\Tes;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [Tes::class, 'index']);
Route::prefix('auth/')->name('auth.')->group(function () {
    Route::get('login')->name('login');
});
Route::prefix('director/')->name('director.')->group(function () {
    Route::get('', [CDirector::class, 'dashboard'])->name('dashboard');
    Route::prefix('user_list')->name('user_list.')->group(function () {
        Route::get('', [CDirector::class, 'user_list'])->name('index');
        Route::post('',[CDirector::class, 'store_user']);
        Route::put('', [CDirector::class, 'update_user']);
        Route::delete('', [CDirector::class, 'destroy_user']);
    });
    Route::prefix('manager_task')->name('manager_task.')->group(function () {
        Route::get('')->name('index');
        Route::get('assign_task')->name('create');
        Route::post('');
        Route::get('edit_task')->name('edit');
        Route::put('');
        Route::delete('');
    });
});
