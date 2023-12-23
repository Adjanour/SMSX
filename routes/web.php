<?php

use App\Http\Controllers\BirthdayController;
use App\Http\Controllers\BulkSmsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SmsController;
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

Route::get('/', function () {
    return view('welcome');
});

//SMS Routes
//22-02-05
Route::post('/sms/send', [SmsController::class, 'sendSms'])->name('send-sms');
Route::get('/sms',[SmsController::class,'index'])->middleware(['auth','verified'])->name('sms');
Route::post('/sms/bulk/send',[BulkSmsController::class,'bulkSms'])->middleware(['auth','verified'])->name('send-bulk-sms');
Route::get('/bulk-sms',[SmsController::class,'index'])->middleware(['auth','verified'])->name('bulk-sms');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Contact Routes
Route::resource('/contact',ContactController::class)->middleware(['auth']);
Route::resource('/upload',\App\Http\Controllers\ContactUploadController::class)->middleware(['auth','verified']);
Route::resource('/contact/group',\App\Http\Controllers\ContactGroupController::class)->middleware(['auth']);

//Message Routes
Route::resource('/templates',MessageTemplateController::class)->middleware(['auth']);

//Birthday Routes
Route::resource('/birthdays',BirthdayController::class)->middleware(['auth']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
