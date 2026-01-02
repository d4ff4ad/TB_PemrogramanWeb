<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminEventController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\RegistrationController;

// Halaman Depan (User)
Route::get('/', [PublicEventController::class, 'index'])->name('home');
// Event Detail & Registration
Route::get('/events/{event}', [PublicEventController::class, 'show'])->name('public.events.show');
Route::get('/events/{event}/register', [RegistrationController::class, 'create'])->name('public.events.register');
Route::post('/events/{event}/register', [RegistrationController::class, 'store'])->name('public.events.register.store');

// Cek Pesanan (Guest)
Route::get('/orders/check', [PublicEventController::class, 'checkOrders'])->name('public.orders.check');
Route::get('/orders/check', [PublicEventController::class, 'checkOrders'])->name('public.orders.check');
Route::get('/orders/my-orders', [PublicEventController::class, 'indexOrders'])->name('public.orders.index');
Route::get('/orders/{id}/ticket', [PublicEventController::class, 'printTicket'])->name('public.orders.ticket');

Route::get('/registrations/{id}/payment', [RegistrationController::class, 'payment'])->name('registrations.payment');
Route::put('/registrations/{id}/payment', [RegistrationController::class, 'updatePayment'])->name('registrations.updatePayment');

use App\Http\Controllers\AuthController;

// Auth Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\AdminRegistrationController;

// Halaman Admin (CRUD Event) - Protected
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::resource('events', EventController::class, ['except' => ['index']]); // Use custom index
    
    // Kelola Data Event (Tabel)
    Route::get('/manage-events', [AdminEventController::class, 'index'])->name('admin.events.table');
    Route::get('/manage-events/export', [AdminEventController::class, 'export'])->name('admin.events.export');
    
    // Redirect old index to new table
    Route::get('/events', function() {
        return redirect()->route('admin.events.table');
    })->name('events.index');

    // Dashboard Admin
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Registrations
    Route::get('/registrations/export', [AdminRegistrationController::class, 'export'])->name('admin.registrations.export');
    Route::get('/registrations', [AdminRegistrationController::class, 'index'])->name('admin.registrations.index');
    Route::put('/orders/{id}/approve', [AdminRegistrationController::class, 'approve'])->name('admin.registrations.approve');
    Route::put('/orders/{id}/reject', [AdminRegistrationController::class, 'reject'])->name('admin.registrations.reject');

    // Old redirect removed

});
