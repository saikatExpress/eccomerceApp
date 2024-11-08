<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $password = $request->input('password');
            $confirmPassword = $request->input('confirm_password');

            $userObj = new User();

            $userObj->name       = Str::title($name);
            $userObj->email      = $email;
            $userObj->phone      = $phone;
            $userObj->password   = Hash::make($password);
            $userObj->role       = 'user';
            $userObj->status     = 'active';
            $userObj->created_at = Carbon::now();
            $userObj->updated_at = Carbon::now();

            $res = $userObj->save();
            DB::commit();
            if($res){
                return response()->json([
                    'status' => true,
                    'message' => 'User create successfully',
                    'data' => $userObj->only(['name', 'email', 'id']),
                    'code' => 200
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            info($e);
        }
    }
}
