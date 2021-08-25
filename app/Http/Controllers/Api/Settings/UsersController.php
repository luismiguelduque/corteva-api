<?php

namespace App\Http\Controllers\Api\Settings;

use Illuminate\Http\Request;

use App\Traits\ApiResponse;
use App\Models\Settings\User;
use App\Http\Controllers\Controller;
use App\Services\Settings\UserService;
use App\Http\Resources\Settings\UserResource;
use App\Http\Requests\Settings\UserStoreRequest;
use App\Http\Requests\Settings\UserUpdateRequest;
use App\Http\Documentation\Settings\UserDocumentation;

class UsersController extends Controller implements UserDocumentation
{
    use ApiResponse;

    protected $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array(
            'status_id' => $request->input('status_id', null),
            'role_name' => $request->input('role_name', null),
        );

        $result = $this->UserService->getAll($data);

        if (isset($result[0]) && ($result[0] instanceof User))
        {  $result = UserResource::collection($result);  }

        return $this->successResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        var_dump($request->input('role_id'));
        /*$data = $request->only(['name', 'password', 'email']);
        $data['role_id'] = $request->input('role_id');
        $result = $this->UserService->saveUser($data);

        if ($result instanceof User)
        {  $result = new UserResource($result);  }

        return $this->successResponse($result);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data = ['user_id' => $id];

        $result = $this->UserService->showUser($data);

        if ($result instanceof User)
        {  $result = new UserResource($result);  }

        return $this->successResponse($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Settings\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        $data = $request->only(['id', 'name', 'email', 'role_id', 'image', 'status', 'original_image_name',]);

        $result = $this->UserService->update($data);

        if ($result instanceof User)
        {  $result = new UserResource($result);  }

        return $this->successResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $result = $this->UserService->deleteUser($id);

        return $this->successResponse($result);
    }
}
