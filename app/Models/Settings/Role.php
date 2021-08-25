<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    public $table = 'roles';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                => 'integer',
        'name'              => 'string',
        'description'       => 'string',
        'is_active'         => 'boolean',
    ];

    protected $with = [];

    protected $appends = [];

#RELATIONS
    #Relación con User (Usuarios que cuenta con este Rol)
    public function users()
    { return $this->belongsToMany(User::class); }
}
