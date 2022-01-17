<!-- Modal -->
<div id="modal_ver_solicitud" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">
            @if(isset($solicitud))
            <div class="modal-body text-center">
                <h1 class="font-weight-bolder" >INFORMACIÓN DE SOLICITUD</h1>
                <hr style="font-size: 30px; font-weight:bolder;">
                <div class="my-4">
                    <p class="m-0">
                        <span style="font-weight: bold;">Identificador: </span>
                        {{$solicitud->id}}
                    </p>
                    <p class="m-0">
                        <span style="font-weight: bold;">Titulo Solicitud: </span>
                        {{$solicitud->titulo}}
                    </p>
                    <p class="m-0">
                        <span style="font-weight: bold;">Descripción Solicitud: </span>
                        {{$solicitud->descripcion}}
                    </p>
                    <p class="m-0">
                        <span style="font-weight: bold;">Cupos Requeridos: </span>
                        {{$solicitud->cupos}}
                    </p>
                    <p class="m-0">
                        <span style="font-weight: bold;">Fecha de Solicitud: </span>
                        {{$solicitud->fecha_solicitud}}
                    </p>
                    @if(isset($solicitud->fecha_aprobacion))
                    <p class="m-0">
                        <span style="font-weight: bold;">Fecha de Aprobación: </span>
                        {{$solicitud->fecha_solicitud}}
                    </p>
                    @endif
                    <p class="m-0">
                        <span style="font-weight: bold;">Estado Solicitud: </span>
                        {{$solicitud->estado == 1 ? 'PENDIENTE' : 'APROBADO'}}
                    </p>
                </div>

                @if(isset($solicitud->ofertas_programas_id) || isset($solicitud->programas_id))
                    <div class="my-4" >
                        <p class="m-0">
                            <span style="font-weight: bold;">Código de Programa: </span>
                            {{$solicitud->programa->codigo}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Nombre de Programa: </span>
                            {{$solicitud->programa->nombre}}
                        </p>
                        <p class="m-0">
                            <span style="font-weight: bold;">Acrónimo: </span>
                            {{$solicitud->programa->acronimo}}
                        </p>                   
                        <p class="m-0">
                            <span style="font-weight: bold;">Nivel de Programa: </span>
                            {{$solicitud->programa->nivel_formacion}}
                        </p>                   
                        <p class="m-0">
                            <span style="font-weight: bold;">Versión de Programa: </span>
                            {{$solicitud->programa->version}}
                        </p>                   
                    </div>
                @endif

                <div class="my-4" >
                    <p class="m-0">
                        <span style="font-weight: bold;">Registrada por: </span>
                        {{$solicitud->funcionario_registra->nombre_completo()}}
                    </p>
                    @if($solicitud->estado == 2)
                        <p class="m-0">
                            <span style="font-weight: bold;">Aprobada por: </span>
                            {{$solicitud->funcionario_aprueba->nombre_completo()}}
                        </p>
                    @endif
                    <p class="m-0">
                        <span style="font-weight: bold;">Municipio Solicitante: </span>
                        {{$solicitud->usuario->municipios->nombre}}
                    </p>
                    <p class="m-0">
                        <span style="font-weight: bold;">Solicitada por: </span>
                        {{$solicitud->usuario->nombre_completo()}}
                    </p>
                    <p class="m-0">
                        <span style="font-weight: bold;">Cargo de Solicitante: </span>
                        {{$solicitud->usuario->cargo}}
                    </p>
                </div>
                
                @if($solicitud->estado == 2)
                <div class="mt-5 mb-2">
                    <h1 class="font-weight-bolder" >INFORMACIÓN DE LA OFERTA</h1>
                    <hr style="font-size: 30px; font-weight:bolder;">
                </div>
                    @if(isset($solicitud->ofertas_programas_id))
                        <div class="my-4" >
                            <p class="m-0">
                                <span style="font-weight: bold;">Código Centro Encargado: </span>
                                {{$solicitud->oferta_programa->programas_centro->centro->codigo}}
                            </p>
                            <p class="m-0">
                                <span style="font-weight: bold;">Nombre Centro Encargado: </span>
                                {{$solicitud->oferta_programa->programas_centro->centro->nombre}}
                            </p>
                        </div>
                        <div class="my-4" >
                            <p class="m-0">
                                <span style="font-weight: bold;">Vigencia: </span>
                                {{$solicitud->oferta_programa->vigencia}}
                            </p>
                            <p class="m-0">
                                <span style="font-weight: bold;">Trimestre: </span>
                                {{$solicitud->oferta_programa->trimestre->numero."-".$solicitud->oferta_programa->trimestre->vigencia . " ( " . $solicitud->oferta_programa->trimestre->fecha_inicio ." / " . $solicitud->oferta_programa->trimestre->fecha_fin . " )" }}
                            </p>
                        </div>                    

                        <div class="my-4" >
                            <p class="m-0">
                                <span style="font-weight: bold;">Modalidad: </span>
                                {{$solicitud->oferta_programa->modalidad}}
                            </p>
                            @if($solicitud->oferta_programa->modalidad != "VIRTUAL")
                                <p class="m-0">
                                    <span style="font-weight: bold;">Municipio de oferta: </span>
                                    {{$solicitud->oferta_programa->municipio->nombre}}
                                </p>
                            @endif
                            <p class="m-0">
                                <span style="font-weight: bold;">Nivel Formación: </span>
                                {{$solicitud->oferta_programa->tipo_oferta}}
                            </p>
                            <p class="m-0">
                                <span style="font-weight: bold;">Programa Especial: </span>
                                {{$solicitud->oferta_programa->programa_especial}}
                            </p>
                            <p class="m-0">
                                <span style="font-weight: bold;">Mes Inicio: </span>
                                {{convertir_mes($solicitud->oferta_programa->mes_inicio)}}
                            </p>                   
                            <p class="m-0">
                                <span style="font-weight: bold;">Número de Cursos: </span>
                                {{$solicitud->oferta_programa->nro_grupos}}
                            </p>                   
                            <p class="m-0">
                                <span style="font-weight: bold;">Cupos: </span>
                                {{$solicitud->oferta_programa->cupos}}
                            </p>                   
                            <p class="m-0">
                                <span style="font-weight: bold;">Año Termino: </span>
                                {{$solicitud->oferta_programa->anho_fin}}
                            </p>                               
                        </div>
                    
                    @else
                        @if(isset($solicitud->ofertas_competencias_id))
                            <div class="my-4" >
                                <p class="m-0">
                                    <span style="font-weight: bold;">Código Centro: </span>
                                    {{$solicitud->oferta_competencia->programas_centro->centro->codigo}}
                                </p>
                                <p class="m-0">
                                    <span style="font-weight: bold;">Nombre Centro: </span>
                                    {{$solicitud->oferta_competencia->programas_centro->centro->nombre}}
                                </p>
                            </div>
                        @else
                            <div class="my-4" >
                                <p class="m-0">
                                    <span style="font-weight: bold;">Tipo de Servicio: </span>
                                    {{$solicitud->servicio->nombre}}
                                </p>
                                <p class="m-0">
                                    <span style="font-weight: bold;">Nombre Centro: </span>
                                    {{$solicitud->oferta_competencia->programas_centro->centro->nombre}}
                                </p>
                            </div>
                        @endif

                    @endif
                    
                @endif
            </div>
            @else
            <div class="modal-body text-center">
                <div class="container">
                    <p>No se encontró la SOLICITUD</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>