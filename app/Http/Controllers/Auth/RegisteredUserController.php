<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'other_names' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $username = $this->generateUsername($request->first_name);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'other_names' => $request->other_names,
            'nameSlug' => Str::lower($username),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Student::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
        ]);


        // $user->sendEmailVerificationNotification();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }


    // Function to generate username from first name and last name
    private function generateUsername(string $firstName): string
    {
        // Concatenate first name and last name
        $username = $firstName;

        // Remove spaces and special characters
        $username = preg_replace('/[^A-Za-z0-9]/', '', $username);

        $characters = str_split($username);

        // Shuffle the characters randomly
        shuffle($characters);

        // Generate the username by joining shuffled characters
        $username = implode('', $characters);

        // Check if username already exists
        $count = User::where('nameSlug', $username)->count();

        // If username exists, add a suffix
        if ($count > 0) {
            $username .= $count + 1;
        }

        return $username;

    }
}
