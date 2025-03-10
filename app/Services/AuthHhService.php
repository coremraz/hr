<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthHhService
{
    public function createUser($userData)
    {
        $user = new User();

        $user->name = $userData['first_name'];
        $user->mid_name = $userData['middle_name'];
        $user->last_name = $userData['last_name'];
        $user->phone = $userData['phone'];
        $user->hh_id = $userData['id'];
        $user->email = $userData['email'];

        return $user->save();
    }

    public function authUser($userData)
    {
        $user = User::where('hh_id', $userData['id'])->first();

        Log::info('AuthHhService::authUser() - User found:', ['user' => $user]);

        if ($user) {
            Auth::login($user);
            Log::info('AuthHhService::authUser() - User logged in:', ['user' => Auth::user()]);
        }

        return (bool) $user;
    }

    public function checkUser($userData)
    {
        return (bool) User::where('hh_id', $userData['id'])->exists();
    }
}
