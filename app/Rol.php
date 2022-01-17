<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = "roles";

    protected $filleable = [
        "id", "nombre"
    ];

    protected $hidden = [
        "created_at", "updated_at"
    ];

    public function funcionario()
    {
        return $this->hasMany(Funcionario::class, 'roles_id', 'id');
    }
}
