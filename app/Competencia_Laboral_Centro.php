<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competencia_Laboral_Centro extends Model
{
    protected $table = 'competencias_laborales_centros';

    protected $fillable = ['competencias_id', 'centros_id'];

    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centros_id', 'id');
    }

    public function competencia_laboral()
    {
        return $this->belongsTo(Competencia_Laboral::class,'competencias_id','id');
    }
}
