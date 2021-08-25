<?php

namespace App\Repositories\Settings;

use App\Models\Settings\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str as Str;

class UserRepository
{

    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get all records.
     *
     * @return Collection $user
     */
    public function getAll($data)
    {
        return $this->user->FilterByStatusId($data['status_id'])->FilterByRoleName($data['role_name'])->get();
    }

    /**
     * Store User
     *
     * @param array $data
     * @return User
     */
    public function saveUser($data)
    {
        $newUser = $this->user::create([
            'name'     => $data['name'],
            'password' => \Hash::make($data['password']),
            'email'    => $data['email'],
            //'image'    => isset($data['image']) ? $data['image'] : null,
        ]);

        $newUser->roles()->sync($data['role_id']);

        return $newUser;
    }

    /**
     * Show User
     *
     * @param array $data
     * @return User
     */
    public function showUser($data)
    {
        return $this->user::findOrFail($data['user_id']);
    }

    /**
     * Update User
     *
     * @param array $data
     * @return User
     */
    public function update($data)
    {
        $user = $this->user::find($data['id']);

        if (!isset($user))
        {  throw new \InvalidArgumentException('El registro que desea actualizar no existe.');  }

        $user->update([
            'name'     => isset($data['name'])     ? $data['name']                  : $user->name,
            'email'    => isset($data['email'])    ? $data['email']                 : $user->email,
            'image'    => isset($data['image'])    ? $data['image']                 : $user->image,
            'status'   => isset($data['status'])   ? $data['status']                : $user->status,
        ]);

        return $user;
    }

    /**
     * Delete User
     *
     * @param integer $id
     * @return User
     */
    public function deleteUser($id)
    {
        $user = $this->user::find($id);

        if (!isset($user))
        {  throw new \InvalidArgumentException('El registro que desea eliminar no existe.');  }

        $user->delete();

        return 'Registro eliminado exitosamente.';
    }


    /**
     * Change Password
     *
     * @param array $data
     * @return User
     */
    public function changePassword($data)
    {
        $user = $this->user::find(auth()->user()->id);
        $user->update([
            'password' => \Hash::make($data['new_password']),
        ]);
        return $user;
    }
}