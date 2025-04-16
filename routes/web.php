<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\RequestController;
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
    // إذا كان المستخدم قد سجل الدخول، يتم توجيهه إلى لوحة التحكم
    if (Auth::check()) {
        return redirect()->route('requests.index');
    }

    // إذا لم يكن المستخدم قد سجل الدخول، يتم توجيهه إلى صفحة تسجيل الدخول
    return redirect()->route('login');
});





Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('requests', RequestController::class);
    // Route::post('requests/{request}', [RequestController::class, 'update'])->name('requests.update');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
