<?php
namespace App\Http\Controllers\auth\dtos;

use Illuminate\Support\Facades\Validator;

class AuthLoginDto
{
public string $user;
public string $password;
protected $errors;

public function __construct(array $data)
{
$this->user = $data['user'] ?? '';
$this->password = $data['password'] ?? '';
$this->validate($data);
}

protected function validate(array $data): void
{
$validator = Validator::make($data, [
'user' => 'required',
'password' => 'required'
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