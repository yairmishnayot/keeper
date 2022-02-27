<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
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

            $token = $user->createToken('keeperToken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 201);
        }
        catch (\Exception $e){
            dd(333);
        }
    }
}
