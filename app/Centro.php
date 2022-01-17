<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    protected $table = "centros";

    public function funcionario()
    {
        return $this->hasMany(Funcionario::class, 'centros_id', 'id');
    }
}
