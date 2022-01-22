<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = "municipios";

    protected $filleable = [
        "nombre", "codigo", "id"
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'municipios_id', 'id');
    }
}
