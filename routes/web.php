<?php

use App\Http\Controllers\WaitlistController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;

// ── Public
Route::get('/', [WaitlistController::class, 'index'])->name('home');
Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store')
     ->middleware('throttle:10,1');
Route::get('/merci', [WaitlistController::class, 'thankyou'])->name('thankyou');

// ── Admin
Route::middleware([AdminAuth::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [WaitlistController::class, 'admin'])->name('waitlist');
    Route::get('/export', [WaitlistController::class, 'export'])->name('export');
    Route::post('/broadcast', [WaitlistController::class, 'broadcast'])->name('broadcast');
    Route::post('/logout', function () {
        session()->forget('proofwork_admin');
        return redirect('/');
    })->name('logout');
});

Route::post('/admin/login', function () {
    if (request('password') === config('proofwork.admin_password')) {
        session(['proofwork_admin' => true]);
        return redirect()->route('admin.waitlist');
    }
    return back()->withErrors(['password' => 'Wrong password']);
})->name('admin.login');
