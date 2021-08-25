<?php


namespace App\Http\Documentation\Settings;

use Illuminate\Http\Request;

interface RoleDocumentation
{
    /**
     * @OA\Get(
     *     tags={"Roles (Roles)"},
     *     path="/api/roles",
     *     summary="Obtiene un listado de los roles",
     *     @OA\Response(
     * 	       response=200,
     *         description="Roles recuperados con éxito."
     *     ),
     *     @OA\Response(
     * 	       response="default",
     *         description="Unexpected error"
     *     )
     * )
     */
    public function index(Request $request);
}