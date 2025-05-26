<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Мои роуты для авторизации
    public function login(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where(['name' => $data['name']])->first();

        if ($user && Hash::check($data['password'], $user['password'])) {
            $token = sha1(Str::random(5));
            $user->update([
                'token' => $token,
            ]);
            return response()->json([
                'token' => $token,
            ]);
        };
        return response()->json(['message' => 'invalid login'], 401);
    }

    public function logout(Request $request) {
        $user = $request->user();
        if ($user) {
            $user->update([
                'token' => null,
            ]);
            return response()->json(['message' => 'logout success']);
        }

    }


    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'status' => 'required',
            'password' => 'required',
        ]);
        $res = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => $data['status'],
            'password' => Hash::make($data['password']),
        ]);
        return response()->json($res);
    }


}
