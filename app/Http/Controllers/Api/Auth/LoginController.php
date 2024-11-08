<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function store(AuthRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::whereEmail($email)->first();

        if($user && Hash::check($password, $user->password)){
            $token = $user->createToken($user->name)->plainTextToken;
            return response()->json([
                'status'     => true,
                'message'    => 'Login successfully',
                'data'       => $user->only('id', 'name', 'email', 'phone'),
                'token'      => $token,
                'token_type' => 'bearer',
            ], 200);
        }else{
            return response()->json([
                'status'     => false,
                'message' => 'User email or password not matched',
            ], 404);
        }
    }
}
