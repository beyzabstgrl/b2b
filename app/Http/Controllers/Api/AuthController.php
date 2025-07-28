<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    protected $service;



    public function __construct(UserService $service)
    {
        $this->service = $service;

    }

    public function register(RegisterRequest $request)
    {


        $validatedData = $request->validated();

        try {
            $user = $this->service->store($validatedData);

            return response()->json([
                'status' => true,
                'message' => 'Kayıt başarılı.',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Giriş bilgileri hatalı.'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;



        return response()->json([
            'message' => 'Giriş başarılı.',
            'token' => $token,
            'user' => $user,
        ], 200);
    }
}
