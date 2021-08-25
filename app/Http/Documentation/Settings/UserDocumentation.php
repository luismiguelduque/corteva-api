<?php


namespace App\Http\Documentation\Settings;

use Illuminate\Http\Request;

use App\Http\Requests\Settings\UserStoreRequest;
use App\Http\Requests\Settings\UserUpdateRequest;

interface UserDocumentation
{
    /**
     * @OA\Get(
     *     tags={"Users (Usuarios)"},
     *     path="/api/users",
     *     summary="Obtiene un listado de los usuarios",
     *     @OA\Parameter(
     *         name="status_id",
     *         in="query",
     *         description="Identificador (ID) de Estado de usuarios a listar. Puede cargar un único ID, Ej: 1 / O Cargar un arreglo de IDs, Ej: [1, 2, 3, 4, 5].",
     *         required=false,
     *         @OA\Schema(
     *             type="integer, array integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="role_name",
     *         in="query",
     *         description="Nombre del Rol por el cual se filtrarán los usuarios a listar. Puede cargar un único nombre, Ej: rol1 / O Cargar un arreglo de IDs, Ej: [rol1, rol2, rol3, rol4, rol5].",
     *         required=false,
     *         @OA\Schema(
     *             type="string, array string"
     *         )
     *     ),
     *     @OA\Response(
     * 	       response=200,
     *         description="Usuarios recuperados con éxito."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function index(Request $request);

    /**
     * @OA\Get(
     *     tags={"Users (Usuarios)"},
     *     path="/api/users/{id}",
     *     summary="Obtiene los datos de un usuario en particular.",
     *     @OA\Response(
     * 	       response=200,
     *         description="Usuario recuperado con éxito."
     *     ),
     *     @OA\Response(
     * 	       response=404,
     *         description="Registro no encontrado."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function show(Request $request, $id);

    /**
     * @OA\Post(
     *     tags={"Users (Usuarios)"},
     *     path="/api/users",
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
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Estado del usuario.",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="role_id",
     *         in="query",
     *         description="Rol para ser asociado al usuario. (Admite un Integer o un Array de Integer)",
     *         required=false,
     *         @OA\Schema(
     *             type="integer, array integer"
     *         )
     *     ),
     *     @OA\Response(
     * 	       response=200,
     *         description="Usuario almacenado con éxito."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function store(UserStoreRequest $request);

    /**
     * @OA\Post(
     *     tags={"Users (Usuarios)"},
     *     path="/api/users-update",
     *     summary="Actualiza los datos de un usuario en particular.",
    *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nombre del usuario.",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Correo electrónico del usuario.",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Estado del usuario.",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="role_id",
     *         in="query",
     *         description="Rol para ser asociado al usuario. (Admite un Integer o un Array de Integer)",
     *         required=false,
     *         @OA\Schema(
     *             type="integer, array integer"
     *         )
     *     ),
     *     @OA\Response(
     * 	       response=200,
     *         description="Usuario actualizado con éxito."
     *     ),
     *      @OA\Response(
     * 	       response=404,
     *         description="Registro no encontrado."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function update(UserUpdateRequest $request);

    /**
     * @OA\Delete(
     *     tags={"Users (Usuarios)"},
     *     path="/api/users/{id}",
     *     summary="Elimina el registro de un usuario en particular.",
     *     @OA\Response(
     * 	       response=200,
     *         description="Usuario eliminado con éxito."
     *     ),
     *     @OA\Response(
     * 	       response=404,
     *         description="Registro no encontrado."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function destroy(Request $request, $id);
}