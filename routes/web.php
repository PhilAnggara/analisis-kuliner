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

// Route::get('/', [MainController::class, 'crawling'])->name('crawling');
// Route::get('preprocessing', [MainController::class, 'preprocessing'])->name('preprocessing');
Route::get('/', [MainController::class, 'dataTraining'])->name('data-training');
Route::prefix('single')->group(function () {
  Route::get('manual', [MainController::class, 'dataTraining'])->name('manual');
  Route::get('otomatis', [MainController::class, 'preprocessing'])->name('otomatis');
});
Route::get('multiple', [MainController::class, 'dataTraining'])->name('multiple');

Route::get('scraping', [MainController::class, 'scraping'])->name('scraping');