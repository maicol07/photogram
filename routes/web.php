<?php


use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\PasswordResetSent;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\Signup;
use App\Http\Livewire\Email\VerifyEmail;
use App\Http\Livewire\Home;
use App\Http\Livewire\Posts\CreatePost;
use App\Http\Livewire\Posts\OnePost;
use App\Http\Livewire\Ui\User\AllNotifications;
use App\Http\Livewire\User\Profile;
use App\Http\Livewire\User\Settings;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['guest']], static function () {
    Route::get('/', Login::class)
        ->name("login");

    Route::get('/signup', Signup::class)
        ->name('signup');

    Route::get('/forgot-password', ForgotPassword::class)
        ->name('password.request');

    Route::get('/reset-password/{token}', ResetPassword::class)
        ->name('password.reset');
});

Route::group(['middleware' => ['auth'], 'excluded_middleware' => 'verified'], static function () {
    //"ricordati di cliccare il link nelle email"
    Route::get('/email/verify-email', VerifyEmail::class)
        ->name('verification.notice');

    //"clicca qui per verificare l email"
    Route::get('/email/verify-email/{id}/{hash}', static function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/home');
    })->middleware(['auth', 'signed'])->name('verification.verify');
});

Route::name('inside.')
    ->middleware(['auth', 'verified'])
    ->group(static function () {
        Route::get('/home', Home::class)
            ->name('home');

        Route::get('/profile/{username?}', Profile::class)
            ->name('profile');

        Route::get('/settings', Settings::class)
            ->name('settings');

        Route::get('/new-post/{post?}', CreatePost::class)
            ->name('newPost');

        Route::get('/post/{post}', OnePost::class)
            ->name('viewPost');

        Route::get('/all-notifications', AllNotifications::class)
            ->name('allNotifications');
    });

Route::get("/logout", static function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
