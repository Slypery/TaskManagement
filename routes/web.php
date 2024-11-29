<?php

use App\Http\Controllers\CAuth;
use App\Http\Controllers\CDirector;
use App\Http\Controllers\CManager;
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
    Route::get('', [CAuth::class, 'index'])->name('index');
    Route::post('login', [CAuth::class, 'login'])->name('login');
});
Route::prefix('director/')->name('director.')->middleware('auth.role:director')->group(function () {
    Route::get('', [CDirector::class, 'dashboard'])->name('dashboard');
    Route::prefix('user_list')->name('user_list.')->group(function () {
        Route::get('', [CDirector::class, 'user_list'])->name('index');
        Route::post('',[CDirector::class, 'store_user'])->name('store');
        Route::put('update', [CDirector::class, 'update_user'])->name('update');
        Route::delete('destroy', [CDirector::class, 'destroy_user'])->name('destroy');
    });
    Route::prefix('manager_task')->name('manager_task.')->group(function () {
        Route::get('', [CDirector::class, 'manager_task'])->name('index');
        Route::get('assign_task', [CDirector::class, 'assign_task'])->name('create');
        Route::post('', [CDirector::class, 'store_task'])->name(name: 'store');
        Route::get('edit_task/{id}', [CDirector::class, 'edit_task'])->name('edit');
        Route::put('update/{managertask}', [CDirector::class, 'update_task'])->name('update');
        Route::delete('destroy/', [CDirector::class, 'destroy_task'])->name('destroy');
    });
    Route::prefix('manager_task_return')->name('manager_task_return.')->group(function(){
        Route::get('',[CDirector::class, 'return_task'])->name('index');
        Route::delete('destroy/{managertaskreturn}', [CDirector::class, 'destroy_task_return'])->name('destroy');
    });
});
Route::prefix('manager/')->name('manager.')->group(function(){
    Route::get('', [CManager::class, 'dashboard'])->name('dashboard');
});