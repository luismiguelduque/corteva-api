<?php

namespace App\Models\Settings;

use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    public $table = 'users';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                => 'integer',
        'name'              => 'string',
        'email'             => 'string',
        'email_verified_at' => 'datetime',
        'image'             => 'string',
    ];

    protected $with = [];

    protected $appends = [];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    { return UserFactory::new(); }

#ACCESORS
    #Construir la URL del archivo de logo de la Institución
    public function getUrlAttribute()
    { return url('/uploads/users/' . $this->image); }

#SCOPES
    #Filtrar Por Estado de Usuario (Recibe Integer)
    public function scopeFilterByStatusId($query, $status_id = null) {
        if (is_it_null_or_empty($status_id) == true)
        {  return $query;  }

        #Es un Array?
        #Si -> Verifico sus valores y retorno los que cumplan con el tipo de dato INTEGER
        #No -> Almaceno el valor entre [] para convertirlo en un array y luego evaluar su valor
        $statusById = (is_array($status_id)) ? validate_data($status_id, 'integer_array')  : validate_data([$status_id], 'integer_array');

        if (is_it_null_or_empty($statusById) == true)
        { return $query; }

        return $query->whereIn('status', $statusById);
    }

    #Filtrar Por Nombre de Rol los Usuarios (Recibe String|Array de Strings)
    public function scopeFilterByRoleName($query, $role_name = null) {
        if (is_it_null_or_empty($role_name) == true)
        {  return $query;  }


        #Es un Array?
        #Si -> Verifico sus valores y retorno los que cumplan con el tipo de dato STRING
        #No -> Almaceno el valor entre [] para convertirlo en un array y luego evaluar su valor
        $roleByName = (is_array($role_name)) ? validate_data($role_name, 'string_array')  : validate_data([$role_name], 'string_array');

        if (is_it_null_or_empty($roleByName) == true)
        { return $query; }

        return $query->whereHas('roles', function ($fQuery) use ($roleByName) { $fQuery->whereIn('name', array_map('strtolower', $roleByName)); });
    }

#RELATIONS
    #Relación con Role (Roles de este Usuario)
    public function roles()
    { return $this->belongsToMany(Role::class); }

#FUNCTIONS
    #Asignar Rol(es) al Usuario. (Recibe String|Array String)
    public function assingRole($data) {
        if (is_it_null_or_empty($data) == true)
        { return; }

        #Es un Array?
        #Si -> Verifico sus valores y retorno los que cumplan con el tipo de dato STRING
        #No -> Almaceno el valor entre [] para convertirlo en un array y luego evaluar sus valores
        $dataFixed = (is_array($data)) ? validate_data($data, 'string_array') : validate_data([$data], 'string_array');

        $roles     = Role::select('id')->whereIn('name', array_map('strtolower', $dataFixed))->get()->pluck('id')->toArray();
        $userRoles = RoleUser::select('role_id')->where('user_id', $this->id)->get()->pluck('role_id')->toArray();

        if (is_it_null_or_empty($roles) == true)
        { return; }

        $newRoles = array_diff($roles, $userRoles);

        foreach ($newRoles as $key => $role)
        { RoleUser::create(['role_id' => $role, 'user_id' => $this->id]); }

        return;
    }

    #Remover Rol(es) al Usuario. (Recibe String|Array String)
    public function removeRole($data) {
        if (is_it_null_or_empty($data) == true)
        { return; }

        #Es un Array?
        #Si -> Verifico sus valores y retorno los que cumplan con el tipo de dato STRING
        #No -> Almaceno el valor entre [] para convertirlo en un array y luego evaluar sus valores
        $dataFixed = (is_array($data)) ? validate_data($data, 'string_array') : validate_data([$data], 'string_array');

        $roles = Role::select('id')->whereIn('name', array_map('strtolower', $dataFixed))->get()->pluck('id')->toArray();

        if (is_it_null_or_empty($roles) == true)
        { return; }

        $userRoles = RoleUser::where('user_id', $this->id)->whereIn('role_id', $roles)->get();

        foreach ($userRoles as $key => $role)
        {  $role->delete();  }

        return;
    }
}
