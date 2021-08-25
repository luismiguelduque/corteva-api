<?php

namespace App\Services\Settings;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Repositories\Settings\UserRepository;

class UserService
{
    /**
     * @var $UserRepository
    */
    protected $UserRepository;
    /**
     * The Filesystem Root to storage Users Images
     *
     * @var String $file_system_root
     */
    protected $file_system_root = 'users';

    /**
     * UserService constructor.
     *
     * @param UserRepository $UserRepository
     */
    public function __construct(UserRepository $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * Get all Users.
     *
     * @return Collection
     */
    public function getAll($data)
    {
        return $this->UserRepository->getAll($data);
    }

    /**
     * Store User
     * @param array $data
     * @return Model
     */
    public function saveUser($data)
    {
        DB::beginTransaction();
        try {
            $result = $this->UserRepository->saveUser($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

     /**
     * Show User
     *
     * @param array $data
     * @return Model
     */
    public function showUser($data)
    {
        return $this->UserRepository->showUser($data);
    }

    /**
     * Update User
     *
     * @param array $data
     * @return Model
     */
    public function update($data)
    {
        DB::beginTransaction();
        try {
            //Almacenar Nueva Imagen
            if (isset($data['image'])) {
                $storeFileResult = store_file($data['image'], $this->file_system_root);
                if ($storeFileResult['result'] != true) //Ocurrio un problema durante el guardado de la Imagen
                { throw new InvalidArgumentException($storeFileResult['message']); }
                $data['image'] = $storeFileResult['message']; //Capturamos el nombre con el que se guardo la imagen
            }

            $result = $this->UserRepository->update($data);

            #-Si fue Cargado la Nueva Imagen
            #-Si Contamos con el Nombre la Imagen Anterior
            #Entonces =>  Borramos la Imagen Anterior
            if ( (isset($data['image'])) && isset($data['original_image_name']) ) {
                $exists_old = verify_file_existence($data['original_image_name'], $this->file_system_root);

                switch ($exists_old['result']) {
                    case true: #Se encontro la imagen anterior => Lo borramos
                        $deleteFileResult = delete_file($data['original_image_name'], $this->file_system_root);

                        if ($deleteFileResult['result'] != true) //Ocurrio un problema durante el borrado de la imagen anterior
                        { throw new InvalidArgumentException($deleteFileResult['message']); }
                    break;

                    case 'error': #Ocurrio un error durante la busqueda de la imagen anterior
                        throw new InvalidArgumentException($exists_old['message']);
                    break;

                    case false: break; #No se encontro la imagen anterior
                }
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
     * Delete User
     *
     * @param integer $id
     * @return String
     */
    public function deleteUser($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->UserRepository->deleteUser($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    /**
     * Change Password
     * @param array $data
     * @return User
     */
    public function changePassword($data)
    {
        DB::beginTransaction();
        try {
            $result = $this->UserRepository->changePassword($data);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException($e->getMessage());
        }
        DB::commit();

        return $result;
    }
}