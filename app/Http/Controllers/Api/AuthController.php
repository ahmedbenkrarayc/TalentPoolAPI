<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();
        //validate
        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $refreshToken = JWTAuth::fromUser(auth()->user(), ['refresh' => true]);

        return $this->respondWithTokens($token, $refreshToken);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        JWTAuth::invalidate(JWTAuth::getToken(), true);

        return response()->json(['message' => 'Logged out successfully'])
            ->cookie('token', '', -1)
            ->cookie('refresh_token', '', -1);
    }

    public function refresh(Request $request)
    {
        try {
            $refreshToken = $request->cookie('refresh_token');

            if (!$refreshToken) {
                return response()->json(['error' => 'Refresh token not found'], 401);
            }

            JWTAuth::setToken($refreshToken);
            $newAccessToken = JWTAuth::refresh();

            return $this->respondWithTokens($newAccessToken, $refreshToken);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid or expired refresh token'], 401);
        }
    }

    protected function respondWithTokens($token, $refreshToken)
    {
        return response()->json([
            'message' => 'Authenticated',
            'user' => auth()->user(),
        ])
        ->cookie('token', $token, 60, '/', null, true, true, false, 'Strict') // 1 hour
        ->cookie('refresh_token', $refreshToken, 20160, '/', null, true, true, false, 'Strict'); // 14 days
    }

    public function user(Request $request)
    {
        return response()->json(auth()->user());
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $resetToken = Str::random(6);
        $expiresAt = Carbon::now()->addMinutes(15);

        $user->update([
            'reset_token' => $resetToken,
            'reset_token_expires_at' => $expiresAt,
        ]);

        Mail::raw("Your password reset code is: $resetToken", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Password Reset Code');
        });

        return response()->json(['message' => 'Reset code sent to email']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'reset_token' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->reset_token !== $request->reset_token || Carbon::now()->gt($user->reset_token_expires_at)) {
            return response()->json(['error' => 'Invalid or expired reset token'], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_token' => null,
            'reset_token_expires_at' => null,
        ]);

        return response()->json(['message' => 'Password reset successfully']);
    }
}
