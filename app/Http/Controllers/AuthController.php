<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * register a user
     * @param AuthRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register( AuthRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try{
            $data = $request->only('name', 'email', 'password');
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);

            $token = $user->createToken('keeperToken-' . $user->id . '-' .Carbon::now())->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 201);
        }
        catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * login into user
     * @param AuthLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->only('email', 'password');
        $user = User::where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
             'message' => 'Wrong Credentials'
            ], 401);
        }

        $token = $user->createToken('keeperToken-' . $user->id . '-' .Carbon::now())->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json($response, 200);
    }

    /**
     * logout from user
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
