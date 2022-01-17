<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = "solicitudes";

    public function programa()
    {
        return $this->belongsTo(Programa::class,'programas_id','id');
    }

    public function competencia_laboral()
    {
        return $this->belongsTo(Competencia_Laboral::class,'competencias_id','id');
    }
    
    public function servicio()
    {
        return $this->belongsTo(Servicio::class,'servicios_id','id');
    }
    
    public function funcionario_registra()
    {
        return $this->belongsTo(Funcionario::class,'funcionarios_id','id');
    }
    
    public function funcionario_aprueba()
    {
        return $this->belongsTo(Funcionario::class,'funcionarios_aprobo_id','id');
    }
    
    public function usuario()
    {
        return $this->belongsTo(User::class,'usuarios_id','id');
    }
    
    public function oferta_programa()
    {
        return $this->belongsTo(Oferta_Programa::class,'ofertas_programas_id','id');
    }
    
    public function oferta_competencia()
    {
        return $this->belongsTo(Oferta_Competencia_Laboral::class,'ofertas_competencias_id','id');
    }



}
