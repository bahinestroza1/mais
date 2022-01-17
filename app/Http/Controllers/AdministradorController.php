<?php

namespace App\Http\Controllers;

use App\Centro;
use App\Competencia_Laboral;
use App\Competencia_Laboral_Centro;
use App\Funcionario;
use App\Municipio;
use App\Oferta_Competencia_Laboral;
use App\Oferta_Programa;
use App\Programa;
use App\Programa_Centro;
use App\Rol;
use App\TipoDocumento;
use App\Trimestre;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Gestion de MUNICIPIOS
    public function gestion_municipios(Request $request)
    {
        acceso_a(1,2);
        $datos = $request->all();
        $data = Municipio::select('*');

        if(isset($datos['filtro_codigo'])){
            $data->where('codigo', $datos['filtro_codigo']);
        }

        if(isset($datos['filtro_nombre'])){
            $data->where('nombre', 'like', '%' . $datos['filtro_nombre'] . '%');
        }
        
        $data= $data->paginate(10)->appends(request()->all());

        return view('Administrador.Gestion_Municipios.index', compact('data'));
    }

    public function ver_municipios(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();
        
        $municipio = Municipio::find($data['idMunicipio']);
        
        return view('Administrador.Gestion_Municipios.modal_editar', compact('municipio'));
    }

    public function editar_municipios(Request $request)
    {
        acceso_a(1);
        $data = $request->all();

        $validator = Validator::make($data, [
            'codigo' => 'required|numeric',
            'nombre' => 'required|regex:/^[A-Za-z ]+$/|min:3',
        ]);

        $municipio = Municipio::find($data['id']);

        if ($validator->fails()) {
            Session::flash('message', $validator->errors()->first());
            Session::flash('class', 'alert alert-danger');
            return redirect()->back();
        }

        if (isset($municipio)) {
            $municipio->codigo = $data['codigo'];
            $municipio->nombre = $data['nombre'];
            if($municipio->save()){
                Session::flash('message', 'Municipio actualizado correctamente');
                Session::flash('class', 'alert alert-success');
            }else{
                Session::flash('message', 'No se pudo actualizar el municipio');
                Session::flash('class', 'alert alert-danger');
            }            
        }else{
            Session::flash('message', 'No se encontro el municipio');
            Session::flash('class', 'alert alert-danger');
        }

        return redirect()->back();
    }


    // Gestion de USUARIOS

    public function gestion_usuarios(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();
        $tipo_documentos = TipoDocumento::all();
        $municipios = Municipio::all()->sortBy('nombre');

        $usuarios = User::select('*');

        if(isset($data['filtro_tipo'])){
            $usuarios->where('tipos_documentos_id', $data['filtro_tipo']);
        }

        if(isset($data['filtro_documento'])){
            $usuarios->where('documento', $data['filtro_documento']);
        }

        if(isset($data['filtro_municipio']) && $data['filtro_municipio'] != "null"){
            $usuarios->where('municipios_id', $data['filtro_municipio']);
        }

        if(isset($data['filtro_estado'])){
            $usuarios->where('estado', $data['filtro_estado']);
        }else{
            $usuarios->where('estado', 1);
        }

        $usuarios= $usuarios->paginate(10)->appends(request()->all());

        return view('Administrador.Gestion_Usuarios.index', compact('usuarios', 'tipo_documentos', 'municipios'));
    }

    public function ver_usuarios(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();
        $usuario = User::find($data['idUsuario']);

        //$disabled = true - Editar usuario
        //$disabled = false - Ver usuario
        $disabled = true;
        if ($data['tipo'] == 1) {
            $disabled = false;
            return view('Administrador.Gestion_Usuarios.modal_usuario', compact('usuario', 'disabled'));
        }

        $tipo_documentos = TipoDocumento::all();
        $municipios = Municipio::all()->sortBy('nombre');
        
        return view('Administrador.Gestion_Usuarios.modal_usuario', compact('usuario', 'disabled', 'tipo_documentos', 'municipios'));
    }

    public function crear_usuarios(Request $request)
    {
        acceso_a(1,2);
        if ($request->isMethod('POST')) {
            acceso_a(1);
            $data = $request->all();
    
            $validator = Validator::make($data, [
                "tipo_documento" => "required|numeric",
                "documento" => "required|numeric",
                "nombres" => "required|string",
                "apellidos" => "required|string",
                "email" => "required|string",
                "telefono" => "required|numeric",
                "municipio" => "required|numeric",
                "cargo" => "required|string"
            ]);
    
            if ($validator->fails()) {
                return ($validator->errors()->all());
            }
            $user = [];

            $usuario_existe = User::where('tipos_documentos_id', $data['tipo_documento'])->where('documento', $data['documento'])->exists();
            
            if ((!$usuario_existe)) {
                try{
                    DB::beginTransaction();
                    User::create([
                        "tipos_documentos_id" => $data['tipo_documento'],
                        "documento" => $data['documento'],
                        "nombre" => $data['nombres'],
                        "apellido" => $data['apellidos'],
                        "email" => $data['email'],
                        "telefono" => $data['telefono'],
                        "municipios_id" => $data['municipio'],
                        "cargo" => $data['cargo']
                    ]);        
                        DB::commit();
                        return json_encode(["type"=> "success", "message"=>"El usuario se creo correctamente"]);       
                }catch(Exception $ex){
                    DB::rollback();
                    return json_encode(["type"=> "error", "message"=>"El usuario no pudo ser creado"]);
                }   
            }else{
                return json_encode(["type"=> "error", "message"=>"El usuario ya existe"]);
            }

        }

        //Si el metodo de la peticion es GET
        $tipo_documentos = TipoDocumento::all();
        $municipios = Municipio::all()->sortBy('nombre');

        return view('Administrador.Gestion_Usuarios.modal_crear_usuario', compact('tipo_documentos', 'municipios'));
    }

    public function editar_usuario(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();

        $validator = Validator::make($data, [
            "tipo_documento" => "required|numeric",
            "documento" => "required|numeric",
            "nombres" => "required|string",
            "apellidos" => "required|string",
            "email" => "required|string",
            "telefono" => "required|numeric",
            "municipio" => "required|numeric",
            "cargo" => "required|string",
        ]);

        if ($validator->fails()) {
            return ($validator->errors()->all());
        }

        try{
            DB::beginTransaction();
            $user = User::where('id', $data['id'])->update([
                "tipos_documentos_id" => $data['tipo_documento'],
                "documento" => $data['documento'],
                "nombre" => $data['nombres'],
                "apellido" => $data['apellidos'],
                "email" => $data['email'],
                "telefono" => $data['telefono'],
                "municipios_id" => $data['municipio'],
                "cargo" => $data['cargo']
            ]);

            if ($user > 0) {
                DB::commit();
                return json_encode(["type"=> "success", "message"=>"Usuario actualizado correctamente"]);
            }
            return json_encode(["type"=> "error", "message"=>"El usuario no pudo ser actualizado"]);

        }catch(Exception $ex){
            DB::rollback();
            return json_encode(["type"=> "error", "message"=>"El usuario no pudo ser actualizado"]);
        }        
    }

    public function eliminar_usuario(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();

        $delete = User::where('id', $data['idUsuario'])->update([
            "estado" => 0
        ]);
        if ($delete > 0) {
            return "Usuario eliminado correctamente";
        }

        return ["error"=>"No se pudo eliminar el usuario"];
    }

    public function carga_masiva(Request $request)
    {
        acceso_a(1,2);

        if ($request->isMethod('GET')) {
            return view('Administrador.Gestion_Usuarios.modal_crear_usuario_masivo');
        }

        $file = $request->file('file');

        if ($file) {
            // verificar si el archivo tiene la extension correcta
            $nombre = $file->getClientOriginalName();
            $ext = pathinfo($nombre, PATHINFO_EXTENSION);
            if ($ext != 'xlsx') {
                return redirect()->back()->with('msg', 'FORMATO NO PERMITIDO');
            }
            
            // cargar el archivo xlsx con la extension phpspreadhsheet y luego convertirlo en un array
            $sSheet = IOFactory::load($file);
            $reporte = $sSheet->getActiveSheet()->ToArray();

            // Eliminar los encabezados
            unset($reporte[0]);
            unset($reporte[1]);
            
            // cambiar el tiempo de ejecucion
            ini_set('max_execution_time', 0); // sin limites

            // crear array con tipos de documento
            $tipos_doc = TipoDocumento::all()->pluck('codigo', 'id')->toArray();

            
            // recorrer el archivo
            foreach ($reporte as $index => $usuarios) {
                if(count($usuarios) < 8){
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, formato no válido');
                    continue;
                }

                $all_null = 0;

                // quitar espacios de cada celda al mismo tiempo que se revisa si hay alguna vacia, en caso de haber una vacia, incrementar $all_null en +1
                for ($busca_key = 0; $busca_key  < 8; $busca_key++) {
                    $usuarios[$busca_key] = trim($usuarios[$busca_key]);
                    if($usuarios[$busca_key] == null || $usuarios[$busca_key] == ""){
                        // si el campo en blanco no es el telefono.
                        if($busca_key !== 5){
                            $all_null++;
                        }
                    }
                }

                // si $all_null es igual a 7, todas las celdas de la fila estan vacias, saltar fila (se ignora el campo telefono)
                if($all_null == 7){
                    continue;
                }
                
                // si $all_null es mayor a 0, alguna celda esta vacia, saltar fila
                if($all_null > 0){
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Algún campo se encuentra vacio');
                    continue;
                }

                // tipo documento
                if (!in_array(strtoupper($usuarios[0]), $tipos_doc)) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, El tipo de documento no es valido');
                    continue;

                }else{
                    $usuarios[0] = array_search(strtoupper($usuarios[0]), $tipos_doc);
                }

                // documento
                if (strlen($usuarios[1]) > 20) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Documento no válido MAX 20 caracteres');
                    continue;
                }

                // documento es numero (?)
                if (!is_numeric($usuarios[1])) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Documento debe ser un número');
                    continue;
                }

                // documento es decimal (?)
                if($this->is_decimal($usuarios[1])){
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Documento debe ser un número entero');
                    continue;
                }

                // Nombre
                if (strlen($usuarios[2]) > 50) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Nombre no válido MAX 50 caracteres');
                    continue;
                }

                // Apellido
                if (strlen($usuarios[3]) > 50) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Apellido no válido MAX 50 caracteres');
                    continue;
                }

                // Email
                if (strlen($usuarios[4]) > 50) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Email no válido MAX 50 caracteres');
                    continue;
                }

                // Email es correo valido (?)
                if (!filter_var(trim($usuarios[4]), FILTER_VALIDATE_EMAIL)) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, La dirección de correo no es valida');
                    continue;
                }

                $correo_existe = User::where('email', trim($usuarios[4]))->exists();
                if($correo_existe){
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, La dirección de correo ya se encuentra registrada en el sistema');
                    continue;
                }                

                // Teléfono
                if (strlen($usuarios[5]) > 12) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Teléfono no válido MAX 12 caracteres');
                    continue;
                }

                // telefono es numero (?)
                if (!is_numeric($usuarios[5])) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Teléfono debe ser un número');
                    continue;
                }

                // telefono es decimal (?)
                if($this->is_decimal($usuarios[5])){
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Teléfono debe ser un número sin espacios ni caracteres especiales');
                    continue;
                }

                // Apellido
                if (strlen($usuarios[6]) > 50) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Cargo no válido MAX 50 caracteres');
                    continue;
                }

                //municipio es numero (?) y es valido
                $municipio_array = explode(" - ",$usuarios[7]);
                $municipio_array[0] = trim($municipio_array[0]);
                if(!is_numeric($municipio_array[0])){
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Municipio no válido; por favor use el formato número-municipio, ej: 7-Cali');
                    continue;
                }

                // municipio es decimal (?)
                if($this->is_decimal($municipio_array[0])){
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Municipio no válido; por favor use el formato número-municipio, ej: 7-Cali');
                    continue;
                }

                // Usuario existe (?)
                $usuario_existe = User::where('tipos_documentos_id', $usuarios[0])->where('documento', $usuarios[1])->exists();
                if ($usuario_existe) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, El usuario ya existe');
                    continue;
                }

                // Municipio existe (?)
                $municipio_existe = Municipio::where('id', $municipio_array[0])->first();
                if ($municipio_existe === null) {
                    $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, Municipio no encontrado');
                    continue;
                }

                // Guardar en base de datos
                if ((!$usuario_existe) && $municipio_existe !== null) {
                    $usuario_creado = true;

                    // se intenta crear un usuario nuevo
                    // usamos una transaction para asegurar la integridad de los datos
                    DB::beginTransaction();
                    try {                       
                        User::create([
                            "tipos_documentos_id" => $usuarios[0],
                            "documento" => $usuarios[1],
                            "nombre" => $usuarios[2],
                            "apellido" => $usuarios[3],
                            "email" => $usuarios[4],
                            "telefono" => $usuarios[5],
                            "cargo" => $usuarios[6],
                            "municipios_id" => $municipio_array[0]
                        ]);

                        DB::commit();
                    } catch (\Exception $e) {

                        DB::rollback();
                        $usuario_creado = false;
                    } catch (\Throwable $e) {

                        DB::rollback();
                        $usuario_creado = false;
                    }

                    if($usuario_creado){
                        $sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'CREADO CORRECTAMENTE');
                    }else{
						$sSheet->getActiveSheet()->setCellValueByColumnAndRow(9, $index + 1, 'Error, el usuario no pudo ser creado');
                        continue;
                    }
                }
            }

            $fecha = date('Y_m_d');
            $file = $fecha . "_Resultado_Carga_Masiva_Usuarios.xlsx";
            $writer = IOFactory::createWriter($sSheet, 'Xlsx');
            header('Content-Type: application/application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            $writer->save("php://output");
        } else {
            Session::flash('message', "POR FAVOR CARGUE UN FORMATO");
            Session::flash('class', 'alert alert-danger');
            return redirect()->back();
        }
    }


    // Gestion de FUNCIONARIOS

    public function gestion_funcionarios(Request $request)
    {
        acceso_a(1,2);

        $request->flash();
        
        $data = $request->all();
        $tipo_documentos = TipoDocumento::all();
        $roles = Rol::all();
        $centros = Centro::all()->sortBy('nombre');
        $funcionarios = Funcionario::select('*');

        if(isset($data['filtro_tipo'])){
            $funcionarios->where('tipos_documentos_id', $data['filtro_tipo']);
        }

        if(isset($data['filtro_documento'])){
            $funcionarios->where('documento', $data['filtro_documento']);
        }
        
        if(isset($data['filtro_nombre'])){
            $funcionarios->where(DB::raw("CONCAT('nombre',' ','apellido')"), "like", '%'.$data['filtro_nombre']."%");
        }

        if(isset($data['filtro_estado'])){
            $funcionarios->where('estado', $data['filtro_estado']);
        }else{
            $funcionarios->where('estado', 1);
        }

        if (!tiene_rol(1)) {
            $funcionarios = $funcionarios->where('centros_id', Auth::user()->centros_id );
        }else{
            if(isset($data['filtro_centro'])){
                $funcionarios->where('centros_id', $data['filtro_centro']);
            }
        }

        if(isset($data['filtro_rol'])){
            $funcionarios->where('roles_id', $data['filtro_rol']);
        }

        $funcionarios = $funcionarios->paginate(10)->appends(request()->all());

        return view('Administrador.Gestion_Funcionarios.index', compact('funcionarios', 'tipo_documentos', 'roles', 'centros'));
    }

    public function buscar_funcionarios(Request $request)
    {
        acceso_a(1,2);
        $request->flash();
        $data = $request->all();
        $funcionarios = Funcionario::select('*');

        if(isset($data['filtro_tipo'])){
            $funcionarios->where('tipos_documentos_id', $data['filtro_tipo']);
        }

        if(isset($data['filtro_documento'])){
            $funcionarios->where('documento', $data['filtro_documento']);
        }
        
        if(isset($data['filtro_nombre'])){
            $funcionarios->where(DB::raw("CONCAT('nombre',' ','apellido')"), "like", '%'.$data['filtro_nombre']."%");
        }

        if (!tiene_rol(1)) {
            $funcionarios = $funcionarios->where('centros_id', Auth::user()->centros_id );
        }else{
            if(isset($data['filtro_centro'])){
                $funcionarios->where('centros_id', $data['filtro_centro']);
            }
        }

        if(isset($data['filtro_rol'])){
            $funcionarios->where('roles_id', $data['filtro_rol']);
        }

        $funcionarios = $funcionarios->paginate(10)->appends(request()->all());

        return view('Administrador.Gestion_Funcionarios.tabla', compact('funcionarios'));
    }

    public function ver_funcionarios(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();
        $funcionario = Funcionario::find($data['idFuncionario']);

        //$disabled = true - Editar funcionario
        //$disabled = false - Ver funcionario
        $disabled = true;
        if ($data['tipo'] == 1) {
            $disabled = false;
            return view('Administrador.Gestion_Funcionarios.modal_funcionario', compact('funcionario', 'disabled'));
        }

        $tipo_documentos = TipoDocumento::all();
        $roles = Rol::all();
        if (!tiene_rol(1)) {
            $roles = $roles ->whereNotIn('id', 1);
        }
        $centros = Centro::all()->sortBy('nombre');
        
        return view('Administrador.Gestion_Funcionarios.modal_funcionario', compact('funcionario', 'disabled', 'tipo_documentos', 'roles', 'centros'));
    }

    public function crear_funcionarios(Request $request)
    {
        acceso_a(1,2);
        if ($request->isMethod('POST')) {
            $data = $request->all();
    
            $validator = Validator::make($data, [
                "tipo_documento" => "required|numeric",
                "documento" => "required|numeric",
                "nombres" => "required|string",
                "apellidos" => "required|string",
                "email" => "required|string",
                "rol" => "required|numeric",
            ]);
    
            if ($validator->fails()) {
                return ($validator->errors()->all());
            }

            if ( tiene_rol(1) ) {
                if ( !isset($data['centro']) || $data['centro'] == "null") {
                    return json_encode(["type"=> "error", "message"=>"El campo CENTRO es obligatorio."]);
                }
            }

            $funcionario_existe = Funcionario::where('tipos_documentos_id', $data['tipo_documento'])->where('documento', $data['documento'])->exists();
            
            if ((!$funcionario_existe)) {
                try{
                    DB::beginTransaction();

                    $result = DB::table('funcionarios')->insert([
                        "tipos_documentos_id" => $data['tipo_documento'],
                        "documento" => $data['documento'],
                        "nombre" => $data['nombres'],
                        "apellido" => $data['apellidos'],
                        "email" => $data['email'],
                        "telefono" => $data['telefono'],
                        "password" => Hash::make($data['documento']),
                        "centros_id" => isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id,
                        "roles_id" => $data['rol']
                    ]);      
                        DB::commit();
                        return json_encode(["type"=> "success", "message"=>"El funcionario se creo correctamente"]);       
                }catch(Exception $ex){
                    DB::rollback();
                    return json_encode(["type"=> "error", "message"=>"El funcionario no pudo ser creado"]);
                }   
            }else{
                return json_encode(["type"=> "error", "message"=>"El funcionario ya existe"]);
            }
        }

        //Si el metodo de la peticion es GET
        $tipo_documentos = TipoDocumento::all();
        $roles = Rol::all();
        if (!tiene_rol(1)) {
            $roles = $roles ->whereNotIn('id', 1);
        }
        $centros = Centro::all()->sortBy('nombre');

        return view('Administrador.Gestion_Funcionarios.modal_crear_funcionario', compact('tipo_documentos', 'roles', 'centros'));
    }

    public function editar_funcionario(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();

        $validator = Validator::make($data, [
            "tipo_documento" => "required|numeric",
            "documento" => "required|numeric",
            "nombres" => "required|string",
            "apellidos" => "required|string",
            "email" => "required|string",
            "rol" => "required|string",
            "estado" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return ($validator->errors()->all());
        }

        if ( tiene_rol(1) ) {
            if ( !isset($data['centro']) || $data['centro'] == "null") {
                return json_encode(["type"=> "error", "message"=>"El campo CENTRO es obligatorio."]);
            }
        }

        try{
            DB::beginTransaction();
            $user = Funcionario::where('id', $data['id'])->update([
                "tipos_documentos_id" => $data['tipo_documento'],
                "documento" => $data['documento'],
                "nombre" => $data['nombres'],
                "apellido" => $data['apellidos'],
                "email" => $data['email'],
                "telefono" => $data['telefono'],
                "estado" => $data['estado'],
                "centros_id" => isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id,
                "roles_id" => $data['rol']
            ]);

            if ($user > 0) {
                DB::commit();
                return json_encode(["type"=> "success", "message"=>"El funcionario se actualizo correctamente"]);  
            }
            return json_encode(["type"=> "error", "message"=>"El funcionario no pudo ser actualizado"]);  

        }catch(Exception $ex){
            dd($ex);
            DB::rollback();
            return json_encode(["type"=> "error", "message"=>"El funcionario no pudo ser actualizado"]);  
        }        
    }

    public function eliminar_funcionario(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();

        $delete = Funcionario::where('id', $data['idFuncionario'])->update([
            "estado" => 0
        ]);
        if ($delete > 0) {
            return "Funcionario eliminado correctamente";
        }

        return ["error"=>"No se pudo eliminar el funcionario"];
    }


    // Gestion de SERVICIOS

    public function gestion_servicios()
    {
        acceso_a(1,2);
        return view('Administrador.Gestion_Servicios.index');
    }


    // Gestion de OFERTAS

    public function gestion_ofertas(Request $request)
    {
        acceso_a(1,2);

        $request->flash();
        $data = $request->all();

        $programas = Programa::all();
        $municipios = Municipio::all();
        $centros = Centro::all();
        $trimestres = Trimestre::all();
        // $competencias = Competencia_Laboral::all();

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

        if (tiene_rol(1)) {
            if(isset($data['filtro_centro']) && $data['filtro_centro'] != "null"){
                $ofertas_programas->where('programas_centros.centros_id', $data['filtro_centro']);
            }
        }else{
            $ofertas_programas->where('programas_centros.centros_id', Auth::user()->centros_id );
        }        

        if(isset($data['filtro_municipio']) && $data['filtro_municipio'] != "null"){
            $ofertas_programas->where('ofertas_programas.municipios_id', $data['filtro_municipio']);
        }

        if(isset($data['filtro_trimestre']) && $data['filtro_trimestre'] != "null"){
            $ofertas_programas->where('ofertas_programas.trimestreS_ID', $data['filtro_trimestre']);
        }

        $ofertas_programas = $ofertas_programas->paginate(10)->appends(request()->all());
        
        $ofertas_competencias = Oferta_Competencia_Laboral::select('*'); 

        // if (!tiene_rol(1)) {
        //     $ofertas_competencias->where('competencias_laborales_centros_id', Auth::user()->centros_id );
        // }
        // $ofertas_competencias= $ofertas_competencias->paginate(10)->appends(request()->all());

        return view('Administrador.Gestion_Ofertas.programas.index', compact('programas', /*'competencias',*/ 'municipios',  'centros', 'trimestres', 'ofertas_programas'/*, 'ofertas_competencias'*/));
    }

    public function buscar_ofertas(Request $request)
    {
        acceso_a(1,2);

        $data = $request->all();

        $ofertas_programas = Oferta_Programa::select('ofertas_programas.*')
        ->join('programas_centros', 'ofertas_programas.programas_centros_id','programas_centros.id')
        ->join('programas', 'programas_centros.programas_id','programas.id')->where('estado', 1);

        if(isset($data['filtro_programa']) && $data['filtro_programa'] != "null"){
            $ofertas_programas->where('programas.id', $data['filtro_programa']);
        }

        if(isset($data['filtro_nivel_formacion']) && $data['filtro_nivel_formacion'] != "null"){
            $ofertas_programas->where('programas.nivel_formacion', $data['filtro_nivel_formacion']);
        }

        if (tiene_rol(1)) {
            if(isset($data['filtro_centro']) && $data['filtro_centro'] != "null"){
                $ofertas_programas->where('programas_centros.centros_id', $data['filtro_centro']);
            }
        }else{
            $ofertas_programas->where('programas_centros.centros_id', Auth::user()->centros_id );
        }        

        if(isset($data['filtro_municipio']) && $data['filtro_municipio'] != "null"){
            $ofertas_programas->where('ofertas_programas.municipios_id', $data['filtro_municipio']);
        }

        if(isset($data['filtro_trimestre']) && $data['filtro_trimestre'] != "null"){
            $ofertas_programas->where('ofertas_programas.trimestreS_ID', $data['filtro_trimestre']);
        }

        $ofertas_programas = $ofertas_programas->paginate(10)->appends(request()->all());
        
        return view('Administrador.Gestion_Ofertas.programas.tabla', compact('ofertas_programas'));
    }

    public function ver_ofertas(Request $request)
    {
        acceso_a(1,2,3);
        $data = $request->all();

        $oferta_programa = Oferta_Programa::find($data['idOfertaPrograma']);

        // dd($data['editar']);

        // $editar = true;
        $editar = $data['editar'] == 1;
        // if ($data['editar'] == 1) {
            // dd("editar");
            $municipios = Municipio::all();
            $programas = Programa::all();
            $trimestres = Trimestre::all()->where('estado', 1);        

            if (tiene_rol(1)) {
                $centros = Centro::all();
                return view('Administrador.Gestion_Ofertas.programas.modal_oferta_programa', compact('oferta_programa','municipios', 'programas', 'trimestres', 'centros', 'editar'));
            }

            $programas->whereIn('id', Programa_Centro::where('centros_id', Auth::user()->centros_id)->get()->pluck('programas_id'));

            return view('Administrador.Gestion_Ofertas.programas.modal_oferta_programa', compact('oferta_programa','municipios', 'programas', 'trimestres', 'editar'));
        // }else{
        //     $editar = false;
        //     return view('Administrador.Gestion_Ofertas.programas.modal_oferta_programa', compact('oferta_programa', 'editar'));
        // }
    }

    public function crear_ofertas(Request $request)
    {
        acceso_a(1,2);
        if ($request->isMethod('POST')) {
            $data = $request->all();

            $validator = Validator::make($data, [
                "trimestre" => "required|numeric",
                "modalidad" => "required|string",
                "mes_inicio" => "required|string",
                "anho_fin" => "required|string",
                "cursos" => "required|numeric",
                "cupos" => "required|numeric",
                "vigencia" => "required|numeric",
                "programa" => "required|numeric",                
                "programa_especial" => "required|string",
                "tipo_oferta" => "required|string",
            ]);

            if ($validator->fails()) {
                return ($validator->errors()->all());
            }

            
            if ( tiene_rol(1) ) {
                if ( !isset($data['centro']) || $data['centro'] == "null") {
                    return json_encode(["type"=> "error", "message"=>"El campo CENTRO es obligatorio."]);
                }
            }

            if ($data['modalidad'] != "VIRTUAL" && !isset($data['municipio'])) {
                return json_encode(["type"=> "error", "message"=>"El campo MUNICIPIO es obligatorio."]);
            }
            
            $programa_centro = Programa_Centro::where('programas_id', $data['programa'])
                ->where('centros_id', isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id);
            
            if ($programa_centro->exists()) {
                try{
                    DB::beginTransaction();
                        $new_oferta = new Oferta_Programa;
                        $new_oferta->trimestres_id = $data['trimestre'];
                        $new_oferta->modalidad = $data['modalidad'];
                        $new_oferta->mes_inicio = $data['mes_inicio'];
                        $new_oferta->anho_fin = $data['anho_fin'];
                        $new_oferta->nro_grupos = $data['cursos'];
                        $new_oferta->cupos = $data['cupos'];
                        $new_oferta->tipo_oferta = $data['tipo_oferta']; 
                        $new_oferta->vigencia = $data['vigencia']; 
                        $new_oferta->programa_especial = $data['programa_especial'];
                        $new_oferta->municipios_id = isset($data['municipio']) ? $data['municipio'] : null;
                        $new_oferta->servicios_id = 3;
                        $new_oferta->programas_centros_id = $programa_centro->first()->id;
                        $new_oferta->funcionarios_id = Auth::user()->id;

                        if ($new_oferta->save()) {
                            DB::commit();
                            return json_encode(["type"=> "success", "message"=>"La oferta del programa se ha creado correctamente."]);                         
                        }   
                        DB::rollBack();    
                        return json_encode(["type"=> "error", "message"=>"La oferta del programa no ha podido ser creada."]);

                }catch(Exception $ex){
                    DB::rollback();
                    return json_encode(["type"=> "error", "message"=>$ex]);
                    return json_encode(["type"=> "error", "message"=>"La oferta del programa no ha podido ser creada."]);
                }   
            }else{
                try {
                    DB::beginTransaction();
                    $new_programa_centro = new Programa_Centro;

                    $new_programa_centro->programas_id = $data['programa'];
                    $new_programa_centro->centros_id = isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id;

                    if($new_programa_centro->save()){ 
                        $new_oferta = new Oferta_Programa;
                        $new_oferta->trimestres_id = $data['trimestre'];
                        $new_oferta->modalidad = $data['modalidad'];
                        $new_oferta->mes_inicio = $data['mes_inicio'];
                        $new_oferta->anho_fin = $data['anho_fin'];
                        $new_oferta->nro_grupos = $data['cursos'];
                        $new_oferta->cupos = $data['cupos'];
                        $new_oferta->tipo_oferta = $data['tipo_oferta']; 
                        $new_oferta->vigencia = $data['vigencia']; 
                        $new_oferta->programa_especial = $data['programa_especial'];
                        $new_oferta->municipios_id = isset($data['municipio']) ? $data['municipio'] : null;
                        $new_oferta->servicios_id = 3;
                        $new_oferta->programas_centros_id = $new_programa_centro->id;
                        $new_oferta->funcionarios_id = Auth::user()->id;

                        if ($new_oferta->save()) {
                            DB::commit();
                            return json_encode(["type"=> "success", "message"=>"La oferta del programa se ha creado correctamente."]);                         
                        }   
                        DB::rollBack();    
                        return json_encode(["type"=> "error", "message"=>"La oferta del programa no ha podido ser creada."]);
                    }else{
                        DB::rollBack();    
                        return json_encode(["type"=> "error", "message"=>"No se ha podido asociar el PROGRAMA al CENTRO."]);
                    }
                    
                } catch (\Throwable $th) {
                    DB::rollBack();    
                    return json_encode(["type"=> "error", "message"=>$th]);
                    return json_encode(["type"=> "error", "message"=>"La OFERTA DEL PROGRAMA no ha podido ser creada."]);
                }
            }
        }

        $municipios = Municipio::all();
        $programas = Programa::all();
        $trimestres = Trimestre::all()->where('estado', 1);        

        if (tiene_rol(1)) {
            $centros = Centro::all();
            return view('Administrador.Gestion_Ofertas.programas.modal_crear_oferta', compact('municipios', 'programas', 'trimestres', 'centros'));
        }

        $programas->whereIn('id', Programa_Centro::where('centros_id', Auth::user()->centros_id)->get()->pluck('programas_id'));

        //Si el metodo de la peticion es GET
        return view('Administrador.Gestion_Ofertas.programas.modal_crear_oferta', compact('municipios', 'programas', 'trimestres'));
    }

    public function carga_masiva_oferta_programas(Request $request)
    {
        if ($request->isMethod('GET')) {
            return view('Administrador.Gestion_Ofertas.programas.modal_crear_oferta_programa_masivo');
        }

        $file = $request->file('file');

        if ($file) {
            // verificar si el archivo tiene la extension correcta
            $nombre = $file->getClientOriginalName();
            $ext = pathinfo($nombre, PATHINFO_EXTENSION);
            if ($ext != 'xlsx') {
                Session::flash('message', "FORMATO NO PERMITIDO");
                Session::flash('class', 'alert alert-danger');
                return redirect()->back();
            }
            
            // Cargar el archivo xlsx con la extension phpspreadhsheet y luego convertirlo en un array
            $sSheet = IOFactory::load($file);
            $reporte = $sSheet->getActiveSheet()->ToArray();

            //Elimina el encabezado
            unset($reporte[0]);

            $ofertas_programas = $this->etlCargaOferta($reporte);
            $tmp = [];

            foreach ($ofertas_programas as $key => $oferta_programa) {
                $municipio_oferta_programa = Municipio::where('nombre', $oferta_programa[14]);

                if (!$municipio_oferta_programa->exists() && $oferta_programa[7] != "VIRTUAL") {
                    $tmp[$key] = [...$oferta_programa,"type"=> "error", "message"=>"El municipio " . $oferta_programa[14] . " no se encuentra registrado en el aplicativo."];
                    continue;
                }

                $oferta_programa_existe = Oferta_Programa::select('*')
                    ->join('programas_centros', 'ofertas_programas.programas_centros_id','programas_centros.id')
                    ->join('programas', 'programas_centros.programas_id','programas.id')
                    ->join('centros', 'programas_centros.centros_id','centros.id')
                    ->join('trimestres', 'ofertas_programas.trimestres_id','trimestres.id')
                    ->where('centros.codigo', $oferta_programa[0])
                    ->where('trimestres.vigencia', $oferta_programa[2])
                    ->where('trimestres.numero', $oferta_programa[3])
                    ->where('programas.codigo', $oferta_programa[4])                    
                    ->where('ofertas_programas.mes_inicio', $oferta_programa[11]);

                if ($oferta_programa[7] != "VIRTUAL") {
                    $oferta_programa_existe = $oferta_programa_existe->where('ofertas_programas.municipios_id', Municipio::where('nombre', $oferta_programa[14])->first()->id);
                }

                $oferta_programa_existe = $oferta_programa_existe->exists();

                if (!$oferta_programa_existe) {
                    $tmp[$key] = $this->crearOfertaPrograma($oferta_programa);
                }else{
                    $tmp[$key] = [...$oferta_programa,"type"=> "error", "message"=>"La oferta del programa ya existe."];
                }                
            }

            $this-> carga_masiva_ofertas_programas($tmp);
            dd($tmp);
        }else {
            Session::flash('message', "POR FAVOR CARGUE UN FORMATO");
            Session::flash('class', 'alert alert-danger');
            return redirect()->back();
        }
    }

    public function editar_ofertas(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();

        $validator = Validator::make($data, [
            "trimestre" => "required|numeric",
            "modalidad" => "required|string",
            "mes_inicio" => "required|string",
            "anho_fin" => "required|string",
            "cursos" => "required|numeric",
            "cupos" => "required|numeric",
            "vigencia" => "required|numeric",
            "programa" => "required|numeric",                
            "programa_especial" => "required|string",
            "tipo_oferta" => "required|string",
        ]);

        if ($validator->fails()) {
            return ($validator->errors()->all());
        }

        if ( tiene_rol(1) ) {
            if ( !isset($data['centro']) || $data['centro'] == "null") {
                return json_encode(["type"=> "error", "message"=>"El campo CENTRO es obligatorio."]);
            }
        }

        if (($data['modalidad'] != "VIRTUAL") && (!isset($data["municipio"]))) {
            return json_encode(["type"=> "error", "message"=>"El campo MUNICIPIO es obligatorio."]);
        }
        
        $oferta_programa = Oferta_Programa::find($data['id']);
        
        if ($oferta_programa) {
            if (!tiene_rol(1) && $oferta_programa->programas_centro->centros_id != Auth::user()->centros_id) {
                return json_encode(["type"=> "error", "message"=>"El usuario no pertenece al CENTRO."]);
            }

            $programa_centro = Programa_Centro::where('programas_id', $data['programa'])
                ->where('centros_id', isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id);

            if ($programa_centro->exists()) {
                try {
                    DB::beginTransaction();
                    $oferta_programa->trimestres_id = $data['trimestre'];
                    $oferta_programa->modalidad = $data['modalidad'];
                    $oferta_programa->mes_inicio = $data['mes_inicio'];
                    $oferta_programa->anho_fin = $data['anho_fin'];
                    $oferta_programa->nro_grupos = $data['cursos'];
                    $oferta_programa->cupos = $data['cupos'];
                    $oferta_programa->tipo_oferta = $data['tipo_oferta']; 
                    $oferta_programa->vigencia = $data['vigencia']; 
                    $oferta_programa->programa_especial = $data['programa_especial'];
                    $oferta_programa->municipios_id = isset($data['municipio']) ? $data['municipio'] : null;
                    $oferta_programa->programas_centros_id = $programa_centro->first()->id;
                    $oferta_programa->funcionarios_updated_id = Auth::user()->id;
    
                    if($oferta_programa->save()){
                        DB::commit();
                        return json_encode(["type"=> "success", "message"=>"La OFERTA DEL PROGRAMA se actualizo correctamente."]);
                    }else{
                        DB::rollBack();
                        return json_encode(["type"=> "error", "message"=>"Error al actualizar la OFERTA DEL PROGRAMA."]);
                    }
                    
                } catch (\Throwable $ex) {
                    DB::rollBack();
                    return json_encode(["type"=> "error", $ex]);
                    return json_encode(["type"=> "error", "message"=>"Error al actualizar la OFERTA DEL PROGRAMA."]);
                }
            }else{
                try {
                    DB::beginTransaction();
                    $new_programa_centro = new Programa_Centro;

                    $new_programa_centro->programas_id = $data['programa'];
                    $new_programa_centro->centros_id = isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id;

                    if($new_programa_centro->save()){
                        $oferta_programa->trimestres_id = $data['trimestre'];
                        $oferta_programa->modalidad = $data['modalidad'];
                        $oferta_programa->mes_inicio = $data['mes_inicio'];
                        $oferta_programa->anho_fin = $data['anho_fin'];
                        $oferta_programa->nro_grupos = $data['cursos'];
                        $oferta_programa->cupos = $data['cupos'];
                        $oferta_programa->tipo_oferta = $data['tipo_oferta']; 
                        $oferta_programa->vigencia = $data['vigencia']; 
                        $oferta_programa->programa_especial = $data['programa_especial'];
                        $oferta_programa->municipios_id = isset($data['municipio']) ? $data['municipio'] : null;
                        $oferta_programa->programas_centros_id = $programa_centro->first()->id;
                        $oferta_programa->funcionarios_updated_id = Auth::user()->id;
        
                        if($oferta_programa->save()){
                            DB::commit();
                            return json_encode(["type"=> "success", "message"=>"La OFERTA DEL PROGRAMA se actualizo correctamente."]);
                        }else{
                            DB::rollBack();
                            return json_encode(["type"=> "error", "message"=>"Error al actualizar la OFERTA DEL PROGRAMA."]);
                        }
                    }else{
                        DB::rollBack();    
                        return json_encode(["type"=> "error", "message"=>"No se ha podido asociar el PROGRAMA al CENTRO."]);
                    }
                } catch (\Throwable $th) {
                    DB::rollBack();    
                    return json_encode(["type"=> "error", "message"=>"La OFERTA DEL PROGRAMA no ha podido ser creada."]);
                }
            }
            
        }else{
            return json_encode(["type"=> "error", "message"=>"No se encontró la OFERTA DEL PROGRAMA."]);
        }    
    }


    // ofertas competencias laborales
    public function buscar_ofertas_competencia(Request $request)
    {
        acceso_a(1,2);

        $data = $request->all();

        $ofertas_competencias = Oferta_Competencia_Laboral::select('*')
        ->join('competencias_laborales_centros', 'ofertas_competencias.competencias_laborales_centros_id','competencias_laborales_centros.id')
        ->join('competencias_laborales', 'competencias_laborales_centros.competencias_id','competencias_laborales.id');

        if(isset($data['filtro_nombre']) && $data['filtro_nombre'] != "null"){
            $ofertas_competencias->where('competencias_laborales.nombre', 'like' , "%".$data['filtro_nombre']."%");
        }

        if(isset($data['filtro_codigo_nscl']) && $data['filtro_codigo_nscl'] != "null"){
            $ofertas_competencias->where('competencias_laborales.codigo_nscl', $data['filtro_codigo_nscl']);
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

        $ofertas_competencias = $ofertas_competencias->paginate(10)->appends(request()->all());
        
        return view('Administrador.Gestion_Ofertas.competencia_laboral.tabla_competencia', compact('ofertas_competencias'));
    }

    public function crear_ofertas_competencia(Request $request)
    {
        acceso_a(1,2);
        if ($request->isMethod('POST')) {
            $data = $request->all();

            $validator = Validator::make($data, [
                "trimestre" => "required|numeric",
                "duracion" => "required|numeric",
                "fecha_inicio" => "required|string",
                "fecha_fin" => "required|string",
                "cupos" => "required|numeric",
                "municipio" => "required|numeric",            
                "competencia" => "required|numeric"                
            ]);

            if ($validator->fails()) {
                return ($validator->errors()->all());
            }

            if ( tiene_rol(1) ) {
                if ( !isset($data['centro']) || $data['centro'] == "null") {
                    return json_encode(["type"=> "error", "message"=>"El campo CENTRO es obligatorio."]);
                }
            }

            $competencia_laboral_centro = Competencia_Laboral_Centro::where('competencias_id', $data['competencia'])
                ->where('centros_id', isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id);
            
            if ($competencia_laboral_centro->exists()) {
                try{
                    DB::beginTransaction();
                        Oferta_Competencia_Laboral::create([
                            "trimestres_id" =>  $data['trimestre'],
                            "duracion" =>  $data['duracion'],
                            "fecha_inicio" =>  $data['fecha_inicio'],
                            "fecha_fin" =>  $data['fecha_fin'],
                            "cupos" =>  $data['cupos'],
                            "municipios_id" => $data['municipio'],
                            "servicios_id" => 4,
                            "competencias_laborales_centros_id" => $competencia_laboral_centro->first()->id
                        ]);
            
                        DB::commit();
                        return json_encode(["type"=> "success", "message"=>"La oferta de programa se creo correctamente."]);       
                }catch(Exception $ex){
                    DB::rollback();
                    return json_encode(["type"=> "error", "message"=>"La oferta de programa no pudo ser creada."]);
                }   
            }else{
                // return json_encode(["type"=> "error", "message"=>"El CENTRO no cuenta con la CERTIFICACIÓN LABORAL asociada."]);
                try {
                    DB::beginTransaction();
                    $new_competencia_centro = new Competencia_Laboral_Centro;

                    $new_competencia_centro->competencias_id = $data['competencia'];
                    $new_competencia_centro->centros_id = isset($data['centro']) ? $data['centro'] : Auth::user()->centros_id;

                    if($new_competencia_centro->save()){
                        $new_oferta = new Oferta_Competencia_Laboral;
                        $new_oferta->trimestres_id = $data['trimestre'];
                        $new_oferta->duracion = $data['duracion'];
                        $new_oferta->fecha_inicio = $data['fecha_inicio'];
                        $new_oferta->fecha_fin = $data['fecha_fin'];
                        $new_oferta->cupos = $data['cupos'];
                        $new_oferta->municipios_id = $data['municipio'];
                        $new_oferta->servicios_id = 4;
                        $new_oferta->competencias_laborales_centros_id = $new_competencia_centro->id;

                        if ($new_oferta->save()) {
                            DB::commit();
                            return json_encode(["type"=> "success", "message"=>"La oferta de la certificación laboral se creo correctamente."]);                         
                        }   
                        DB::rollBack();    
                        return json_encode(["type"=> "error", "message"=>"No se pudo crear la oferta de la certificación laboral."]);
                    }else{
                        DB::rollBack();    
                        return json_encode(["type"=> "error", "message"=>"No se pudo crear la oferta de la certificación laboral."]);
                    }
                    
                } catch (\Throwable $th) {
                    DB::rollBack();    
                    return json_encode(["type"=> "error", "message"=>$th]);
                    return json_encode(["type"=> "error", "message"=>"No se pudo asociar la CERTIFICACIÓN LABORAL al CENTRO."]);
                }
            }
        }

        //Si el metodo de la peticion es GET
        $municipios = Municipio::all();
        $competencias = Competencia_Laboral::all();
        $trimestres = Trimestre::all()->where('estado', 1);        

        if (tiene_rol(1)) {
            $centros = Centro::all();
            return view('Administrador.Gestion_Ofertas.competencia_laboral.modal_crear_oferta_competencias', compact('municipios', 'competencias', 'trimestres', 'centros'));
        }
        $competencias = Competencia_Laboral_Centro::where('centros_id', Auth::user()->centros_id);

        return view('Administrador.Gestion_Ofertas.competencia_laboral.modal_crear_oferta_competencias', compact('municipios', 'competencias', 'trimestres'));
    }


    // Gestion de PROGRAMAS

    public function gestion_programas(Request $request)
    {
        acceso_a(1,2);
        $data = $request->all();

        $programas = Programa::select('*');

        if(isset($data['filtro_codigo'])){
            $programas->where('codigo', $data['filtro_codigo']);
        }

        if(isset($data['filtro_nombre'])){
            $programas->where('nombre','like', '%'.$data['filtro_nombre'].'%');
        }

        if(isset($data['filtro_acronimo'])){
            $programas->where('acronimo','like', '%'.$data['filtro_acronimo'].'%');
        }

        if(isset($data['filtro_nivel_formacion']) && $data['filtro_nivel_formacion'] != "null"){
            $programas->where('nivel_formacion', $data['filtro_nivel_formacion']);
        }

        $programas = $programas->paginate(10)->appends(request()->all());
        return view('Administrador.Gestion_Programas.index', compact('programas'));
    }

    public function buscar_programas(Request $request)
    {
        acceso_a(1,2);

        $data = $request->all();

        $programas = Programa::select('*');

        if(isset($data['filtro_codigo'])){
            $programas->where('codigo', $data['filtro_codigo']);
        }

        if(isset($data['filtro_nombre'])){
            $programas->where('nombre','like', '%'.$data['filtro_nombre'].'%');
        }

        if(isset($data['filtro_acronimo'])){
            $programas->where('acronimo','like', '%'.$data['filtro_acronimo'].'%');
        }

        if(isset($data['filtro_nivel_formacion']) && $data['filtro_nivel_formacion'] != "null"){
            $programas->where('nivel_formacion', $data['filtro_nivel_formacion']);
        }

        $programas = $programas->paginate(10)->appends(request()->all());

        return view('Administrador.Gestion_Programas.tabla', compact('programas'));
    }

    public function crear_programas(Request $request)
    {
        acceso_a(1);
        if ($request->isMethod('POST')) {
            $data = $request->all();
    
            $validator = Validator::make($data, [
                "acronimo" => "required|string",
                "codigo" => "required|numeric",
                "nombre" => "required|string",
                "version" => "required|numeric",
                "nivel_formacion" => "required|string"
            ]);
    
            if ($validator->fails()) {
                return ($validator->errors()->all());
            }

            $programa_existe = Programa::where('codigo', $data['codigo'])
                ->where('acronimo', $data['acronimo'])
                ->where('version',$data['version'])->exists();
            
            if ((!$programa_existe)) {
                try{
                    DB::beginTransaction();
                        Programa::create($data);                    
                        DB::commit();
                        return json_encode(["type"=> "success", "message"=>"El programa se creo correctamente"]);       
                }catch(Exception $ex){
                    DB::rollback();
                    return json_encode(["type"=> "error", "message"=>"El programa no pudo ser creado"]);
                }   
            }else{
                return json_encode(["type"=> "error", "message"=>"El programa ya existe"]);
            }
        }

        //Si el metodo de la peticion es GET
        return view('Administrador.Gestion_Programas.modal_crear_programa');
    }

    public function ver_programa(Request $request)
    {
        acceso_a(1);
        $data = $request->all();
        $programa = Programa::find($data['idPrograma']);
        
        return view('Administrador.Gestion_Programas.modal_editar_programa', compact('programa'));
    }

    public function editar_programa(Request $request)
    {
        acceso_a(1);
        $data = $request->all();

        $validator = Validator::make($data, [
            "acronimo" => "required|string",
            "codigo" => "required|numeric",
            "nombre" => "required|string",
            "version" => "required|numeric",
            "nivel_formacion" => "required|string",
            "estado" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return ($validator->errors()->all());
        }

        try{
            DB::beginTransaction();
            $programa = Programa::where('id', $data['id'])->update([
                "acronimo" => $data['acronimo'],
                "codigo" => $data['codigo'],
                "nombre" => $data['nombre'],
                "version" => $data['version'],
                "nivel_formacion" => $data['nivel_formacion'],
                "estado" => $data['estado']
            ]);

            if ($programa > 0) {
                DB::commit();
                return json_encode(["type"=> "success", "message"=>"Programa actualizado correctamente"]); 
            }
            return json_encode(["type"=> "error", "message"=>"El programa no pudo ser actualizado"]);

        }catch(Exception $ex){
            DB::rollback();
            return json_encode(["type"=> "error", "message"=>"El programa no pudo ser actualizado"]);
        }  
    }


    public function carga_masiva_ofertas_programas($ofertas)
    {
        $documento = new Spreadsheet();
        $pathTemplate = getcwd() .'/plantillas/Resultado_carga_masiva_ofertas.xlsx';
        $documento = IOFactory::load($pathTemplate);
        $hoja = $documento->getActiveSheet();
        $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];


        for ($i=3; $i <sizeof($ofertas) ; $i++) { 
            $hoja->setCellValue("A{$i}", $ofertas[$i][0]);
            $hoja->setCellValue("B{$i}", $ofertas[$i][1]);
            $hoja->setCellValue("C{$i}", $ofertas[$i][2]);
            $hoja->setCellValue("D{$i}", $ofertas[$i][3]);
            $hoja->setCellValue("E{$i}", $ofertas[$i][4]);
            $hoja->setCellValue("F{$i}", $ofertas[$i][5]);
            $hoja->setCellValue("G{$i}", $ofertas[$i][6]);
            $hoja->setCellValue("H{$i}", $ofertas[$i][7]);

            $hoja->setCellValue("I{$i}", $ofertas[$i][10]);
            $hoja->setCellValue("J{$i}", $ofertas[$i][14]);
            
            $hoja->setCellValue("K{$i}", $ofertas[$i][8]);

            $hoja->setCellValue("L{$i}", $meses[$ofertas[$i][9]]);
            $hoja->setCellValue("M{$i}", $ofertas[$i][11]);
            $hoja->setCellValue("N{$i}", $ofertas[$i][12]);
            $hoja->setCellValue("O{$i}", $ofertas[$i][13]);

            $hoja->setCellValue("P{$i}", $ofertas[$i]["message"]);
            if ($ofertas[$i]["type"] == 'success') {
                $hoja->getStyle("P{$i}")
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
            }else{
                $hoja->getStyle("P{$i}")
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
            }
        }

        $writer = new Xlsx($documento);
        $nombreDelDocumento = "Resultado carga masiva oferta de programas.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    /**
     * Devuelve campos necesarios a partir del reporte de Indicativa
     * @param array $reporte arreglo de datos de reporte de indicativa
     * @return Array
     */
    public function etlCargaOferta($reportes)
    {
        $ofertas = [];
        // Columnas que no se necesitan del reporte de Indicativa.
        $tmp = [8,10,15,16,17,19,20,21];
        $ofertastmp = [];
        
        // Recorre $reportes (todas las ofertas)
        foreach ($reportes as $key => $reporte) {
            // Recorre 1 oferta
            foreach ($reporte as $key => $value) {
                if (in_array($key, $tmp)) {
                    unset($reporte[$key]);
                } 
            }
            $reporte[19] = 1;     
            array_push($ofertastmp, $reporte);
        }        

        $ofertastmp = $this-> groupBy($ofertastmp);

        foreach ($ofertastmp as $vigencias) {
            foreach ($vigencias as $trimestres) {
                foreach ($trimestres as $mes_inicio) {
                    foreach ($mes_inicio as $municipio) {
                        foreach ($municipio as $nivel_formacion) {
                            foreach ($nivel_formacion as $modalidades) {
                                foreach ($modalidades as $centros) {
                                    $ofertas = [...$ofertas, ...$centros];
                                }
                            }
                        }
                    }
                }
            }
        }        
        return $ofertas;
    }

    /**
     * Crea una oferta de programas en el aplicativo
     * @param array $oferta_programa Datos para creación de la oferta
     * @return array Resultado de la creación de la oferta
     */
    public function crearOfertaPrograma($oferta_programa)
    {
        $centro_existe = Centro::where('codigo', $oferta_programa[0])->exists();

        if ($centro_existe) {
            $programa_existe = Programa::where('codigo', $oferta_programa[4])->exists();
            if ($programa_existe) {
                $programa_centro = Programa_Centro::where('programas_id', $oferta_programa[4])
                ->where('centros_id',$oferta_programa[0]);
            
                if ($programa_centro->exists()) {
                    try{
                        DB::beginTransaction();
                            $trimestre_oferta_programa = Trimestre::where('numero', $oferta_programa[3])->where('vigencia',$oferta_programa[2]);

                            if (!$trimestre_oferta_programa->exists()) {
                                return [...$oferta_programa,"type"=> "error", "message"=>"El trimestre no se encuentra registrado en el aplicativo."];
                            }

                            if (($oferta_programa[14] == "" || $oferta_programa[14] == null) && $oferta_programa[7] != "VIRTUAL") {
                                return [...$oferta_programa,"type"=> "error", "message"=>"Debes indicar un municipio para la oferta."];
                            }

                            $municipio_oferta_programa = Municipio::where('nombre', $oferta_programa[14]);

                            if (!$municipio_oferta_programa->exists() && $oferta_programa[7] != "VIRTUAL") {

                                return [...$oferta_programa,"type"=> "error", "message"=>"El municipio no se encuentra registrado en el aplicativo."];
                            }

                            $new_oferta_programa = new Oferta_Programa;

                            $new_oferta_programa->mes_inicio = $oferta_programa[11];
                            $new_oferta_programa->vigencia = $oferta_programa[2];
                            $new_oferta_programa->anho_fin = $oferta_programa[13];
                            $new_oferta_programa->nro_grupos = $oferta_programa[19];
                            $new_oferta_programa->cupos = $oferta_programa[12];
                            $new_oferta_programa->programa_especial = $oferta_programa[9];
                            $new_oferta_programa->tipo_oferta = $oferta_programa[18];
                            $new_oferta_programa->modalidad = $oferta_programa[7];
                            $new_oferta_programa->trimestres_id = Trimestre::where('numero', $oferta_programa[3])->where('vigencia',$oferta_programa[2])->first()->id;
                            $new_oferta_programa->programas_centros_id = $programa_centro->first()->id;
                            if ($oferta_programa[7] != "VIRTUAL") {
                                $new_oferta_programa->municipios_id = Municipio::where('nombre', $oferta_programa[14])->first()->id;   
                            }
                            $new_oferta_programa->servicios_id = 3;
                            $new_oferta_programa->funcionarios_id = Auth::user()->id;
                            
                            if ($new_oferta_programa->save()) {
                                DB::commit();
                                return [...$oferta_programa,"type"=> "success", "message"=>"La oferta de programa se creo correctamente."];
                            }else{
                                DB::rollBack();    
                                return [...$oferta_programa,"type"=> "error", "message"=>"La oferta de programa no pudo ser creada."];
                            }                                     
                    }catch(Exception $ex){
                        DB::rollback();
                        return [...$oferta_programa,"type"=> "error", "message"=>"La oferta de programa no pudo ser creada."];
                    }   
                }else{
                    try {
                        DB::beginTransaction();
                        $new_programa_centro = new Programa_Centro;

                        $new_programa_centro->programas_id = Programa::where('codigo', $oferta_programa[4])->first()->id;
                        $new_programa_centro->centros_id = Centro::where('codigo',$oferta_programa[0])->first()->id;

                        if($new_programa_centro->save()){

                            $trimestre_oferta_programa = Trimestre::where('numero', $oferta_programa[3])->where('vigencia',$oferta_programa[2]);

                            if (!$trimestre_oferta_programa->exists()) {
                                return [...$oferta_programa,"type"=> "error", "message"=>"El trimestre no se encuentra registrado en el aplicativo."];
                            }

                            if (($oferta_programa[14] == "" || $oferta_programa[14] == null) && $oferta_programa[7] != "VIRTUAL") {
                                return [...$oferta_programa,"type"=> "error", "message"=>"Debes indicar un municipio para la oferta."];
                            }

                            $municipio_oferta_programa = Municipio::where('nombre', $oferta_programa[14]);

                            if (!$municipio_oferta_programa->exists() && $oferta_programa[7] != "VIRTUAL") {
                                return [...$oferta_programa,"type"=> "error", "message"=>"El municipio no se encuentra registrado en el aplicativo."];
                            }

                            $new_oferta_programa = new Oferta_Programa;

                            $new_oferta_programa->mes_inicio = $oferta_programa[11];
                            $new_oferta_programa->vigencia = $oferta_programa[2];
                            $new_oferta_programa->anho_fin = $oferta_programa[13];
                            $new_oferta_programa->nro_grupos = $oferta_programa[19];
                            $new_oferta_programa->cupos = $oferta_programa[12];
                            $new_oferta_programa->programa_especial = $oferta_programa[9];
                            $new_oferta_programa->tipo_oferta = $oferta_programa[18];
                            $new_oferta_programa->modalidad = $oferta_programa[7];
                            $new_oferta_programa->trimestres_id = Trimestre::where('numero', $oferta_programa[3])->where('vigencia',$oferta_programa[2])->first()->id;
                            $new_oferta_programa->programas_centros_id = $new_programa_centro->id;
                            if ($oferta_programa[7] != "VIRTUAL") {
                                $new_oferta_programa->municipios_id = Municipio::where('nombre', $oferta_programa[14])->first()->id;
                            }
                            $new_oferta_programa->servicios_id = 3;
                            $new_oferta_programa->funcionarios_id = Auth::user()->id;
                            
                            if ($new_oferta_programa->save()) {
                                DB::commit();
                                return [...$oferta_programa,"type"=> "success", "message"=>"La oferta de programa se creo correctamente."];
                            }else{
                                DB::rollBack();    
                                return [...$oferta_programa,"type"=> "error", "message"=>"La oferta de programa no pudo ser creada."];
                            }                        
                        }else{
                            DB::rollBack();    
                            return [...$oferta_programa,"type"=> "error", "message"=>"La oferta de programa no pudo ser creada."];
                        }
                        
                    } catch (\Throwable $th) {
                        DB::rollBack();    
                        return [...$oferta_programa,"type"=> "error", "message"=>"No se pudo asociar el PROGRAMA al CENTRO."];
                    }
                }                
            }
            return [...$oferta_programa,"type"=> "error", "message"=>"El PROGRAMA no se encuentra registrado."];
        }        
        return [...$oferta_programa,"type"=> "error", "message"=>"El CENTRO no se encuentra registrado."];
    }


    /**
     * Ordena y agrupa las ofertas de programas
     * @param Array $array arreglo de ofertas de programas
     * @return Array $newArray ofertas de programas ordenadas
     */
    public function groupBy($array)
    {
        $newArray = [];
        foreach ($array as $item) {
            if (isset($newArray[$item[2]][$item[3]][$item[11]][$item[14]][$item[6]][$item[7]][$item[0]][$item[4]])) {
                $newArray[$item[2]][$item[3]][$item[11]][$item[14]][$item[6]][$item[7]][$item[0]][$item[4]][12] += $item[12];

                $newArray[$item[2]][$item[3]][$item[11]][$item[14]][$item[6]][$item[7]][$item[0]][$item[4]][19] += 1;
            }else{
                $newArray[$item[2]][$item[3]][$item[11]][$item[14]][$item[6]][$item[7]][$item[0]][$item[4]] = $item;
            }
        }
        return $newArray;
    }

    public function is_decimal( $val )
    {
        return is_numeric( $val ) && floor( $val ) != $val;
    }
}
