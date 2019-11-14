<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ThrottlesLogins;

    public function login(LoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($authorization = $this->authenticate($request)) {
            $this->clearLoginAttempts($request);
            return $this->json('Logged in successfully!', $authorization);
        }
        $this->incrementLoginAttempts($request);
        return $this->json('Invalid credentials', [], Response::HTTP_UNAUTHORIZED);
    }

    public function username()
    {
        return 'email';
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request),
            $this->decayMinutes()
        );
    }

    private function authenticate($request)
    {
        $user = User::where(['email' => $request->email, 'is_active' => 1])->first();

        if (!is_null($user) && Hash::check($request->password, $user->password)) {
            return [
                'user' => new \App\Http\Resources\Api\User\User($user),
                'access' => $this->generateToken($user)
            ];
        }
        return false;
    }

    private function generateToken(User $user): array
    {
        $token = $user->createToken('user token');

        return [
            'auth_type' => 'Bearer',
            'token' => $token->accessToken,
            'expires_at' => $token->token->expires_at->format('Y-m-d H:i:s'),
        ];
    }
}