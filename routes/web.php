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




// تأكد من استيراد الـ middleware اللازمة إذا كنت تستخدمها
// Route::middleware(['auth', 'verified'])->group(function () {
//     // Routes لطلبات الدعم
//     Route::prefix('requests')->name('requests.')->group(function () {
//         Route::get('/', [RequestController::class, 'index'])->name('index');
//         Route::get('/create', [RequestController::class, 'create'])->name('create');
//         Route::post('/', [RequestController::class, 'store'])->name('store');
        
//         // Routes تحتوي على نموذج Request
//         Route::prefix('{request}')->group(function () {
//             Route::get('/', [RequestController::class, 'show'])->name('show');
//             Route::get('/edit', [RequestController::class, 'edit'])->name('edit');
//             Route::PATCH('/', [RequestController::class, 'update'])->name('update');
//             Route::delete('/', [RequestController::class, 'destroy'])->name('destroy');
//         });
//     });
// });
// قثضعسثف
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
