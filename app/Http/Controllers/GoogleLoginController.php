<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleLoginController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderRedirect()
    {
        $user = Socialite::driver('google')->user();
        
        // Znajdź lub zarejestruj użytkownika na podstawie danych z Google
        // Przykładowo, można sprawdzić czy użytkownik istnieje w bazie danych i zalogować go
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            // Można utworzyć nowego użytkownika, jeśli go nie ma w bazie danych
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                // itd.
            ]);
            Auth::login($newUser);
        }

        // Przekieruj użytkownika na stronę po zalogowaniu
        return redirect('/dashboard');
    }
}
