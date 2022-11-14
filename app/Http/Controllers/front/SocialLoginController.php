<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        //now i have user information form his social account like:access Token
        try {
            $user = Socialite::driver($provider)->user();
            $authUser = $this->findOrCreateUser($user, $provider);
            Auth::login($authUser, true);
            return redirect('/#');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name'     => ($user->name == null ? $user->nickname : $user->name),
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id,
            'username' => ($user->name == null ? $user->nickname : $user->name),
        ]);
    }

    // public function glcallback($provider)
    // {
    //     try {
    //         $user = Socialite::driver($provider)->user();
    //         $isUser = User::where('google_id', $user->id)->first();
    //         $result = $this->socialAddUser($user, $isUser, $provider_id = 'google_id');
    //         if ($result) {
    //             return redirect('/#');
    //         }
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    // protected function socialAddUser($user, $isUser, $provider_id)
    // {
    //     if ($isUser) {
    //         Auth::login($isUser);
    //         return true;
    //     } else {
    //         $createUser = User::create([
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             $provider_id => $user->id,
    //             'access_token' => $user->token,
    //             'username' => substr($user->name, 0, -5),
    //         ]);
    //         Auth::login($createUser);
    //         return true;
    //     }
    // }
}
