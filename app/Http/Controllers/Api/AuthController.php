<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Support\DTOs\NewUserDTO;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Support\Contracts\Auth\RegisterNewUserContract;

class AuthController extends Controller
{
    private const TOKEN_NAME = 'API TOKEN';

    public function register(RegisterRequest $request, RegisterNewUserContract $action): JsonResponse
    {
        $params = $request->validated();

        $user = $action(NewUserDTO::make(...$params));

        return response()->json([
            'user' => $user,
            'token' => $this->generateApiToken($user, self::TOKEN_NAME),
            'status' => true
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $params = $request->validated();

        if (Auth::attempt($params) == false) {
            return response()->json([
                'status' => false,
                'error' => 'user not found'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $params['email'])->first();

        return response()->json([
            'status' => true,
            'token' => $this->generateApiToken($user, self::TOKEN_NAME),
            'user' => $user,
        ], Response::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true
        ], Response::HTTP_OK);
    }

    private function generateApiToken(User $user, string $name): string
    {
        return $user->createToken($name)->plainTextToken;
    }
}
