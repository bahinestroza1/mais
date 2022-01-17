<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competencia_Laboral extends Model
{
    protected $table = 'competencias_laborales';

    protected $fillable = ['codigo_nsd'];
}
