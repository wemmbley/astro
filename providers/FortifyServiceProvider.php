<?php

namespace Providers;

use Inertia\Inertia;
use Modules\Scene\Scenarios\Auth\UseCases\CreateNewUser;
use Modules\Scene\Scenarios\Auth\UseCases\ResetUserPassword;
use Modules\Scene\Scenarios\Auth\UseCases\UpdateUserPassword;
use Modules\Scene\Scenarios\Auth\UseCases\UpdateUserProfileInformation;

use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->registerFortifyActions();
        $this->setRateLimitForLoginAttempts();
        $this->setRateLimitForTwoFactorAuthentication();
        $this->setEmailVerificationVuePage();
        $this->setLoginVueView();
        Fortify::redirects('register', '/register');
    }

    public function setLoginVueView(): void
    {
        Fortify::loginView(function () {
            return Inertia::render('Authorization', []);
        });
    }

    public function setEmailVerificationVuePage(): void
    {
        Fortify::verifyEmailView(function () {
            return Inertia::render('VerifyEmail', []);
        });
    }

    private function setRateLimitForLoginAttempts(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $username = Fortify::username();
            $username = $request->input($username);
            $username = Str::lower($username);

            $ip = $request->ip();

            $uniqueId = $username . '|' . $ip;

            $throttleKey = Str::transliterate($uniqueId);

            return Limit::perMinute(5)
                ->by($throttleKey);
        });
    }

    private function setRateLimitForTwoFactorAuthentication(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            $sessionLoginId = $request->session()
                ->get('login.id');

            return Limit::perMinute(5)
                ->by($sessionLoginId);
        });
    }

    private function registerFortifyActions(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);
    }
}
