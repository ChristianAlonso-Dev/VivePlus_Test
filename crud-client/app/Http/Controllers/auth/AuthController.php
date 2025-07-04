<?php
namespace App\Http\Controllers\auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\auth\dtos\AuthLoginDto;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getToken(Request $request)
    {
        $dto = new AuthLoginDto($request->all());
        if (!$dto->isValid()) {
            return response()->json(['message' => $dto->getFirstError()], 422);
        }

        $result = $this->authService->authenticate($dto);
        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 401);
        }

        return response()->json([
            'token' => $result['token'],
            'date_finish' => $result['date_finish']
        ]);
    }
}
