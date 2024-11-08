<?php

namespace App\Services;

use App\Models\User;
use App\Traits\TokenGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    use TokenGenerator;
    
    public static function checkUserViaEmail($email)
    {
        $user = User::whereEmail($email)->first();

        if($user){
            return $user;
        }else{
            return false;
        }
    }

    public static function sendOtp($user)
    {
        try {
            DB::beginTransaction();

            $otpCode = AuthService::getToken();
            if($user != null){
                $user->otp = $otpCode ;
                $res = $user->save();
                DB::commit();
                
                if($res){
                    // For Mail Encryption
                    // Mail::to($user->email)->send(new \App\Mail\OtpMail($otpCode, $user));
                    
                    return response()->json([
                        'status'  => true,
                        'message' => 'Otp send successfully',
                        'data'    => $user->only('id', 'name', 'email'),
                        'otp'     => $otpCode,
                        'code'    => 200
                    ], 200);
                }else{
                    return response()->json([
                        'status'  => false,
                        'message' => 'Otp send failed',
                        'code'    => 404
                    ], 404);
                }
            }else{
                return response()->json([
                        'status'  => false,
                        'message' => 'User Not found',
                        'code'    => 404
                    ], 404);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }

    public function __involeToken($email, $otp)
    {
        $res = $this->verifyToken($email, $otp);
        if($res === true){
            return response()->json([
                'status' => true,
                'message' => 'Otp matched!',
                'data' => User::whereEmail($email)->select('id', 'name', 'email')->first(),
                'code' => 200
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Otp not matched!',
                'data' => [],
                'code' => 400
            ], 200);
        }
    }

    public static function passWordHashing($email, $password)
    {
        try {
            DB::beginTransaction();

            $user = User::whereEmail($email)->select('id', 'name', 'email')->first();

        if($user){
            $user->password   = Hash::make($password);
            $user->updated_at = Carbon::now();
            $res              = $user->save();

            DB::commit();
            if($res){
                return response()->json([
                    'status'  => true,
                    'message' => 'Password update successfully',
                    'data'    => $user->only('id', 'name', 'email'),
                    'code'    => 200
                ], 200);
            }
        }else{
            return response()->json([
                'status'  => false,
                'message' => 'User not Found',
                'data'    => [],
                'code'    => 404
            ], 404);
        }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }
}
