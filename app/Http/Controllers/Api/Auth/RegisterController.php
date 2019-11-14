<?php


namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $user = $this->createUser($request);

        if($userData = $this->getAccessToken($user)) {
            return $this->json('User registered successfully', $userData);
        }

        return response()->json(['error' => 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function createUser($request): User
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            return $user;
        });
    }

    private function getAccessToken(User $user): array
    {
        return [
            'user' => new \App\Http\Resources\Api\User\User($user),
            'access' => $this->generateToken($user)
        ];
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