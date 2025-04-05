<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminGameController;
use App\Http\Controllers\AdminProfileController;

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('homepage');


// =========================
// User Authentication Routes
// =========================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// User Dashboard (Protected)
Route::get('/dashboard', [GameController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


// =========================
// Admin Authentication Routes
// =========================
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin_register');
Route::post('/admin/register', [AdminAuthController::class, 'register']);

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin_login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin_logout');

// Admin Dashboard with game addition form and game list
Route::get('/admin/dashboard', [AdminGameController::class, 'create'])
    ->middleware('auth:admin')
    ->name('admin_dashboard');

// New route for Tusers page – lists all users
Route::get('/admin/users', [AdminUserController::class, 'index'])
    ->middleware('auth:admin')
    ->name('admin.users');

// Route for storing a new game from admin dashboard
Route::post('/admin/games/store', [AdminGameController::class, 'store'])
    ->middleware('auth:admin')
    ->name('admin.games.store');

// Route for deleting a game
Route::delete('/admin/games/{id}', [AdminGameController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('admin.games.destroy');

// Admin Profile Routes (using the controller)
Route::get('/admin/profile', [AdminProfileController::class, 'show'])
    ->middleware('auth:admin')
    ->name('admin.profile.show');
Route::post('/admin/profile/update-general', [AdminProfileController::class, 'updateGeneral'])
    ->middleware('auth:admin')
    ->name('admin.profile.update.general');
Route::post('/admin/profile/update-password', [AdminProfileController::class, 'updatePassword'])
    ->middleware('auth:admin')
    ->name('admin.profile.update.password');
Route::post('/admin/profile/update-info', [AdminProfileController::class, 'updateInfo'])
    ->middleware('auth:admin')
    ->name('admin.profile.update.info');
Route::post('/admin/profile/delete', [AdminProfileController::class, 'deleteAccount'])
    ->middleware('auth:admin')
    ->name('admin.profile.delete');


// =========================
// Other Routes
// =========================
// Steam API Game Search
Route::get('/search', [GameController::class, 'search'])->name('search');


// User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update-general', [ProfileController::class, 'updateGeneral'])->name('profile.update.general');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/update-info', [ProfileController::class, 'updateInfo'])->name('profile.update.info');
    Route::post('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
});
