<?php

namespace App\Traits;

use App\Models\User;

trait TokenGenerator
{
    public static function generateToken(): string
    {
        return (string) mt_rand(1000, 9999);
    }

    public static function getToken(): string
    {
        return self::generateToken();
    }

    public function verifyToken($email,$otp): bool
    {
        $exitsOtp = $this->verifyUser($email);

        if($exitsOtp === $otp){
            return true;
        }else{
            return false;
        }
    }

    private function verifyUser($email): string
    {
        $user = User::whereEmail($email)->first();
        if($user){
            return $user->otp;
        }
        return false;
    }
}
