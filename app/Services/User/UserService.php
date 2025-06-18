<?php

namespace App\Services\User;

use Illuminate\Http\Request;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;

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
}
