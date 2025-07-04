<?php
namespace App\Http\Controllers\auth;

use App\Helpers\CryptoHelper;
use App\Http\Controllers\auth\dtos\AuthLoginDto;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class AuthService
{
    public function authenticate(AuthLoginDto $dto): array
    {
        $users = User::select('id', 'user', 'password')->get();

        $user = $users->first(function ($u) use ($dto) {
            $decrypted = CryptoHelper::decrypt($u->user);
            return trim($decrypted) === trim($dto->user);
        });

        if (!$user) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'El usuario no es válido',
            ], Response::HTTP_NOT_FOUND));
        }

        if (!Hash::check($dto->password, $user->password)) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Contraseña inválida',
            ], Response::HTTP_UNAUTHORIZED));
        }

        $user->tokens()->delete();

        $token = $user->createToken('session-token', [], now()->addMinutes(5))->plainTextToken;

        return [
            'success' => true,
            'token' => $token,
            'date_finish' => now()->addMinutes(5)->toDateTimeString()
        ];
    }
}
