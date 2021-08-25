<?php


namespace App\Http\Documentation\Settings;

use Illuminate\Http\Request;

use App\Http\Requests\Settings\UserStoreRequest;
use App\Http\Requests\Settings\AuthLoginRequest;
use App\Http\Requests\Settings\ChangePasswordRequest;

interface AuthDocumentation
{
    /**
     * @OA\POST(
     *     tags={"Authentication (Autenticación)"},
     *     path="/api/auth/register",
     *     summary="Almacena un nuevo registro de usuario.",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nombre del usuario.",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Correo electrónico del usuario.",
     *         required=true,
     *         @OA\Schema(
     *             type="email, string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Contraseña del usuario.",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="Verificación de contraseña del usuario (Mismo valor del campo <password>).",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     * 	       response=200,
     *         description="Registro completado con éxito."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function register(UserStoreRequest $request);

    /**
     * @OA\POST(
     *     tags={"Authentication (Autenticación)"},
     *     path="/api/auth/login",
     *     summary="Iniciar sesión.",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Correo electrónico del usuario.",
     *         required=true,
     *         @OA\Schema(
     *             type="email, string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Contraseña del usuario.",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     * 	       response=200,
     *         description="Sesión iniciada."
     *     ),
     *     @OA\Response(
     * 	       response=404,
     *         description="Las credenciales no coinciden."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function login(AuthLoginRequest $request);

    /**
     * @OA\Get(
     *     tags={"Authentication (Autenticación)"},
     *     path="/api/auth/me",
     *     summary="Información del usuario autenticado en sistema.",
     *     @OA\Response(
     * 	       response=200,
     *         description="Success."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function me(Request $request);

    /**
     * @OA\Post(
     *     tags={"Authentication (Autenticación)"},
     *     path="/api/auth/logout",
     *     summary="Cerrar sesión.",
     *     @OA\Response(
     * 	       response=200,
     *         description="Sesión finalizada."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function logout(Request $request);

     /**
     * @OA\Post(
     *     tags={"Authentication (Autenticación)"},
     *     path="/api/auth/change-password",
     *     summary="Cambia la contraseña del usuario en sesión.",
     *     @OA\Parameter(
     *         name="current_password",
     *         in="query",
     *         description="Contraseña actual.",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="new_password",
     *         in="query",
     *         description="Contraseña nueva",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="repeat_new_password",
     *         in="query",
     *         description="Repetir nueva contraseña",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     * 	       response=200,
     *         description="Contraseña actualizada con éxito."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function changePassword(ChangePasswordRequest $request);
}