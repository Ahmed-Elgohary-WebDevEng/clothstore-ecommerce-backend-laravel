<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
//        dd($request);
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone_number' => ['required', 'numeric', 'min:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8'],
        ]);

        $user = User::create([
            ...$validatedData,
            'password' => Hash::make($request->string('password')),
            'active' => true
        ]);

        event(new Registered($user));

        Auth::login($user);

//        return response()->noContent();
        return response()->json(['user' => $user]);
    }
}
