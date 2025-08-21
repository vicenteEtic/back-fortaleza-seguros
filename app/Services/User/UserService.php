<?php

namespace App\Services\User;

use App\Mail\TwoFactorCodeMail as MailTwoFactorCodeMail;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use TwoFactorCodeMail;

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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email ou senha incorretos'], 401);
        }

        // Gera código 2FA
        $user->generateTwoFactorCode();

        // Envia email
        Mail::to($user->email)->send(new MailTwoFactorCodeMail($user));
        $token = $user->createToken("NOSSA_SEGUROS")->plainTextToken;

        //return $token;
        return response()->json([
            'message' => 'Código 2FA enviado para seu email',
            'user_id' => $user->id // necessário para validar o código depois
        ]);
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
    // Valida o código
    public function verify2fa(array $request)
    {
        $code = $request['code'] ?? null; // <- pega o campo do array

        $user = User::where('two_factor_code', $code)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Código inválido.'
            ], 401);
        }

        if ($user->two_factor_expires_at->lt(now())) {
            return response()->json([
                'status' => 'error',
                'message' => 'O código expirou, solicite um novo.'
            ], 401);
        }

        $user->resetTwoFactorCode();

        $token = $user->createToken("NOSSA_SEGUROS")->plainTextToken;

        return [
            'status' => 'success',
            'message' => 'Autenticação 2FA validada com sucesso.',
            'token' => $token,
           // 'user'  => $user
        ];
    }
}
