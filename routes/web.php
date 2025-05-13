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
use App\Http\Controllers\AdminRecommendedGameController;
use App\Http\Controllers\PatchNoticeController;
use App\Http\Controllers\GameNewsController;
use App\Http\Controllers\ReviewController;

// Social feature controllers
use App\Http\Controllers\SocialController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ChatController;

// Public & auth routes…
Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Game news, reviews, patches, etc.
Route::get('/gamenews', [GameNewsController::class, 'index'])->name('gamenews.index');
Route::get('/gamenews/{id}', [GameNewsController::class, 'show'])->name('gamenews.show');
Route::post('/gamenews/review', [GameNewsController::class, 'storeReview'])->name('gamenews.review.store');
Route::post('/admin/gamenews', [GameNewsController::class, 'store'])->name('admin.gamenews.store');
Route::get('/games/game_reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/games/game_reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/patch-updates', [PatchNoticeController::class, 'patchUpdates'])->name('patch.index');
Route::get('/patch-updates/{id}', [PatchNoticeController::class, 'show'])->name('patch.show');
Route::get('/admin/patch-notice/create', [PatchNoticeController::class, 'create'])->name('patch.create');
Route::post('/admin/patch-notice', [PatchNoticeController::class, 'store'])->name('patch.store');

// Library, search, purchase
Route::get('/search/games', [GameController::class, 'search'])->name('search.games');
Route::get('/library/{name}', [GameController::class, 'libraryByName'])->name('library.game');
Route::post('/game/{purchase}/delete', [GameController::class, 'deleteFromLibrary'])->name('game.delete');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Dashboard, library, profile, balance, purchase, support…
    Route::get('/dashboard', [GameController::class, 'index'])->name('dashboard');
    Route::get('/library',  [GameController::class, 'library'])->name('library');
    Route::get('/games/invoice/{gameId}', [GameController::class, 'showInvoice'])->name('games.invoice');
    Route::post('/games/{gameId}/confirm-purchase', [GameController::class, 'confirmPurchase'])->name('game.confirmPurchase');
    Route::get('/search', [GameController::class, 'search'])->name('search');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update-general', [ProfileController::class, 'updateGeneral'])->name('profile.update.general');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/update-info', [ProfileController::class, 'updateInfo'])->name('profile.update.info');
    Route::post('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');

    Route::get('/balance', [BalanceController::class, 'index'])->name('balance.index');
    Route::post('/balance/request', [BalanceController::class, 'requestBalance'])->name('balance.request');
    Route::post('/purchase/{game}', [PurchaseController::class, 'buy'])->name('purchase.buy');

    Route::get('/support', [SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');
});

// Admin user/game/profile routes (auth:admin) …
Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminGameController::class, 'create'])->name('admin_dashboard');
    Route::get('/admin/users',     [AdminUserController::class, 'index'])->name('admin.users');
    Route::post('/admin/games/store',  [AdminGameController::class, 'store'])->name('admin.games.store');
    Route::delete('/admin/games/{id}', [AdminGameController::class, 'destroy'])->name('admin.games.destroy');

    Route::get('/admin/profile',            [AdminProfileController::class, 'show'])->name('admin.profile.show');
    Route::post('/admin/profile/update-general', [AdminProfileController::class, 'updateGeneral'])->name('admin.profile.update.general');
    Route::post('/admin/profile/update-password',[AdminProfileController::class, 'updatePassword'])->name('admin.profile.update.password');
    Route::post('/admin/profile/update-info',    [AdminProfileController::class, 'updateInfo'])->name('admin.profile.update.info');
    Route::post('/admin/profile/delete',         [AdminProfileController::class, 'deleteAccount'])->name('admin.profile.delete');

    Route::get('/admin/balance-requests',               [BalanceRequestController::class, 'index'])->name('admin.balance.requests');
    Route::post('/admin/balance/requests/{id}/approve',   [BalanceRequestController::class, 'approve'])->name('admin.balance.requests.approve');
    Route::post('/admin/balance/requests/{id}/disapprove',[BalanceRequestController::class, 'disapprove'])->name('admin.balance.requests.disapprove');

    Route::delete('/admin/supports/{id}', [SupportController::class, 'destroy'])->name('admin.supports.destroy');

    Route::get('/admin/patch-notice/create', [PatchNoticeController::class, 'create'])->name('admin.patch_notice.create');
    Route::post('/admin/patch-notice',       [PatchNoticeController::class, 'store'])->name('admin.patch_notice.store');

    Route::post('/admin/game-news', [GameNewsController::class, 'store'])->name('admin.game_news.store');
    Route::get('/admin/recommended', [AdminRecommendedGameController::class, 'index'])->name('admin.recommended');
    Route::patch('/admin/recommended/{game}/toggle', [AdminRecommendedGameController::class, 'toggle'])->name('admin.recommended.toggle');
});

// Admin auth
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register',[AdminAuthController::class, 'register']);
Route::get('/admin/login',    [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login',   [AdminAuthController::class, 'login']);
Route::post('/admin/logout',  [AdminAuthController::class, 'logout'])->name('admin.logout');

// === Social & Chat Feature ===
Route::middleware('auth')
     ->prefix('social')
     ->name('social.')
     ->group(function () {
    // 1) Landing page
    Route::get('/', [SocialController::class, 'index'])->name('index');

    // 2) Friend requests
    Route::post('/friends/send/{userId}',    [FriendshipController::class, 'sendRequest'])->name('friends.send');
    Route::post('/friends/cancel/{userId}',  [FriendshipController::class, 'cancelRequest'])->name('friends.cancel');
    Route::post('/friends/accept/{userId}',  [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
    Route::post('/friends/decline/{userId}', [FriendshipController::class, 'declineRequest'])->name('friends.decline');

    // 3) Chat
    Route::get('/chat/fetch/{friendId}', [ChatController::class, 'fetch'])->name('chat.fetch');
    Route::post('/chat/send/{friendId}',[ChatController::class, 'send'])->name('chat.send');


Route::patch('/admin/recommended/{game}/toggle', [RecommendedGameController::class, 'toggle'])
    ->name('admin.admin.recommended.toggle');
});
