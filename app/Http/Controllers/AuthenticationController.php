<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{

    public function Register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        $User = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email
        ]);

        return response([
            'status' => 'success',
            'message' => 'Registration Successfull',
            'data' => [
                'name' => $User->name,
                'email' => $User->email,
                'updated_at' => $User->updated_at,
                'created_at' => $User->created_at,
                'id' => $User->id,
                'token' => $User->createToken('register_tokens')->plainTextToken,
            ]
        ], 200);
    }

    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $CheckUser = User::where('email', $request->email)->first();

        if (!$CheckUser || !Hash::check($request->password, $CheckUser


        ->password)) {
            return response([
                'status' => 'error',
                'message' => 'Username or password incorrect'
            ], 401);
        }


        return response([
            'status' => 'success',
            'message' => 'Registration Successfull',
            'data' => [
                'name' => $CheckUser->name,
                'email' => $CheckUser->email,
                'updated_at' => $CheckUser->updated_at,
                'created_at' => $CheckUser->created_at,
                'id' => $CheckUser->id,
                'token' => $CheckUser->createToken('login_tokens')->plainTextToken,
            ]
        ], 200);
    }

    public function Logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        if (!$request) {
            return response([
                "status" => "error",
                "message" => "Unauthenticated"
            ], 401);
        }

        return response([
            'status' => 'error',
            'message' => 'Logout successful'
        ],200);
    }
}
