<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa_Centro extends Model
{
    protected $table = "programas_centros";

    protected $fillable = ["centros_id", "programas_id"];

    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centros_id', 'id');
    }

    public function programa()
    {
        return $this->belongsTo(Programa::class,'programas_id','id');
    }
}
