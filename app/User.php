<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "usuarios";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'documento', 'nombre', 'apellido', 'email', 'telefono', 'cargo', 'municipios_id', 'tipos_documentos_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function municipios()
    {
        return $this->belongsTo(Municipio::class, 'municipios_id', 'id');
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
