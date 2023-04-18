<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyArticleController;

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
    return view('welcome');
});


Route::resource('article', 'App\Http\Controllers\MyArticleController');
Route::post('delete_all', [MyArticleController::class, 'delete_all'])->name('delete_all');
