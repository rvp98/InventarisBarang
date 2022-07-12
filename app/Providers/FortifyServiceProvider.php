<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest;
use App\Models\User;
use Hash;
use Redirect;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (LoginRequest $request) {
            $user = User::where('email', $request->login)
                    ->orWhere('username', $request->login)
                    ->first();
  
            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->status == '0') {
                    throw ValidationException::withMessages([
                        Fortify::username() => "Your account has been blocked by our system",
                    ]);
                } else {
                    return $user;
                }
            } else {
                throw ValidationException::withMessages([
                    Fortify::username() => "Username not registered or Incorrect password for this user",
                ]);
            }
        });
    }
}
