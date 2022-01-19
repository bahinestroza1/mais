<!-- Modal -->
<div id="modal_ver_oferta_competencia" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body text-center">
                @if(isset($oferta_competencia))
                    <h1 class="font-weight-bolder" >INFORMACIÓN DE COMPETENCIA LABORAL</h1>
                    <hr style="font-size: 30px; font-weight:bolder;">
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Código Centro: </span>
                            {{$oferta_competencia->competencias_centro->centro->codigo}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Nombre Centro: </span>
                            {{$oferta_competencia->competencias_centro->centro->nombre}}
                        </p>
                    </div>
                    
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Código NSCL: </span>
                            {{$oferta_competencia->competencias_centro->competencia_laboral->codigo_nscl}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Nombre de Competencia: </span>
                            {{$oferta_competencia->competencias_centro->competencia_laboral->nombre}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Mesa Sectorial: </span>
                            {{$oferta_competencia->competencias_centro->competencia_laboral->mesa_sectorial}}
                        </p>                       
                        <p class="m-0">
                            <span style="font-weight: bold;">Version: </span>
                            {{$oferta_competencia->competencias_centro->competencia_laboral->version_nscl}}
                        </p>                   
                    </div>
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Fecha de Inicio: </span>
                            {{$oferta_competencia->fecha_inicio}}
                        </p>
                       
                        <p class="m-0">
                            <span style="font-weight: bold;">Fecha de Finalización: </span>
                            {{$oferta_competencia->fecha_fin}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Trimestre: </span>
                            {{$oferta_competencia->trimestre->numero."-".$oferta_competencia->trimestre->vigencia . " ( " . $oferta_competencia->trimestre->fecha_inicio ." / " . $oferta_competencia->trimestre->fecha_fin . " )" }}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Duración: </span>
                            {{$oferta_competencia->duracion}} meses
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Número de Cupos: </span>
                            {{$oferta_competencia->cupos}} cupos
                        </p>                                              
                    </div>
                @else
                <div class="container">
                    <p>No se encontró la OFERTA DE LA COMPETENCIA LABORAL</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>