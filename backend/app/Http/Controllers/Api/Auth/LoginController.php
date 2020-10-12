<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login()
    {
        $credentials = request(['cpf', 'password']);

        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid cpf or password'], 401);
        }

        $user = Auth::user();
        $user->patient;
        if($user->patient) {
            $user->patient->addresses;
        }
        $user->doctor;
        $user->administrator;

        return $this->respondWithTokenAndUser($token, $user);
    }

    private function respondWithTokenAndUser($token, $user)
    {
        return response()->json([
            'token' => $token,
            'acess_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }
}
