<!-- Modal -->
<div id="modal_crear_usuario" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">        
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Crear Usuario</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_crear_usuario" onsubmit="crearUsuario(event)" autocomplete="off">           
                <div class="modal-body">     
                        {{ csrf_field() }}
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="tipo_documento">Tipo de documento</label>
                                    <select id="tipo_documento" name="tipo_documento" class="form-control" onchange="removeValidation(this)">                                           
                                        @foreach ($tipo_documentos as $tipo)
                                        <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                                        @endforeach
                                    </select>  
                                    <div id="validation_tipo_documento" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="documento">Número de documento</label>
                                    <input id="documento" type="number" class="form-control" name="documento" onchange="removeValidation(this)">
                                    <div id="validation_documento" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nombres">Nombres</label>
                                    <input id="nombres" type="text" class="form-control" name="nombres" onchange="removeValidation(this)">
                                    <div id="validation_nombres" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    <input id="apellidos" type="text" class="form-control" name="apellidos" onchange="removeValidation(this)">
                                    <div id="validation_apellidos" class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Correo Electrónico</label>
                                    <input id="email" type="email" class="form-control" name="email" onchange="removeValidation(this)">
                                    <div id="validation_email" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono">Teléfono</label>
                                    <input id="telefono" type="number" class="form-control" name="telefono" onchange="removeValidation(this)">
                                    <div id="validation_telefono" class="invalid-feedback"></div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="municipio">Municipio</label>
                                    <select id="municipio" name="municipio" class="form-control" onchange="removeValidation(this)">
                                        <option selected disabled>Seleccione Municipio</option>
                                        @foreach ($municipios as $municipio)
                                            <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <div id="validation_municipio" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cargo">Cargo</label>
                                    <input id="cargo" type="text" class="form-control" name="cargo" onchange="removeValidation(this)">
                                    <div id="validation_cargo" class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div id="form_usuarios_errors"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_crear_usuario" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    </div> 
                </form>           
        </div>
    </div>
</div>