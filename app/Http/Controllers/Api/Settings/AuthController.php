<?php

namespace App\Http\Controllers\Api\Settings;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Traits\ApiResponse;
use App\Models\Settings\User;
use App\Http\Controllers\Controller;
use App\Services\Settings\UserService;
use App\Http\Resources\Settings\UserResource;
use App\Http\Requests\Settings\AuthLoginRequest;
use App\Http\Requests\Settings\UserStoreRequest;
use App\Http\Requests\Settings\ChangePasswordRequest;
use App\Http\Documentation\Settings\AuthDocumentation;

class AuthController extends Controller implements AuthDocumentation
{
    use ApiResponse;

    protected $UserService;

    /**
     * The String to generate a Valid API Token
     *
     * @var String $token_word
    */
    protected $token_word = 'Api Token Sanctum';

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }


    public function register(UserStoreRequest $request)
    {
        $data = $request->only(['name', 'password', 'email']);
        $data['role_id'] = 2;

        $result = $this->UserService->saveUser($data);

        if ($result instanceof User)
        { $result = new UserResource($result);  }

        $token = $result->createToken($this->token_word)->plainTextToken;

        return $this->successResponse(['user' => $result, 'token' => $token]);
    }


    public function login(AuthLoginRequest $request)
    {
        $data = $request->only(['email', 'password']);

        if (!Auth::attempt($data))
        { return $this->errorResponse('Las credenciales no coinciden.', 401); }

        return $this->successResponse([
            'token' => auth()->user()->createToken($this->token_word)->plainTextToken,
            'user' => new UserResource(auth()->user()),
        ]);
    }


    public function me(Request $request) {
        $result = new UserResource(auth()->user());
        return $this->successResponse($result);
    }


    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return $this->successResponse('Sesión finalizada.');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->only([
            'current_password',
            'new_password',
            'repeat_new_password'
        ]);
        if (\Hash::check($data['current_password'], auth()->user()->password)) {
            if ($data['new_password'] == $data['repeat_new_password']) {
                $result = $this->UserService->changePassword($data);

                if ($result instanceof User) {
                    $result = new UserResource($result);
                }

                return $this->successResponse($result);
            } else {
                return $this->errorResponse('new_password y repeat_new_password no coinciden.', 401);
            }
        } else {
            return $this->errorResponse('Contraseña actual incorrecta.', 401);
        }
    }
}
