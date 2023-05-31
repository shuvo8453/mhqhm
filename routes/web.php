<?php


use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StudentController;
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
    return view('welcome');
});

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return \Illuminate\Support\Facades\Artisan::output();
});

Route::get('/storage-link', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return \Illuminate\Support\Facades\Artisan::output();
});

Route::middleware('auth:web')->group(function (){
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

    Route::get('/invoice', [InvoiceController::class, 'invoice'])->name('invoice');

    Route::get('/invoice/{id}', [InvoiceController::class, 'pdf'])->name('invoice.pdf');

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');

    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    Route::get('/feedback/{id}', [FeedbackController::class, 'data'])->name('feedback.data');
    Route::post('/feedback/{id}', [FeedbackController::class, 'update'])->name('feedback.data');
});

