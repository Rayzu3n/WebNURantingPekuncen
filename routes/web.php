<?php

use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrganizationProfileController as AdminOrganizationProfileController;
use App\Http\Controllers\EventController as PublicEventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\CardController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Member\VerificationController;
use App\Http\Controllers\NewsController as PublicNewsController;
use App\Http\Controllers\OrganizationProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MembershipTrackingController;
use App\Http\Controllers\MembershipRevisionController;
use App\Http\Controllers\Admin\MembershipApplicationController;
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

Route::get('/tentang-kami', [OrganizationProfileController::class, 'show'])
    ->name('about');

Route::get('/kegiatan', [PublicEventController::class, 'index'])
    ->name('events.index');

Route::get('/kegiatan/{slug}', [PublicEventController::class, 'show'])
    ->name('events.show');

Route::get('/kontak', [ContactController::class, 'create'])
    ->name('contact.index');

Route::post('/kontak', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');

Route::get('/membership/track', [MembershipTrackingController::class, 'create'])
    ->name('membership.track');

Route::post('/membership/track', [MembershipTrackingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('membership.track.store');

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

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->account_status === 'pending'
        || ($user->account_status === 'suspended' && $user->membershipApplication?->status === 'rejected')) {
        return redirect()->route('membership.pending');
    }

    abort_unless($user->account_status === 'active', 403);

    return redirect()->route('member.dashboard');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'active.account'])->group(function () {
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

        Route::resource('events', AdminEventController::class)
            ->except(['show']);

        Route::get('/organization-profile', [AdminOrganizationProfileController::class, 'edit'])
            ->name('organization-profile.edit');
        Route::patch('/organization-profile', [AdminOrganizationProfileController::class, 'update'])
            ->name('organization-profile.update');

        Route::get('/messages', [ContactMessageController::class, 'index'])
            ->name('messages.index');
        Route::get('/messages/{message}', [ContactMessageController::class, 'show'])
            ->name('messages.show');
        Route::patch('/messages/{message}', [ContactMessageController::class, 'update'])
            ->name('messages.update');
        Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])
            ->name('messages.destroy');

        Route::resource('members', MemberController::class)->only(['index']);

        Route::get('/membership-applications', [MembershipApplicationController::class, 'index'])
            ->name('membership-applications.index');
        Route::get('/membership-applications/{membershipApplication}', [MembershipApplicationController::class, 'show'])
            ->name('membership-applications.show');
        Route::post('/membership-applications/{membershipApplication}/decision', [MembershipApplicationController::class, 'decide'])
            ->name('membership-applications.decide');
    });

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
*/

Route::get('/membership/revise', [MembershipRevisionController::class, 'edit'])
    ->middleware(['auth', 'role:member'])
    ->name('membership.revise');

Route::patch('/membership/revise', [MembershipRevisionController::class, 'update'])
    ->middleware(['auth', 'role:member', 'throttle:5,1'])
    ->name('membership.revise.update');

Route::get('/membership/pending', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'pending'])
    ->middleware(['auth', 'role:member'])
    ->name('membership.pending');

Route::middleware(['auth', 'role:member', 'active.member'])
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
