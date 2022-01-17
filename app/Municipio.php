<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = "municipios";

    protected $filleable = [
        "nombre", "codigo", "id"
    ];

    public function usuario()
    {
        return $this->hasMany(User::class, 'municipio_id', 'id');
    }
}
