<?php

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\CardController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\VerificationController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/berita', [PublicNewsController::class, 'index'])
    ->name('news.index');

Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])
    ->name('news.show');

Route::get('/kontak', [ContactController::class, 'create'])
    ->name('contact.index');

Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/member/verify/{member_number}', [VerificationController::class, 'show'])
    ->middleware('throttle:60,1')
    ->name('member.verify');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
|
| Setelah login, user akan diarahkan berdasarkan role:
| admin  -> /admin/dashboard
| member -> /member/dashboard
|
*/

Route::get('/dashboard', function () {
    /** @var User $user */
    $user = Auth::user();

    return $user->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('member.dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('categories', NewsCategoryController::class)
            ->except(['show']);

        Route::resource('news', NewsController::class)
            ->except(['show']);

        Route::get('/messages', [ContactMessageController::class, 'index'])
            ->name('messages.index');
        Route::get('/messages/{message}', [ContactMessageController::class, 'show'])
            ->name('messages.show');
        Route::patch('/messages/{message}', [ContactMessageController::class, 'update'])
            ->name('messages.update');
        Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])
            ->name('messages.destroy');

        Route::resource('members', MemberController::class)
            ->except(['show']);
    });

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::view('/dashboard', 'member.dashboard')
            ->name('dashboard');

        Route::get('/profile', [MemberProfileController::class, 'edit'])
            ->name('profile');

        Route::patch('/profile', [MemberProfileController::class, 'update'])
            ->name('profile.update');

        Route::get('/card', [CardController::class, 'show'])
            ->name('card');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
