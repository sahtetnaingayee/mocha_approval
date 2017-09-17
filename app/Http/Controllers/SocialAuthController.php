<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;

class SocialAuthController extends Controller
{
    //

    public function redirect(){

    	return Socialite::driver('facebook')->redirect();  
    }

    public function callback()
    {
        $user = $this->createOrGetUser(Socialite::driver('facebook')->user());

        auth()->login($user);

        return redirect()->to('/home');
    }

    public function createOrGetUser($providerUser)
    {

    	

        $account = User::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {

            return $account->user;

        } else {


            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'provider_user_id' => $providerUser->getId(),
                	'provider' => 'facebook'
                ]);
            }

            //$account->user()->associate($user);
            $user->save();

            return $user;

        }

    }
}
