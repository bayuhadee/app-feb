<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        $response = Socialite::driver($provider)->user();
        $mahasiswa = Mahasiswa::firstWhere(['Email' => $response->getEmail()]);

        $user = User::firstWhere(['email' => $response->getEmail()]);

        if ($user) {
            $user->update([$provider . '_id' => $response->getId()]);
        } else {
            $user = User::create([
                $provider . '_id' => $response->getId(),
                'name' => $response->getName(),
                'email' => $response->getEmail(),
                'avatar' => $response->getAvatar(),
                'password' => 'password',
                'NPM' => $mahasiswa->NPM ?? null,
            ]);
        }

        Auth::login($user);

        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }

    protected function validateProvider(string $provider): array
    {
        $validator = Validator::make(
            ['provider' => $provider],
            ['provider' => 'in:google']
        );

        return $validator->validate();
    }
}
