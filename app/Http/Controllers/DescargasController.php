<?php

namespace App\Http\Controllers;

use App\TipoDocumento;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DescargasController extends Controller
{
    public function plantilla_carga_masiva_usuarios()
    {
        acceso_a(1);

        $tipos_doc = TipoDocumento::all()->sortBy('codigo');
        $documento = new Spreadsheet();
        $pathTemplate = getcwd() .'/plantillas/Formato_carga_masiva_usuarios.xlsx';
        $documento = IOFactory::load($pathTemplate);
        $hoja = $documento->getActiveSheet();

        // tipos de documento
        $cadena = "";
        foreach ($tipos_doc as $key => $tipo) {
            $cadena .= $tipo->codigo.",";
        }
        $cadena =substr($cadena, 0, -1);

        // Rellena 500 filas de la columna TIPO_DOCUMENTO de la plantilla 
        for ($i=3; $i < 500 ; $i++) { 
            $hoja = $documento->getActiveSheet()->getCell('A'.$i)
            ->getDataValidation();
            $hoja->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
            $hoja->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
            $hoja->setAllowBlank(false);
            $hoja->setShowInputMessage(true);
            $hoja->setShowErrorMessage(true);
            $hoja->setShowDropDown(true);
            $hoja->setErrorTitle('Input error');
            $hoja->setError('Este valor no esta en la lista .');
            $hoja->setPromptTitle('Pick from list');
            $hoja->setPrompt('Porfavor elija un valor de la lista desplegable .');
            $hoja->setFormula1("\"$cadena\"");
        }

        $writer = new Xlsx($documento);
        $nombreDelDocumento = "Plantilla carga masiva usuarios.xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
