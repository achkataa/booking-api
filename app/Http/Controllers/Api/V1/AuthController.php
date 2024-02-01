<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ],
            [
                'email.required' => 'Email is required',
                'email.email' => 'Email should be valid',
                'password.required' => 'Password is required',
                'password.min' => 'Password should be :min symbols'
            ]
        );

        $user = User::create($data);

        return response()->json($user->only(), 200);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ],
            [
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ]
        );

        if(!\auth()->attempt($data)) {
            return \response()->json([
                'message' => 'Credentials do not match'
            ]);
        }

        $user = User::where('email', $data['email'])->first();

        $authToken = $user->createToken('auth-token')->plainTextToken;

        return \response()->json([
            'access-token' => $authToken
        ]);

    }
}
