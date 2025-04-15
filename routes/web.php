<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminGameController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\BalanceRequestController;

// For Searching games
// Add a route for searching games
Route::get('/search/games', [GameController::class, 'search'])->name('search.games');
Route::get('/library/{name}', [GameController::class, 'libraryByName'])->name('library.game');


Route::post('/game/{purchase}/delete', [GameController::class, 'deleteFromLibrary'])->name('game.delete');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================
// Public Routes
// =========================

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =========================
// User Routes (Requires auth)
// =========================

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [GameController::class, 'index'])->name('dashboard');

    // Game Library (purchased games)
    Route::get('/library', [GameController::class, 'library'])->name('library');

    // Game Purchase Flow
    Route::get('/games/invoice/{gameId}', [GameController::class, 'showInvoice'])->name('games.invoice');
    Route::post('/games/{gameId}/confirm-purchase', [GameController::class, 'confirmPurchase'])->name('game.confirmPurchase');

    // Game Search
    Route::get('/search', [GameController::class, 'search'])->name('search');

    // User Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update-general', [ProfileController::class, 'updateGeneral'])->name('profile.update.general');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/update-info', [ProfileController::class, 'updateInfo'])->name('profile.update.info');
    Route::post('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');

    // Balance Management
    Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
    Route::post('/balance/request', [BalanceController::class, 'requestBalance'])->name('balance.request');

    // Direct Purchase
    Route::post('/purchase/{game}', [PurchaseController::class, 'buy'])->name('purchase.buy');

    // Support Messages
    Route::get('/support', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
});


// =========================
// Admin Routes (Requires auth:admin)
// =========================

Route::middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminGameController::class, 'create'])->name('admin_dashboard');

    // Manage Users
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');

    // Manage Games
    Route::post('/admin/games/store', [AdminGameController::class, 'store'])->name('admin.games.store');
    Route::delete('/admin/games/{id}', [AdminGameController::class, 'destroy'])->name('admin.games.destroy');

    // Admin Profile
    Route::get('/admin/profile', [AdminProfileController::class, 'show'])->name('admin.profile.show');
    Route::post('/admin/profile/update-general', [AdminProfileController::class, 'updateGeneral'])->name('admin.profile.update.general');
    Route::post('/admin/profile/update-password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.update.password');
    Route::post('/admin/profile/update-info', [AdminProfileController::class, 'updateInfo'])->name('admin.profile.update.info');
    Route::post('/admin/profile/delete', [AdminProfileController::class, 'deleteAccount'])->name('admin.profile.delete');

    // Balance Requests
    Route::get('/admin/balance-requests', [BalanceRequestController::class, 'index'])->name('admin.balance.requests');
    Route::post('/admin/balance/requests/{id}/approve', [BalanceRequestController::class, 'approve'])->name('admin.balance.requests.approve');
    Route::post('/admin/balance/requests/{id}/disapprove', [BalanceRequestController::class, 'disapprove'])->name('admin.balance.requests.disapprove');

    // Support Message Deletion
    Route::delete('/admin/supports/{id}', [SupportController::class, 'destroy'])->name('admin.supports.destroy');
});


// =========================
// Admin Auth Routes
// =========================

Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin_register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin_login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin_logout');
