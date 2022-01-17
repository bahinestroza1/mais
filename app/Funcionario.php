<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Funcionario extends Authenticatable
{
    use Notifiable;

    protected $table = "funcionarios";

    protected $fillable = [
        "documento", "nombre", "apellido", "email", "telefono", "tipos_documentos_id", "centros_id", "roles_id"
    ];


    //Relaciones
    public function centro()
    {
        return $this->belongsTo(Centro::class, 'centros_id', 'id');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'roles_id', 'id');
    }

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipos_documentos_id', 'id');
    }
    
    // Metodos
    public function nombre_completo()
    {
        return strtoupper("{$this->nombre} {$this->apellido}");
    }
}
