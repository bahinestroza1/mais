<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('tiene_rol')) {
    /**
     *Verifica si el usuario posee uno de los roles enviados como parametro.
     * @return bool
     */
    function tiene_rol(...$roles)
    {
        if (empty($roles) || empty(Auth::user()->roles_id)) {
            return false;
        }
        return in_array(Auth::user()->roles_id, $roles);
    }
}
if (!function_exists('acceso_a')) {
    /**
     * Da acceso unicamente a los roles enviados como parametro.
     * @return bool
     */
    function acceso_a(...$roles)
    {
        if (empty($roles) || empty(Auth::user()->roles_id)) {
            return abort(403);
        }
        return abort_if(!in_array(Auth::user()->roles_id, $roles), 403);
    }
}

if (!function_exists('convertir_mes')) {
    /**
     * Convierte el número del mes en mes.
     * @return string
     */
    function convertir_mes($mes)
    {
        if(is_numeric($mes)){
            $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
            return $meses[$mes];
        }
        return -1;
    }
}

