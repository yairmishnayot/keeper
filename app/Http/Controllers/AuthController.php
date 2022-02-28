<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register( AuthRegisterRequest $request){
        try{
            $data = $request->only('name', 'email', 'password');
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);

            $token = $user->createToken('keeperToken' . $user->id . Carbon::now())->plainTextToken;
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

    public function login(AuthLoginRequest $request){
        $data = $request->only('email', 'password');
        $user = User::where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return response()->json([
             'message' => 'Wrong Credentials'
            ], 401);
        }

        $token = $user->createToken('keeperToken' . $user->id . Carbon::now())->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response()->json($response, 201);



    }
}
