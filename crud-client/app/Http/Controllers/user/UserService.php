<?php
namespace App\Http\Controllers\user;

use App\Helpers\CryptoHelper;
use App\Http\Controllers\user\dtos\UserCreateDto;
use App\Http\Controllers\user\dtos\UserUpdateDto;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Str;

class UserService
{
    public function createUser(UserCreateDto $dto): array
    {
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

        return [
            'response' => true,
            'message' => 'success',
            'id_user' => $user->id
        ];
    }

    public function updateUser(UserUpdateDto $dto): array
    {
        $user = User::findOrFail($dto->id_user);

        $updates = [
            'user' => CryptoHelper::encrypt($dto->user),
            'name' => CryptoHelper::encrypt($dto->name),
            'phone' => CryptoHelper::encrypt($dto->phone),
            'password' => bcrypt($dto->password)
        ];

        $fields = ['consent_id2', 'consent_id3'];

        foreach ($fields as $field) {
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

        return [
            'response' => true,
            'message' => 'success'
        ];
    }
    public function deleteUser($id): array
    {
        $user = User::find($id);
        if (!$user) {
            return ['response' => false, 'message' => 'User not found'];
        }
        $user->delete();
        return ['response' => true, 'message' => 'success'];
    }
}
