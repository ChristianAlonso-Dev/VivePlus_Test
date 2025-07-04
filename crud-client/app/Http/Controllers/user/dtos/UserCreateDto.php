<?php
namespace App\Http\Controllers\user\dtos;
use Illuminate\Support\Facades\Validator;

class UserCreateDto
{
    public string $user;
    public string $name;
    public string $phone;
    public string $password;
    public bool $consent_id2;
    public bool $consent_id3;

    protected $errors;

    public function __construct(array $data)
    {
        $this->user = $data['user'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->consent_id2 = $data['consent_id2'] ?? false;
        $this->consent_id3 = $data['consent_id3'] ?? false;

        $this->validate($data);
    }

    protected function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'user' => 'required|unique:users,user',
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

    public function isValid(): bool
    {
        return !$this->errors;
    }

    public function getFirstError(): ?string
    {
        return $this->errors ? $this->errors->first() : null;
    }
}
