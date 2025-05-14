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
use App\Http\Controllers\SocialController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Admin Authentication (public)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('login',    [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login',   [AdminAuthController::class, 'login']);
    Route::post('logout',  [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register',[AdminAuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard & Protected Routes (auth:admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->middleware('auth:admin')
     ->group(function () {
         // Dashboard (list games + support messages)
         Route::get('dashboard', [AdminGameController::class, 'index'])
              ->name('admin.dashboard');

         // Game CRUD
         Route::post('games',      [AdminGameController::class, 'store'])->name('admin.games.store');
         Route::delete('games/{id}', [AdminGameController::class, 'destroy'])->name('admin.games.destroy');

         // Users
         Route::get('users', [AdminUserController::class, 'index'])->name('admin.users');

         // Profile
         Route::get('profile',                [AdminProfileController::class, 'show'])
                                            ->name('admin.profile.show');
         Route::post('profile/update-general',[AdminProfileController::class, 'updateGeneral'])
                                            ->name('admin.profile.update.general');
         Route::post('profile/update-password',[AdminProfileController::class, 'updatePassword'])
                                            ->name('admin.profile.update.password');
         Route::post('profile/update-info',   [AdminProfileController::class, 'updateInfo'])
                                            ->name('admin.profile.update.info');
         Route::post('profile/delete',        [AdminProfileController::class, 'deleteAccount'])
                                            ->name('admin.profile.delete');

         // Balance Requests
         Route::get('balance-requests',                  [BalanceRequestController::class, 'index'])
                                                      ->name('admin.balance.requests');
         Route::post('balance-requests/{id}/approve',   [BalanceRequestController::class, 'approve'])
                                                      ->name('admin.balance.requests.approve');
         Route::post('balance-requests/{id}/disapprove',[BalanceRequestController::class, 'disapprove'])
                                                      ->name('admin.balance.requests.disapprove');

         // Support Messages
         Route::delete('supports/{id}', [SupportController::class, 'destroy'])
              ->name('admin.supports.destroy');

         // Patch Notices
         Route::get('patch-notice/create', [PatchNoticeController::class, 'create'])
              ->name('admin.patch_notice.create');
         Route::post('patch-notice',        [PatchNoticeController::class, 'store'])
              ->name('admin.patch_notice.store');

         // Game News
         Route::post('game-news', [GameNewsController::class, 'store'])
              ->name('admin.game_news.store');

         // Recommended Games
         Route::get('recommended',                 [AdminRecommendedGameController::class, 'index'])
                                               ->name('admin.recommended');
         Route::patch('recommended/{game}/toggle', [AdminRecommendedGameController::class, 'toggle'])
                                               ->name('admin.recommended.toggle');
     });

/*
|--------------------------------------------------------------------------
| Public & User Authentication
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('welcome');

Route::get('login',    [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login',   [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register',[AuthController::class, 'register']);
Route::post('logout',  [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Public Content
|--------------------------------------------------------------------------
*/
// Game News & Reviews
Route::get('gamenews',        [GameNewsController::class, 'index'])->name('gamenews.index');
Route::get('gamenews/{id}',   [GameNewsController::class, 'show'])->name('gamenews.show');
Route::post('gamenews/review',[GameNewsController::class, 'storeReview'])
                           ->name('gamenews.review.store');

// Patch Updates (public)
Route::get('patch-updates',      [PatchNoticeController::class, 'patchUpdates'])
                             ->name('patch.index');
Route::get('patch-updates/{id}', [PatchNoticeController::class, 'show'])
                             ->name('patch.show');

// Game Reviews (public)
Route::get('games/game_reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('games/game_reviews',[ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Library, Search & Purchase (auth:user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('dashboard',               [GameController::class, 'index'])->name('dashboard');
    Route::get('library',                 [GameController::class, 'library'])->name('library');
    Route::get('library/{name}',          [GameController::class, 'libraryByName'])
                                         ->name('library.game');
    Route::post('game/{purchase}/delete', [GameController::class, 'deleteFromLibrary'])
                                         ->name('game.delete');

    Route::get('games/invoice/{gameId}', [GameController::class, 'showInvoice'])
                                         ->name('games.invoice');
    Route::post('games/{gameId}/confirm-purchase',
                                         [GameController::class, 'confirmPurchase'])
                                         ->name('game.confirmPurchase');
    Route::get('search',                  [GameController::class, 'search'])->name('search');

    Route::get('profile',           [ProfileController::class, 'show'])->name('profile.show');
    Route::post('profile/update-general',  [ProfileController::class, 'updateGeneral'])
                                        ->name('profile.update.general');
    Route::post('profile/update-password', [ProfileController::class, 'updatePassword'])
                                        ->name('profile.update.password');
    Route::post('profile/update-info',     [ProfileController::class, 'updateInfo'])
                                        ->name('profile.update.info');
    Route::post('profile/delete',          [ProfileController::class, 'deleteAccount'])
                                        ->name('profile.delete');

    Route::get('balance',      [BalanceController::class, 'index'])->name('balance.index');
    Route::post('balance/request', [BalanceController::class, 'requestBalance'])
                               ->name('balance.request');
    Route::post('purchase/{game}', [PurchaseController::class, 'buy'])
                               ->name('purchase.buy');

    Route::get('support',      [SupportController::class, 'create'])
                             ->name('support.create');
    Route::post('support',     [SupportController::class, 'store'])
                             ->name('support.store');
});

/*
|--------------------------------------------------------------------------
| Social & Chat (auth:user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
     ->prefix('social')
     ->name('social.')
     ->group(function () {
         Route::get('/', [SocialController::class, 'index'])->name('index');

         Route::post('friends/send/{userId}',    [FriendshipController::class, 'sendRequest'])
                                               ->name('friends.send');
         Route::post('friends/cancel/{userId}',  [FriendshipController::class, 'cancelRequest'])
                                               ->name('friends.cancel');
         Route::post('friends/accept/{userId}',  [FriendshipController::class, 'acceptRequest'])
                                               ->name('friends.accept');
         Route::post('friends/decline/{userId}', [FriendshipController::class, 'declineRequest'])
                                               ->name('friends.decline');

         Route::get('chat/fetch/{friendId}', [ChatController::class, 'fetch'])
                                              ->name('chat.fetch');
         Route::post('chat/send/{friendId}', [ChatController::class, 'send'])
                                              ->name('chat.send');
     });

/*
|--------------------------------------------------------------------------
| Debugging Helper
|--------------------------------------------------------------------------
*/
Route::get('/__debug/routes', function () {
    return collect(Route::getRoutes())
        ->map(fn($r) => $r->getName() . ' → ' . $r->uri())
        ->filter()     // remove unnamed routes
        ->sort()
        ->values();
});
