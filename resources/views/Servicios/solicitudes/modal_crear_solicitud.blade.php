<!-- Modal -->
@if(isset($programas))
<div id="modal_crear_solicitud" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 40%!important;">
        <!-- Modal content-->
        <div class="modal-content">        
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Crear Solicitud SENA</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_crear_solicitud" onsubmit="crearSolicitud()" autocomplete="off">           
                <div class="modal-body">     
                        {{ csrf_field() }}
                        <div class="container">
                            <div id="pruebajeje"></div>
                            <div class="form-group col-md-12">
                                <label for="titulo_solicitud">Titulo de Solicitud: </label>
                                <input id="titulo_solicitud" name="titulo_solicitud" class="form-control" type="text" placeholder="Titulo">
                                <div id="validation_titulo_solicitud" class="invalid-feedback"></div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="descripcion_solicitud">Descripción de Solicitud: </label>
                                <textarea id="descripcion_solicitud" name="descripcion_solicitud" class="form-control" type="text" placeholder="Descripción"></textarea>
                                <div id="validation_descripcion_solicitud" class="invalid-feedback"></div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="tipo_solicitud">Tipo de Servicio de la Solicitud: </label>
                                <select id="tipo_solicitud" name="tipo_solicitud" class="form-control" onchange="onChangeCrearSolicitud(this); removeValidation(this)">   
                                    <option selected value="null" disabled>Seleccione...</option>                                        
                                    @foreach ($servicios as $servicio)
                                        <option value="{{$servicio->id}}">{{$servicio->nombre}}</option>
                                    @endforeach
                                </select>  
                                <div id="validation_tipo_solicitud" class="invalid-feedback"></div>
                            </div>

                            <div id="container_solicitud">
                                <div id="container_solicitud_3" style="display: none;" >
                                    <div class="form-group col-md-12">
                                        <label for="programa_solicitado">Programa Solicitado: </label>
                                        <select id="programa_solicitado" name="programa_solicitado" class="form-control" onchange="removeValidation(this)">
                                            <option selected value="null" disabled>Seleccione...</option>                                     
                                            @foreach ($programas as $programa)
                                                <option value="{{$programa->id}}">{{$programa->nombre}}</option>
                                            @endforeach
                                        </select>  
                                        <div id="validation_programa_solicitado" class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div id="container_solicitud_4" style="display: none;" >
                                    <div class="form-group col-md-12">
                                        <label for="competencia_solicitada">Competencia Laboral Solicitada: </label>
                                        <select id="competencia_solicitada" name="competencia_solicitada" class="form-control" onchange="removeValidation(this)">
                                            <option selected value="null" disabled>Seleccione...</option>                                             
                                            @foreach ($competencias_laborales as $competencia_laboral)
                                                <option value="{{$competencia_laboral->id}}">{{$competencia_laboral->nombre}}</option>
                                            @endforeach
                                        </select>  
                                        <div id="validation_competencia_solicitada" class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="cupos">Número de cupos: </label>
                                <input type="number" name="cupos" id="cupos" class="form-control">
                                <div id="validation_usuario_solicitud" class="invalid-feedback"></div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="usuario_solicitud">Usuario que solicito: </label>
                                <select id="usuario_solicitud" name="usuario_solicitud" class="form-control" onchange="removeValidation(this)">                                           
                                    @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->cargo . " - " . $usuario->municipios->nombre. " - " . $usuario->nombre_completo()}}</option>
                                    @endforeach
                                </select>  
                                <div id="validation_usuario_solicitud" class="invalid-feedback"></div>
                            </div>
                            
                            <div id="form_crear_solicitud_errors"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_crear_solicitud" class="btn btn-primary">Crear</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    </div> 
                </form>           
        </div>
    </div>
</div>
@endif