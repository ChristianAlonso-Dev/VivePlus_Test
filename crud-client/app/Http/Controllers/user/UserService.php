<?php
namespace App\Http\Controllers\user;

use App\Helpers\CryptoHelper;
use App\Http\Controllers\user\dtos\UserCreateDto;
use App\Http\Controllers\user\dtos\UserUpdateDto;
use App\Http\utils\CustomResponse;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class UserService
{
    public function createUser(UserCreateDto $dto): JsonResponse
    {
        $existing = User::where('user', CryptoHelper::encrypt($dto->user))->first();
        if ($existing) {
            return CustomResponse::error([], 'El usuario ya existe', 409);
        }
        $consentId1 = Str::random(30);
        $consentId2 = $dto->consent_id2 ? Str::random(30) : null;
        $consentId3 = $dto->consent_id3 ? Str::random(30) : null;

        $user = User::create([
            'user' => CryptoHelper::encrypt($dto->user),
            'name' => CryptoHelper::encrypt($dto->name),
            'phone' => CryptoHelper::encrypt($dto->phone),
            'password' => bcrypt($dto->password),
            'consent_id1' => $consentId1,
            'consent_id2' => $consentId2,
            'consent_id3' => $consentId3,
        ]);
        return CustomResponse::success([
            'id_user' => $user->id
        ], 'Usuario creado');
    }

    public function updateUser(UserUpdateDto $dto): JsonResponse
    {
        $user = User::find($dto->id_user);

        if (!$user) {
            return CustomResponse::error([], 'Usuario no encontrado', 404);
        }

        $encryptedUser = CryptoHelper::encrypt($dto->user);
        $encryptedPhone = CryptoHelper::encrypt($dto->phone);

        $duplicateUser = User::where('user', $encryptedUser)
            ->where('id', '!=', $dto->id_user)
            ->first();

        if ($duplicateUser) {
            return CustomResponse::error([], 'El nombre de usuario ya existe', 409);
        }

        $duplicatePhone = User::where('phone', $encryptedPhone)
            ->where('id', '!=', $dto->id_user)
            ->first();

        if ($duplicatePhone) {
            return CustomResponse::error([], 'El teléfono ya está en uso', 409);
        }

        $updates = [
            'user' => $encryptedUser,
            'name' => CryptoHelper::encrypt($dto->name),
            'phone' => $encryptedPhone,
            'password' => bcrypt($dto->password),
        ];

        foreach (['consent_id2', 'consent_id3'] as $field) {
            $old = $user->$field;
            $new = $dto->$field ? Str::random(30) : null;

            if ($old !== $new) {
                UserLog::create([
                    'user_id' => $user->id,
                    'action' => 'update',
                    'field_changed' => $field,
                    'old_value' => $old,
                    'new_value' => $new,
                    'performed_at' => now()
                ]);
                $updates[$field] = $new;
            }
        }

        $user->update($updates);

        return CustomResponse::success([], 'Usuario actualizado');
    }

    public function deleteUser($id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return CustomResponse::error([], 'Usuario inválido', 404);
        }

        $user->delete();
        return CustomResponse::success([], 'Usuario eliminado');
    }
}
