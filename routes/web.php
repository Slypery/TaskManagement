<?php

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
Route::prefix('auth/')->name('auth.')->group(function (){
    Route::get('', function (){
        return view('login');
    })->name('index');
});
