<?php
namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\user\dtos\UserCreateDto;
use App\Http\Controllers\user\dtos\UserUpdateDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(Request $request)
    {
        $dto = new UserCreateDto($request->all());
        if (!$dto->isValid()) {
            return response()->json(['response' => false, 'message' => $dto->getFirstError()]);
        }

        return $this->userService->createUser($dto);
         
    }

    public function update(Request $request)
    {
        $dto = new UserUpdateDto($request->all());
        if (!$dto->isValid()) {
            return response()->json(['response' => false, 'message' => $dto->getFirstError()]);
        }

       return $this->userService->updateUser($dto);
         
    }

    public function delete(Request $request)
    {
       return $this->userService->deleteUser($request['id_user']);
    }
}