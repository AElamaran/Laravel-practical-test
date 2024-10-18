<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request):JsonResponse
    {
         $credentials = $request->only('email', 'password');
        
        // Attempt to authenticate the user
        if (!Auth::attempt($credentials)) {
            // If the credentials don't match, throw a validation exception
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $request->authenticate();

        // $request->session()->regenerate();
        $user = $request ->user();
        $user ->tokens()->delete();
        $token =$user -> createToken('api-token');

        return response()->json([
            'user'=>$user,
            'token'=> $token->plainTextToken,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
