<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
            } else {
                $newUser = User::updateOrCreate(
                    [
                        'email' => $user->email,
                    ],
                    [
                        'name' => $user->name,
                        'google_id' => $user->id,
                        'password' => Hash::make('12345678'), // Menggunakan Hash::make untuk mengenkripsi password
                    ]
                );

                Auth::login($newUser);
            }
            return redirect()->intended('dashboard');
        } catch (\Exception $e) {
            // Menangani error jika terjadi kesalahan dalam proses
            return redirect()->route('login')->withErrors(['msg' => 'Terjadi kesalahan dalam proses login dengan Google']);
        }
    }
}
