<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\OtpRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyRequest;
use App\Http\Requests\updatePasswordRequest;

class AuthController extends Controller
{
    public $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function store(OtpRequest $request)
    {
        $email = $request->input('email');

        $user = AuthService::checkUserViaEmail($email);
        
        if($user){
            return AuthService::sendOtp($user);
        }
    }

    public function verify(VerifyRequest $request)
    {
        $email = $request->input('email');
        $otp   = $request->input('otp');

        
       return $this->authService->__involeToken($email, $otp);
    }

    public function forgetPassword(OtpRequest $request)
    {
        $email = $request->input('email');
        
        $user = AuthService::checkUserViaEmail($email);

        if($user){
            return response()->json([
                'status'  => true,
                'message' => 'User Found',
                'data'    => $user->only('id', 'name', 'email'),
                'code'    => 200
            ], 200);
        }else{
            return response()->json([
                'status'  => false,
                'message' => 'User not Found',
                'data'    => [],
                'code'    => 404
            ], 404);
        }
    }

    public function updatePassword(updatePasswordRequest $request)
    {
        $email       = $request->input('email');
        $newPassword = $request->input('new_password');
        
        return AuthService::passWordHashing($email,$newPassword);
    }
}
