<!-- Modal -->
<div id="modal_ver_oferta_programa" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body text-center">
                @if(isset($oferta_programa))
                    <h1 class="font-weight-bolder" >INFORMACIÓN DE INDICATIVA</h1>
                    <hr style="font-size: 30px; font-weight:bolder;">
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Código Centro: </span>
                            {{$oferta_programa->programas_centro->centro->codigo}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Nombre Centro: </span>
                            {{$oferta_programa->programas_centro->centro->nombre}}
                        </p>
                    </div>
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Vigencia: </span>
                            {{$oferta_programa->vigencia}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Trimestre: </span>
                            {{$oferta_programa->trimestre->numero."-".$oferta_programa->trimestre->vigencia . " ( " . $oferta_programa->trimestre->fecha_inicio ." / " . $oferta_programa->trimestre->fecha_fin . " )" }}
                        </p>
                    </div>
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Código de Programa: </span>
                            {{$oferta_programa->programas_centro->programa->codigo}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Nombre de Programa: </span>
                            {{$oferta_programa->programas_centro->programa->nombre}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Acrónimo: </span>
                            {{$oferta_programa->programas_centro->programa->acronimo}}
                        </p>                   
                        <p class="m-0">
                            <span style="font-weight: bold;">Nivel de Programa: </span>
                            {{$oferta_programa->programas_centro->programa->nivel_formacion}}
                        </p>                   
                        <p class="m-0">
                            <span style="font-weight: bold;">Versión de Programa: </span>
                            {{$oferta_programa->programas_centro->programa->version}}
                        </p>                   
                    </div>
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Modalidad: </span>
                            {{$oferta_programa->modalidad}}
                        </p>
                        @if($oferta_programa->modalidad != "VIRTUAL")
                            <p class="m-0">
                                <span style="font-weight: bold;">Municipio de oferta: </span>
                                {{$oferta_programa->municipio->nombre}}
                            </p>
                        @endif
                        <p class="m-0">
                            <span style="font-weight: bold;">Nivel Formación: </span>
                            {{$oferta_programa->tipo_oferta}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Programa Especial: </span>
                            {{$oferta_programa->programa_especial}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Mes Inicio: </span>
                            {{convertir_mes($oferta_programa->mes_inicio)}}
                        </p>                   
                        <p class="m-0">
                            <span style="font-weight: bold;">Número de Cursos: </span>
                            {{$oferta_programa->nro_grupos}}
                        </p>                   
                        <p class="m-0">
                            <span style="font-weight: bold;">Cupos: </span>
                            {{$oferta_programa->cupos}}
                        </p>                   
                        <p class="m-0">
                            <span style="font-weight: bold;">Año Termino: </span>
                            {{$oferta_programa->anho_fin}}
                        </p>                               
                    </div>
                @else
                <div class="container">
                    <p>No se encontró la OFERTA DEL PROGRAMA</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>