<?php
namespace App\Http\Controllers\user\dtos;
use Illuminate\Support\Facades\Validator;


class UserUpdateDto extends UserCreateDto
{
    public int $id_user;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->id_user = (int) ($data['id_user'] ?? 0);

        $this->validate($data);
    }

    protected function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'id_user' => 'required',
            'user' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:6',
            'consent_id2' => 'nullable|boolean',
            'consent_id3' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
        }
    }
}
