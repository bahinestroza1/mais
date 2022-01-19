<!-- Modal -->
<div id="modal_tomar_solicitud" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 60%!important;">
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

                @if(isset($solicitud->programas_id))
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
                
                
                @if($solicitud->servicios_id == 3 || $solicitud->servicios_id == 4)
                    <div class="my-4">
                        <hr style="font-size: 30px; font-weight:bolder;">
                        <h2 class="font-weight-bolder" >OFERTA(S) DEL CENTRO</h2>
                        <hr style="font-size: 30px; font-weight:bolder;">
                    </div>

                    <div class="d-flex flex-wrap">
                        
                        @foreach($ofertas_centros as $oferta_centro)
                            <div class="col-md-6 mb-4">
                                <div class="card card-primary card-outline h-100">
                                    <div class="card-body d-flex justify-content-center align-items-center">
                                        @if(isset($oferta_centro->programas_centros_id))
                                            <div>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Identificador de oferta: </span>
                                                    {{$oferta_centro->id}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Programa: </span>
                                                    {{$oferta_centro->programas_centro->programa->nombre}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Trimestre: </span>
                                                    {{$oferta_centro->trimestre->numero."-".$oferta_centro->trimestre->vigencia . " ( " . $oferta_centro->trimestre->fecha_inicio ." / " . $oferta_centro->trimestre->fecha_fin . " )" }}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Modalidad: </span>
                                                    {{$oferta_centro->modalidad}}
                                                </p>
                                                @if(isset($oferta_centro->municipio->nombre))
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Municipio: </span>
                                                    {{ $oferta_centro->municipio->nombre }}
                                                </p>
                                                @endif
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Número de cupos: </span>
                                                    {{$oferta_centro->cupos}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Número de cursos: </span>
                                                    {{$oferta_centro->nro_grupos}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Mes de inicio: </span>
                                                    {{ convertir_mes($oferta_centro->mes_inicio) }}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Vigencia: </span>
                                                    {{$oferta_centro->vigencia}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Año Fin: </span>
                                                    {{$oferta_centro->anho_fin}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Estado: </span>
                                                    {{$oferta_centro->estado == 1 ? 'PENDIENTE' : 'ASIGNADO'}}
                                                </p>
                                            </div>
                                        @endif

                                        @if(isset($oferta_centro->competencias_laborales_centros_id))
                                            <div>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Identificador de oferta: </span>
                                                    {{$oferta_centro->id}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Código NSCL: </span>
                                                    {{$oferta_centro->competencias_centro->competencia_laboral->codigo_nscl}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Competencia: </span>
                                                    {{$oferta_centro->competencias_centro->competencia_laboral->nombre}}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Trimestre: </span>
                                                    {{$oferta_centro->trimestre->numero."-".$oferta_centro->trimestre->vigencia . " ( " . $oferta_centro->trimestre->fecha_inicio ." / " . $oferta_centro->trimestre->fecha_fin . " )" }}
                                                </p>
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Mesa Sectorial: </span>
                                                    {{$oferta_centro->competencias_centro->competencia_laboral->mesa_sectorial}}
                                                </p>                       
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Version: </span>
                                                    {{$oferta_centro->competencias_centro->competencia_laboral->version_nscl}}
                                                </p>      
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Número de cupos: </span>
                                                    {{$oferta_centro->cupos}}
                                                </p>

                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Duración: </span>
                                                    {{$oferta_centro->duracion}} meses
                                                </p>
                                                
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Fecha de Inicio: </span>
                                                    {{$oferta_centro->fecha_inicio}}
                                                </p>
                                            
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Fecha de Finalización: </span>
                                                    {{$oferta_centro->fecha_fin}}
                                                </p>                                                
                                                <p class="m-0">
                                                    <span style="font-weight: bold;">Estado: </span>
                                                    {{$oferta_centro->estado == 1 ? 'PENDIENTE' : 'ASIGNADO'}}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <button 
                                            id="btn_asignar_solicitud_{{$solicitud->id}}" 
                                            class="btn btn-primary w-100"
                                            onclick="tomarSolicitud('{{$solicitud->id}}', '{{$oferta_centro->id}}', '{{$oferta_centro->servicios_id}}')"
                                            {{$oferta_centro->estado != 1 ? 'disabled' : '' }}
                                        >
                                        {{$oferta_centro->estado != 1 ? 'No Disponible' : 'Asignar' }} 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach                        
                    </div>
                </div>
                @else
                </div>
                    <div class="modal-footer justify-content-center">
                        <button 
                            id="btn_asignar_solicitud_{{$solicitud->id}}" 
                            class="btn btn-primary"
                            onclick="tomarSolicitud('{{$solicitud->id}}')"
                        >
                            Asignar a {{Auth::user()->centro->nombre}}
                        </button>
                    </div>
                @endif
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