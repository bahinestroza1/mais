<?php

namespace App\Http\Controllers;

use App\Centro;
use App\Competencia_Laboral;
use App\Municipio;
use App\Oferta_Competencia_Laboral;
use App\Oferta_Programa;
use App\Programa;
use App\Programa_Centro;
use App\Servicio;
use App\Solicitud;
use App\Trimestre;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiciosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ver_ofertas(Request $request)
    {
        acceso_a(1,2,3,4);
        $request->flash();
        $data = $request->all();

        $ofertas_programas = Oferta_Programa::select('ofertas_programas.*')
        ->join('programas_centros', 'ofertas_programas.programas_centros_id','programas_centros.id')
        ->join('programas', 'programas_centros.programas_id','programas.id');

        if(isset($data['filtro_programa']) && $data['filtro_programa'] != "null"){
            $ofertas_programas->where('programas.id', $data['filtro_programa']);
        }

        if(isset($data['filtro_nivel_formacion']) && $data['filtro_nivel_formacion'] != "null"){
            $ofertas_programas->where('programas.nivel_formacion', $data['filtro_nivel_formacion']);
        }
        
        if(isset($data['filtro_modalidad']) && $data['filtro_modalidad'] != "null"){
            $ofertas_programas->where('ofertas_programas.modalidad', $data['filtro_modalidad']);
        }

        if(isset($data['filtro_centro']) && $data['filtro_centro'] != "null"){
            $ofertas_programas->where('programas_centros.centros_id', $data['filtro_centro']);
        }

        if(isset($data['filtro_municipio']) && $data['filtro_municipio'] != "null"){
            $ofertas_programas->where('ofertas_programas.municipios_id', $data['filtro_municipio']);
        }

        if(isset($data['filtro_trimestre']) && $data['filtro_trimestre'] != "null"){
            $ofertas_programas->where('ofertas_programas.trimestreS_ID', $data['filtro_trimestre']);
        }

        if(isset($data['filtro_estado_oferta']) && $data['filtro_estado_oferta'] != "null"){
            $ofertas_programas->where('ofertas_programas.estado', $data['filtro_estado_oferta']);
        }else{
            $ofertas_programas->where('ofertas_programas.estado', 1);
        }

        $ofertas_programas = $ofertas_programas->paginate(10)->appends(request()->all());

        if ($request->ajax()) {
            return view('Servicios.oferta.tabla', compact('ofertas_programas'));
        }

        $programas = Programa::all();
        $municipios = Municipio::all();
        $centros = Centro::all();
        $trimestres = Trimestre::all();

        return view('Servicios.oferta.index', compact('programas','municipios', 'centros', 'trimestres', 'ofertas_programas'));
    }

    public function ver_oferta(Request $request)
    {
        acceso_a(1,2,3,4);
        $data = $request->all();

        $oferta_programa = Oferta_Programa::find($data['idOfertaPrograma']);

        // if (tiene_rol(1)) {
        //     $centros = Centro::all();
        //     return view('Servicios.oferta.modal', compact('oferta_programa'));
        // }

        // $programas->whereIn('id', Programa_Centro::where('centros_id', Auth::user()->centros_id)->get()->pluck('programas_id'));

        return view('Servicios.oferta.modal', compact('oferta_programa'));

    }

    public function ver_ofertas_competencias(Request $request)
    {
        acceso_a(1,2,3,4);
        $request->flash();
        $data = $request->all();

        $ofertas_competencias = Oferta_Competencia_Laboral::select('ofertas_competencias.*')
        ->join('competencias_laborales_centros', 'ofertas_competencias.competencias_laborales_centros_id','competencias_laborales_centros.id')
        ->join('competencias_laborales','competencias_laborales_centros.competencias_id','competencias_laborales.id');

        if(isset($data['filtro_nombre']) && $data['filtro_nombre'] != "null"){
            $ofertas_competencias->where('competencias_laborales.nombre', 'like', "%".$data['filtro_nombre']."%");
        }

        if(isset($data['filtro_codigo_nscl']) && $data['filtro_codigo_nscl'] != "null"){
            $ofertas_competencias->where('competencias_laborales.codigo_nscl', 'like', "%".$data['filtro_codigo_nscl']."%");
        }
        
        if(isset($data['filtro_centro']) && $data['filtro_centro'] != "null"){
            $ofertas_competencias->where('competencias_laborales_centros.centros_id', $data['filtro_centro']);
        }

        if(isset($data['filtro_municipio']) && $data['filtro_municipio'] != "null"){
            $ofertas_competencias->where('ofertas_competencias.municipios_id', $data['filtro_municipio']);
        }

        if(isset($data['filtro_trimestre']) && $data['filtro_trimestre'] != "null"){
            $ofertas_competencias->where('ofertas_competencias.trimestre', $data['filtro_trimestre']);
        }

        if(isset($data['filtro_estado_oferta']) && $data['filtro_estado_oferta'] != "null"){
            $ofertas_competencias->where('ofertas_competencias.estado', $data['filtro_estado_oferta']);
        }else{
            $ofertas_competencias->where('ofertas_competencias.estado', 1);
        }

        $ofertas_competencias = $ofertas_competencias->paginate(5)->appends(request()->all());

        if ($request->ajax()) {
            return view('Servicios.oferta.competencia_laboral.tabla', compact('ofertas_competencias'));
        }

        $municipios = Municipio::all();
        $centros = Centro::all();
        $trimestres = Trimestre::all();

        return view('Servicios.oferta.competencia_laboral.index', compact('municipios', 'centros', 'trimestres', 'ofertas_competencias'));
    }

    public function ver_oferta_competencia(Request $request)
    {
        acceso_a(1,2,3,4);
        $data = $request->all();

        $oferta_competencia = Oferta_Competencia_Laboral::find($data['idOfertaCompetencia']);

        return view('Servicios.oferta.competencia_laboral.modal', compact('oferta_competencia'));

    }

    //
    public function ver_solicitudes(Request $request)
    {
        $request->flash();
        $data = $request->all();
        $solicitudes = Solicitud::select('*');        

        if(isset($data['filtro_servicio']) && $data['filtro_servicio'] != "null"){
            $solicitudes->where('servicios_id', $data['filtro_servicio']);
        }
        
        if(isset($data['filtro_estado']) && $data['filtro_estado'] != "null"){
            $solicitudes->where('estado', $data['filtro_estado']);
        }
        
        if(isset($data['filtro_fecha_inicio']) && isset($data['filtro_fecha_fin'])){
            $solicitudes->whereBetween('fecha_solicitud', [$data['filtro_fecha_inicio'],$data['filtro_fecha_fin']]);
        }

        if (tiene_rol(4,2)) {
            // Solicitudes que el centro tenga oferta ó no sea de tipo formacion o competencia laboral
            $ofertas_programas = Oferta_Programa::select('programas_centros.programas_id')
            ->join('programas_centros','ofertas_programas.programas_centros_id', 'programas_centros.id')
            ->where('programas_centros.centros_id', Auth::user()->centros_id)->get();

            $ofertas_competencias = Oferta_Competencia_Laboral::select('competencias_laborales_centros.competencias_id')
            ->join('competencias_laborales_centros', 'ofertas_competencias.competencias_laborales_centros_id','competencias_laborales_centros.id')
            ->where('competencias_laborales_centros.centros_id', Auth::user()->centros_id)->get();
            
            $solicitudes->where(function ($query) use ( $ofertas_programas, $ofertas_competencias ) {
                $query->whereIn('programas_id', $ofertas_programas)
                ->orWhereIn('competencias_id', $ofertas_competencias)
                ->orWhereNotIn('solicitudes.servicios_id', [3,4]);
            });
            
            $solicitudes->orderBy('solicitudes.estado');
                    
            $solicitudes = $solicitudes->paginate(10)->appends(request()->all());
            
            if ($request->ajax()) {
                return view('Servicios.solicitudes.tabla', compact('solicitudes'));
            }
            
            $servicios = Servicio::all();
            return view('Servicios.solicitudes.index', compact('solicitudes', 'servicios'/*, 'ofertas_centros'*/));
        }

        $solicitudes = $solicitudes->paginate(3)->appends(request()->all());

        if ($request->ajax()) {
            return view('Servicios.solicitudes.tabla', compact('solicitudes'));
        }

        $servicios = Servicio::all();
        return view('Servicios.solicitudes.index', compact('solicitudes', 'servicios'));
    }

    public function ver_solicitud(Request $request)
    {
        $data = $request->all();

        $solicitud = Solicitud::find($data['idSolicitud']);

        // if (tiene_rol(1)) {
        //     $centros = Centro::all();
        //     return view('Servicios.oferta.modal', compact('oferta_programa'));
        // }

        // $programas->whereIn('id', Programa_Centro::where('centros_id', Auth::user()->centros_id)->get()->pluck('programas_id'));

        return view('Servicios.solicitudes.modal_ver_solicitud', compact('solicitud'));

    }
    
    public function tomar_solicitud(Request $request)
    {
        $data = $request->all();

        $solicitud = Solicitud::find($data['idSolicitud']);

        $ofertas_centros = [];

        if ($solicitud != null) {
            switch ($solicitud->servicios_id) {
                case '3':
                    $ofertas_centros = Oferta_Programa::select('ofertas_programas.*')
                    ->join('programas_centros','ofertas_programas.programas_centros_id', 'programas_centros.id')
                    ->where('programas_centros.programas_id', $solicitud->programas_id)
                    ->where('programas_centros.centros_id', Auth::user()->centros_id)->get();
                    break;
                    
                case '4':
                    $ofertas_centros = Oferta_Competencia_Laboral::select('ofertas_competencias.*')
                    ->join('competencias_laborales_centros','ofertas_competencias.competencias_laborales_centros_id', 'competencias_laborales_centros.id')
                    ->where('competencias_laborales_centros.competencias_id',$solicitud->competencias_id)
                    ->where('competencias_laborales_centros.centros_id', Auth::user()->centros_id)->get();
                    break;
                
                default:
                    break;
            }
        }
        return view('Servicios.solicitudes.modal_tomar_solicitud', compact('solicitud', 'ofertas_centros'));
    }

    public function asignar_solicitud(Request $request)
    {
        $data = $request->all();

        $solicitud = Solicitud::find($data['idSolicitud']);
        if ($solicitud == null) {
            return json_encode(["type"=> "error", "message"=>"No se encontró la SOLICITUD."]);
        }

        //No es una solicitud de formación o competencia laboral
        if ($data['idOferta'] == null) {           
            try {
                DB::beginTransaction();

                $solicitud->estado = 2;
                $solicitud->fecha_aprobacion = now();
                $solicitud->funcionarios_aprobo_id = Auth::user()->id;

                if($solicitud->save()){
                    DB::commit();
                    return json_encode(["type"=> "success", "message"=>"Se ha asignado la SOLICITUD correctamente."]);
                }
                DB::rollBack();
                return json_encode(["type"=> "error", "message"=>"No se ha podido asignar la SOLICITUD."]);
                
            } catch (\Throwable $th) {
                DB::rollBack();
                return json_encode(["type"=> "error", "message"=>"Error. No se ha podido asignar la SOLICITUD."]);
            }
        } else {
            // Es un servicio de formacion
            try {
                if ($data['tipoServicio'] == 3) {
                    $oferta_programa = Oferta_Programa::find($data['idOferta']);
                    if ($oferta_programa == null) {
                        return json_encode(["type"=> "error", "message"=>"No se encontró la OFERTA DEL PROGRAMA."]);
                    }
                    DB::beginTransaction();

                    $solicitud->estado = 2;
                    $solicitud->fecha_aprobacion = now();
                    $solicitud->funcionarios_aprobo_id = Auth::user()->id;  
                    $solicitud->ofertas_programas_id = $data['idOferta'];    

                    if($solicitud->save()){
                        $oferta_programa->estado = 2;    
                        if ($oferta_programa->save()) {
                            DB::commit();
                            return json_encode(["type"=> "success", "message"=>"Se ha asignado la SOLICITUD correctamente."]);
                        }
                    }
                    DB::rollBack();
                    return json_encode(["type"=> "error", "message"=>"No se ha podido asignar la SOLICITUD."]);

                }else{

                    $oferta_competencia = Oferta_Competencia_Laboral::find($data['idOferta']);
                    if ($oferta_competencia == null) {
                        return json_encode(["type"=> "error", "message"=>"No se encontró la COMPETENCIA LABORAL."]);
                    }
                    DB::beginTransaction();

                    $solicitud->estado = 2;
                    $solicitud->fecha_aprobacion = now();
                    $solicitud->funcionarios_aprobo_id = Auth::user()->id;  
                    $solicitud->ofertas_competencias_id = $data['idOferta'];    

                    if($solicitud->save()){
                        $oferta_competencia->estado = 2;    
                        if ($oferta_competencia->save()) {
                            DB::commit();
                            return json_encode(["type"=> "success", "message"=>"Se ha asignado la SOLICITUD correctamente."]);
                        }
                    }

                    DB::rollBack();
                    return json_encode(["type"=> "error", "message"=>"No se ha podido asignar la SOLICITUD."]);

                }
            } catch (\Throwable $th) {
                DB::rollBack();
                return json_encode(["type"=> "error", "message"=>"Error. No se ha podido asignar la SOLICITUD."]);
            }                
        }
    }

    public function crear_solicitudes(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            $validator = Validator::make($data, [
                "titulo_solicitud" => "required|string",
                "descripcion_solicitud" => "required|string",
                "usuario_solicitud" => "required|numeric",
                "tipo_solicitud" => "required|numeric",
                "cupos" => "required|numeric"
            ]);
    
            if ($validator->fails()) {
                return ($validator->errors()->all());
            }

            try {
                DB::beginTransaction();
                $new_solicitud = new Solicitud;
                $new_solicitud->titulo = $data['titulo_solicitud'];
                $new_solicitud->descripcion = $data['descripcion_solicitud'];
                $new_solicitud->usuarios_id = $data['usuario_solicitud'];
                $new_solicitud->funcionarios_id = Auth::user()->id;
                $new_solicitud->programas_id = isset($data['programa_solicitado']) ? $data['programa_solicitado'] : null;
                $new_solicitud->competencias_id = isset($data['competencia_solicitada']) ? $data['competencia_solicitada'] : null;
                $new_solicitud->servicios_id = $data['tipo_solicitud'];
                $new_solicitud->cupos = $data['cupos'];

                if ($new_solicitud->save()) {
                    DB::commit();
                    return json_encode(["type"=> "success", "message"=>"La solicitud se ha creado correctamente."]);                         
                }   
                DB::rollBack();    
                return json_encode(["type"=> "error", "message"=>"La solicitud no ha podido ser creada."]);
                
            } catch (\Throwable $th) {
                DB::rollBack();    
                return json_encode(["type"=> "error", "message"=>"La solicitud no ha podido ser creada."]);
            }

        }

        $servicios = Servicio::all();
        $programas = Programa::all();
        $competencias_laborales = Competencia_Laboral::all();
        $usuarios = User::all();

        return view('Servicios.solicitudes.modal_crear_solicitud', compact('servicios', 'programas', 'usuarios', 'competencias_laborales'));
    }
}
