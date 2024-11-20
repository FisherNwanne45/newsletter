<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;

// Redirect root route to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication routes
Auth::routes();

// Default home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Routes accessible to all authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Newsletter management
    Route::get('/newsletters', [NewsletterController::class, 'index'])->name('newsletters.index');
    Route::get('/newsletters/create', [NewsletterController::class, 'create'])->name('newsletters.create');
    Route::post('/newsletters', [NewsletterController::class, 'store'])->name('newsletters.store');
    Route::post('/newsletters/send', [NewsletterController::class, 'send'])->name('newsletters.send');
    Route::delete('/newsletters/{id}', [NewsletterController::class, 'destroy'])->name('newsletters.destroy');
    Route::get('/newsletters/progress', [NewsletterController::class, 'getProgress'])->name('newsletters.progress');

    // Subscriber management
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('/subscribers/import', [SubscriberController::class, 'showImportForm'])->name('subscribers.showImportForm');
    Route::post('/subscribers/import', [SubscriberController::class, 'import'])->name('subscribers.import');
    Route::get('/subscribers/{list}/view', [SubscriberController::class, 'showList'])->name('subscribers.showList');
    Route::get('/subscribers/create', [SubscriberController::class, 'createList'])->name('subscribers.createList');
    Route::post('/subscribers/create', [SubscriberController::class, 'storeList'])->name('subscribers.storeList');
    Route::get('/subscribers/{list}/edit', [SubscriberController::class, 'editListName'])->name('subscribers.editListName');
    Route::put('/subscribers/{list}/update', [SubscriberController::class, 'updateList'])->name('subscribers.updateList');
    Route::delete('/subscribers/{subscriber}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::delete('/subscribers/list/{id}', [SubscriberController::class, 'destroyList'])->name('subscribers.destroyList');

    // Profile routes
    Route::get('profile/change-password', [ProfileController::class, 'showChangePasswordForm'])
        ->name('profile.change-password');
    Route::post('profile/change-password', [ProfileController::class, 'changePassword'])
        ->name('password.update');

    // SMTP settings
    Route::get('/dashboard/smtp-settings', [DashboardController::class, 'showSmtpSettings'])
        ->name('dashboard.smtp-settings');
    Route::post('/dashboard/smtp-settings', [DashboardController::class, 'updateSmtpSettings']);

    // Logout route
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Routes restricted to super admins only
Route::middleware(['auth', 'superadmin'])->group(function () {
    // Dashboard route to view all users
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Edit user password
    Route::get('/admin/users/{id}/edit-password', [AdminController::class, 'editPassword'])->name('admin.edit-password');
    Route::post('/admin/users/{id}/update-password', [AdminController::class, 'updatePassword'])->name('admin.update-password');
    
    // Delete user account
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
    
    // Log in as a user
    Route::get('/admin/login-as/{id}', [AdminController::class, 'loginAsUser'])->name('admin.login-as');
});