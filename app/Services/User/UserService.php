<?php

namespace App\Services\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Password;

class UserService extends AbstractService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->repository->store($data);
    }

    public function login($request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['message' => 'Email ou senha incorretos'], 401);
        }

        $user = Auth::user();

        $token = $user->createToken("NOSSA_SEGUROS")->plainTextToken;

        return $token;
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return true;
    }

    public function me()
    {
        return Auth::user()->load('role', 'role.permissions');
    }

    public function forgotPassword(string $userEmail): void
    {
        $userEmail = mb_strtolower($userEmail);

        $user = User::query()
            ->where('email', $userEmail)
            ->first();

        if ($user->google_id !== null) return;

        Password::sendResetLink(['email' => $userEmail]);
    }

    public function resetPassword(array $data): void
    {
        $status = Password::reset($data, function (User $user, string $password) {
            $user->update(['password' => $password]);
        });

        if ($status !== Password::PASSWORD_RESET) {
            throw new Exception(trans($status));
        }
    }
}
