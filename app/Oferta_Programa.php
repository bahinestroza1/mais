<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta_Programa extends Model
{
    protected $table = "ofertas_programas";

    protected $fillable = ['trimestre'];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipios_id', 'id');
    }

    public function programas_centro()
    {
        return $this->belongsTo(Programa_Centro::class,'programas_centros_id','id');
    }

    public function trimestre()
    {
        return $this->belongsTo(Trimestre::class,'trimestres_id','id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class,'servicios_id','id');
    }
    
    public function registrado_por()
    {
        return $this->belongsTo(Funcionario::class,'funcionarios_id','id');
    }

    public function actualizado_por()
    {
        return $this->belongsTo(Funcionario::class,'funcionarios_updated_id','id');
    }
}
