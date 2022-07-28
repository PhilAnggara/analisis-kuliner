<?php

use App\Http\Controllers\MainController;
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

Route::get('/', [MainController::class, 'dataTraining'])->name('data-training');
Route::prefix('single')->group(function () {
  Route::get('manual', [MainController::class, 'manual'])->name('manual');
  Route::get('otomatis', [MainController::class, 'otomatis'])->name('otomatis');
});
Route::get('multiple', [MainController::class, 'multiple'])->name('multiple');

Route::get('scraping', [MainController::class, 'scraping'])->name('scraping');

// Testing needs
Route::get('testing', [MainController::class, 'testing'])->name('testing');