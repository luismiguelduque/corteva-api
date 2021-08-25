<?php

namespace App\Http\Controllers\Api\Settings;

use Illuminate\Http\Request;

use App\Traits\ApiResponse;
use App\Models\Settings\Role;
use App\Http\Controllers\Controller;
use App\Services\Settings\RoleService;
use App\Http\Resources\Settings\RoleResource;
use App\Http\Documentation\Settings\RoleDocumentation;

class RolesController extends Controller implements RoleDocumentation
{
    use ApiResponse;

    protected $RoleService;

    public function __construct(RoleService $RoleService)
    {
        $this->RoleService = $RoleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = $this->RoleService->getAll();
        
        if ($result[0] instanceof Role)
        {  $result = RoleResource::collection($result);  }

        return $this->successResponse($result);
    }
}
