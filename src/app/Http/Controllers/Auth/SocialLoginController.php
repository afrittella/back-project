<?php
namespace Afrittella\BackProject\Http\Controllers\Auth;

use Afrittella\BackProject\Repositories\Users;
use Socialite;
use Auth;

class SocialLoginController
{
    public function redirectToProvider($provider = 'facebook')
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Users $users, $provider = 'facebook')
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect(route('bp.social_login', [$provider]));
        }

        $authUser = $users->createOrGetFromSocial($user, $provider);

        Auth::login($authUser, true);

        return redirect()->route(config('back-project.redirect_after_social_login'));
    }
}