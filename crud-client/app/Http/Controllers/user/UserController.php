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

        $result = $this->userService->createUser($dto);
        return response()->json($result);
    }

    public function update(Request $request)
    {
        $dto = new UserUpdateDto($request->all());
        if (!$dto->isValid()) {
            return response()->json(['response' => false, 'message' => $dto->getFirstError()]);
        }

        $result = $this->userService->updateUser($dto);
        return response()->json($result);
    }

    public function delete($id)
    {
        $result = $this->userService->deleteUser($id);
        return response()->json($result);
    }
}