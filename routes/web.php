<?php

use App\Http\Controllers\CAuth;
use App\Http\Controllers\CDirector;
use App\Http\Controllers\CEmployee;
use App\Http\Controllers\CManager;
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

Route::get('', function(){
    return redirect()->route('auth.index');
});
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('', [CAuth::class, 'index'])->name('index');
    Route::post('login', [CAuth::class, 'login'])->name('login');
    Route::get('logout', [CAuth::class, 'logout'])->name('logout');
});
Route::prefix('director')->name('director.')->middleware('auth.role:director')->group(function () {
    Route::get('', [CDirector::class, 'dashboard'])->name('dashboard');
    Route::prefix('user_list')->name('user_list.')->group(function () {
        Route::get('', [CDirector::class, 'user_list'])->name('index');
        Route::post('',[CDirector::class, 'store_user'])->name('store');
        Route::put('update', [CDirector::class, 'update_user'])->name('update');
        Route::delete('destroy', [CDirector::class, 'destroy_user'])->name('destroy');
    });
    Route::prefix('manager_assignments')->name('manager_task.')->group(function () {
        Route::get('', [CDirector::class, 'manager_task'])->name('index');
        Route::get('create_assignment', [CDirector::class, 'assign_task'])->name('create');
        Route::post('', [CDirector::class, 'store_task'])->name(name: 'store');
        Route::get('edit_assignment/{id}', [CDirector::class, 'edit_task'])->name('edit');
        Route::put('{manager_task_id}', [CDirector::class, 'update_task'])->name('update');
        Route::delete('', [CDirector::class, 'destroy_task'])->name('destroy');
    });
    Route::prefix('manager_assignments_returns')->name('manager_task_return.')->group(function(){
        Route::get('',[CDirector::class, 'return_task'])->name('index');
        Route::delete('{managertaskreturn}', [CDirector::class, 'destroy_task_return'])->name('destroy');
    });
});

Route::prefix('manager')->name('manager.')->middleware('auth.role:manager')->group(function(){
    Route::get('', [CManager::class, 'dashboard'])->name('dashboard');
    Route::prefix('assigments')->name('task_list.')->group(function(){
        Route::get('', [CManager::class, 'task_list'])->name('index');
        Route::get('detail/{id}', [CManager::class, 'task_detail'])->name('detail');
        Route::delete('{id}/{manager_task_id}', [CManager::class, 'destroy_task'])->name('destroy');
    });
    Route::prefix('forward_assignment')->name('forward_task.')->group(function(){
        Route::get('{manager_task_id}', [CManager::class, 'forward_task'])->name('index');
        Route::post('', [CManager::class, 'store_task'])->name('store');
        Route::get('edit/{id}', [CManager::class, 'edit_task'])->name('edit');
        Route::put('{employee_task_id}', [CManager::class, 'update_task'])->name('update');
    });
    Route::prefix('submissions')->name('submissions.')->group(function(){
        Route::get('{manager_task_id}', [CManager::class, 'create_submission'])->name('create');
        Route::post('', [CManager::class, 'store_submission'])->name('store');
        Route::get('detail/{manager_submission_id}', [CManager::class, 'submission_detail'])->name('detail');
        Route::put('', [CManager::class, 'update_submission'])->name('update');
    });
    Route::prefix('employee_submissions')->name('employee_submissions.')->group(function(){
        Route::get('detail/{employee_task_id}', [CManager::class, 'employee_submission_detail'])->name('detail');
    });
});

Route::prefix('employee')->name('employee.')->middleware('auth.role:employee')->group(function(){
    Route::get('', [CEmployee::class, 'dashboard'])->name('dashboard');
    Route::prefix('assigments')->name('task_list.')->group(function(){
        Route::get('', [CEmployee::class, 'task_list'])->name('index');
        Route::get('detail/{id}', [CEmployee::class, 'task_detail'])->name('detail');
    });
    Route::prefix('submissions')->name('submissions.')->group(function (){
        Route::get('{employee_task_id}', [CEmployee::class, 'create_submission'])->name('create');
        Route::post('', [CEmployee::class, 'store_submission'])->name('store');
        Route::get('detail/{employee_submission_id}', [CEmployee::class, 'submission_detail'])->name('detail');
        Route::put('{employee_submission_id}', [CEmployee::class, 'update_submission'])->name('update');
    });
});