<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use SoftDeletes;

    public $table = 'role_user';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'role_id' => 'integer',
        'user_id' => 'integer',
    ];

    protected $with = [];

    protected $appends = [];

#RELATIONS
    #Relación con Roles (Roles)
    public function role()
    { return $this->belongsTo(Role::class); }

    #Relación con Users (Usuarios)
    public function user()
    { return $this->belongsTo(User::class); }
}
