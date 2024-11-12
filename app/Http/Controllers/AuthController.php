<?php

namespace App\Http\Controllers;

use App\Helpers\RoleHelper;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Support\StatusCode;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create($request->validated());
    
            $user_role = RoleHelper::getRoleByName('User');
    
            if ($user_role) {
                $user->roles()->attach($user_role->id);
            }
            
            DB::commit();
            
            return response()->json([
                    'status' => 'success',
                    'token_type' => 'Bearer',
                    'token' => JWTAuth::fromUser($user),
            ], StatusCode::SUCCESS);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
        ], StatusCode::INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
                'token_type' => 'Bearer',
                'token' => $token,
        ], StatusCode::SUCCESS);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
                'message' => 'Successfully logged out'
        ], StatusCode::SUCCESS);
    }
}
