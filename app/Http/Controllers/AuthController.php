<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        validator(request()->all(), [
            'email' => "required|email|exists:users",
            'password' => "required",
        ])->validate();

        $user = User::where('email', request('email'))->first();

        if (Hash::check(request('password'), $user->getAuthPassword())) {
            return [
                "token" => $user->createToken(time())->plainTextToken
            ];
        }
        return [
            "message" => "Invalid Credentials"
        ];
    }

    public function signup()
    {
        validator(request()->all(), [
            'name' => "required",
            'email' => "required|email|unique:users",
            'password' => "required",
        ])->validate();

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
        ]);
        return [
            "token" => $user->createToken(time())->plainTextToken
        ];
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
    }
}
