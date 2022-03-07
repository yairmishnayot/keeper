<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * register a user
     * @param AuthRegisterRequest $request
     * @return JsonResponse
     */
    public function register( AuthRegisterRequest $request): JsonResponse
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
        catch (Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * login into user
     * @param AuthLoginRequest $request
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        try {
            $data = $request->only('email', 'password');
            $user = User::where('email', $data['email'])->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                return response()->json([
                    'message' => 'Wrong Credentials'
                ], 401);
            }

            $token = $user->createToken('keeperToken-' . $user->id . '-' . Carbon::now())->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response);
        }
        catch (Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * logout from user
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
