<?php

namespace App\Http\Controllers;

use App\Municipio;
use App\Oferta_Competencia_Laboral;
use App\Oferta_Programa;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function reporte_usuarios()
    {
        $municipios = Municipio::all();
        return view('Reportes.reporte_usuarios', compact('municipios'));
    }

    public function reporte_usuarios_municipio(Request $request)
    {
        $data = $request->all();

        $municipio = Municipio::where('nombre', $data['municipio'])->first();
        
        if (!isset($municipio)) {
            return json_encode(["type"=> "error", "message"=>"No se encontró el municipio"]);
        }

        $usuarios = $municipio->usuarios;

        return json_encode(["type"=> "success", "users"=>$usuarios]);
       
    }

    public function descargar_reporte_usuarios_municipio(Request $request)
    {
        $request->flash();
        $data = $request->all();
        $users = [];
        
        if ($data['filtro_municipio'] == "null") {
            $municipios = Municipio::all();
            foreach ($municipios as $municipio) {
                foreach ($municipio->usuarios as $value) {
                    $users[] = $value;                    
                }
            }
        }else{
            $municipio = Municipio::where('nombre', str_replace('_',' ', $data['filtro_municipio']))->first();
            foreach ($municipio->usuarios as $value) {
                $users[] = $value;
            }
        }

        $pathTemplate = getcwd() .'/plantillas/Plantilla reporte de usuarios.xlsx';
        $documento = IOFactory::load($pathTemplate);
        $hoja = $documento->getActiveSheet();

        $index = 3;

        foreach ($users as $key => $user) {
            $hoja->setCellValue('A' . $index, $user->tipo_documento->descripcion);
            $hoja->setCellValue('B' . $index, $user->documento);
            $hoja->setCellValue('C' . $index, $user->nombre);
            $hoja->setCellValue('D' . $index, $user->apellido);
            $hoja->setCellValue('E' . $index, $user->email);
            $hoja->setCellValue('F' . $index, $user->telefono);
            $hoja->setCellValue('G' . $index, $user->cargo);
            $hoja->setCellValue('H' . $index, $user->municipios->nombre);

            $index++;
        }

        $writer = new Xlsx($documento);
        $nombreDelDocumento = "Reporte usuarios.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function reporte_ofertas()
    {
        $municipios = Municipio::all();
        return view('Reportes.reporte_ofertas', compact('municipios'));
    }

    public function reporte_ofertas_municipio(Request $request)
    {
        $data = $request->all();

        $municipio = Municipio::where('nombre', $data['municipio'])->first();
        
        if (!isset($municipio)) {
            return json_encode(["type"=> "error", "message"=>"No se encontró el municipio"]);
        }

        $data_ofertas_programas = Oferta_Programa::where('municipios_id', $municipio->id)->orderBy('id', 'desc')->get();
        $ofertas_programas = [];
        foreach ($data_ofertas_programas as $key => $data_oferta_programa) {
            $ofertas_programas[] = [
                "centro"=> $data_oferta_programa->programas_centro->centro->nombre, 
                "programa"=> $data_oferta_programa->programas_centro->programa->nombre, 
                "cupos"=> $data_oferta_programa->cupos
            ];
        }

        $data_ofertas_competencias = Oferta_Competencia_Laboral::where('municipios_id', $municipio->id)->orderBy('id', 'desc')->get();
        $ofertas_competencias = [];
        foreach ($data_ofertas_competencias as $key => $data_oferta_competencia) {
            $ofertas_competencias[] = [
                "centro"=> $data_oferta_competencia->competencias_centro->centro->nombre, 
                "competencia"=> $data_oferta_competencia->competencias_centro->competencia_laboral->nombre, 
                "cupos"=> $data_oferta_competencia->cupos
            ];
        }
        
        return json_encode(["type"=> "success", "ofertas_programas"=>$ofertas_programas, "ofertas_competencias"=>$ofertas_competencias]);
       
    }

    public function descargar_reporte_ofertas_municipio(Request $request)
    {
        $request->flash();
        $data = $request->all();
        $ofertas_programas = [];
        $ofertas_competencias = [];

        if ($data['filtro_municipio'] == "null") {
            $ofertas_programas = Oferta_Programa::select('ofertas_programas.*')
            ->join('programas_centros', 'ofertas_programas.programas_centros_id','programas_centros.id')->get();


            $ofertas_competencias = Oferta_Competencia_Laboral::select('ofertas_competencias.*')
            ->join('competencias_laborales_centros', 'ofertas_competencias.competencias_laborales_centros_id','competencias_laborales_centros.id')->get();
        }else{
            $municipio = Municipio::where('nombre', str_replace('_',' ', $data['filtro_municipio']))->first();
            $ofertas_programas = Oferta_Programa::select('ofertas_programas.*')
            ->join('programas_centros', 'ofertas_programas.programas_centros_id','programas_centros.id')
            ->where('municipios_id', $municipio->id)->get();


            $ofertas_competencias = Oferta_Competencia_Laboral::select('ofertas_competencias.*')
            ->join('competencias_laborales_centros', 'ofertas_competencias.competencias_laborales_centros_id','competencias_laborales_centros.id')
            ->where('municipios_id', $municipio->id)->get();
        }

        $pathTemplate = getcwd() .'/plantillas/Plantilla reporte de ofertas.xlsx';
        $documento = IOFactory::load($pathTemplate);
        $hoja_programas = $documento->getSheet(0);
        $hoja_competencias = $documento->getSheet(1);

        $index = 3;
        
        foreach ($ofertas_programas as $key => $oferta_programa) {
            $hoja_programas->setCellValue('A' . $index, $oferta_programa->programas_centro->centro->codigo);
            $hoja_programas->setCellValue('B' . $index, $oferta_programa->programas_centro->centro->nombre);
            $hoja_programas->setCellValue('C' . $index, $oferta_programa->programas_centro->programa->codigo);
            $hoja_programas->setCellValue('D' . $index, $oferta_programa->programas_centro->programa->nombre);
            $hoja_programas->setCellValue('E' . $index, $oferta_programa->programas_centro->programa->acronimo);
            $hoja_programas->setCellValue('F' . $index, $oferta_programa->programas_centro->programa->nivel_formacion);
            $hoja_programas->setCellValue('G' . $index, $oferta_programa->programas_centro->programa->version);
            $hoja_programas->setCellValue('H' . $index, $oferta_programa->modalidad);
            $hoja_programas->setCellValue('I' . $index, $oferta_programa->tipo_oferta);
            $hoja_programas->setCellValue('J' . $index, $oferta_programa->programa_especial);
            $hoja_programas->setCellValue('K' . $index, isset($oferta_programa->municipio->nombre) ? $oferta_programa->municipio->nombre : "---");
            $hoja_programas->setCellValue('L' . $index, $oferta_programa->nro_grupos);
            $hoja_programas->setCellValue('M' . $index, $oferta_programa->cupos);
            $hoja_programas->setCellValue('N' . $index, convertir_mes($oferta_programa->mes_inicio));
            $hoja_programas->setCellValue('O' . $index, $oferta_programa->vigencia);
            $hoja_programas->setCellValue('P' . $index, $oferta_programa->trimestre->numero."-".$oferta_programa->trimestre->vigencia . " ( " . $oferta_programa->trimestre->fecha_inicio ." / " . $oferta_programa->trimestre->fecha_fin . " )" );
            $hoja_programas->setCellValue('Q' . $index, $oferta_programa->anho_fin);
            $hoja_programas->setCellValue('R' . $index, $oferta_programa->estado == 1 ? 'DISPONIBLE' : 'ASIGNADA');

            $index++;
        }

        $index = 3;
        
        foreach ($ofertas_competencias as $key => $oferta_competencia) {
            $hoja_competencias->setCellValue('A' . $index, $oferta_competencia->competencias_centro->centro->codigo);
            $hoja_competencias->setCellValue('B' . $index, $oferta_competencia->competencias_centro->centro->nombre);
            $hoja_competencias->setCellValue('C' . $index, $oferta_competencia->competencias_centro->competencia_laboral->codigo_nscl);
            $hoja_competencias->setCellValue('D' . $index, $oferta_competencia->competencias_centro->competencia_laboral->nombre);
            $hoja_competencias->setCellValue('E' . $index, $oferta_competencia->competencias_centro->competencia_laboral->mesa_sectorial);
            $hoja_competencias->setCellValue('F' . $index, $oferta_competencia->competencias_centro->competencia_laboral->version_nscl);
            $hoja_competencias->setCellValue('G' . $index, $oferta_competencia->municipio->nombre);
            $hoja_competencias->setCellValue('H' . $index, $oferta_competencia->fecha_inicio);
            $hoja_competencias->setCellValue('I' . $index, $oferta_competencia->fecha_fin);
            $hoja_competencias->setCellValue('J' . $index, $oferta_competencia->trimestre->numero."-".$oferta_competencia->trimestre->vigencia . " ( " . $oferta_competencia->trimestre->fecha_inicio ." / " . $oferta_competencia->trimestre->fecha_fin . " )" );
            $hoja_competencias->setCellValue('K' . $index, $oferta_competencia->duracion . " MESES");
            $hoja_competencias->setCellValue('L' . $index, $oferta_competencia->cupos);
            $hoja_competencias->setCellValue('M' . $index, $oferta_competencia->estado == 1 ? 'DISPONIBLE' : 'ASIGNADA');

            $index++;
        }

        $writer = new Xlsx($documento);
        $nombreDelDocumento = "";
        if ($data['filtro_municipio'] == "null") {
            $nombreDelDocumento = "Reporte oferta REGIONAL VALLE.xlsx";
        }else{
            $nombreDelDocumento = "Reporte oferta ". $data['filtro_municipio'] .".xlsx";
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
