<!-- Modal -->
<div id="modal_crear_funcionario" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">        
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Crear Funcionario</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_crear_funcionario" onsubmit="crearFuncionario()" autocomplete="off">           
                <div class="modal-body">     
                        {{ csrf_field() }}
                        <div class="container">
                            <input type="hidden" id="password" name="password">
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
                                @if(tiene_rol(1))
                                    <div class="form-group col-md-6">
                                        <label for="centro">Centro</label>
                                        <select id="centro" name="centro" class="form-control" onchange="removeValidation(this)">
                                            <option selected disabled>Seleccione Centro</option>
                                            @foreach ($centros as $centro)
                                                <option value="{{$centro->id}}">{{$centro->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <div id="validation_centro" class="invalid-feedback"></div>
                                    </div>  
                                @endif
                                <div class="form-group col-md-6">
                                    <label for="rol">Rol de funcionario</label>
                                    <select id="rol" name="rol" class="form-control" onchange="removeValidation(this)">
                                        <option selected disabled>Seleccione Rol</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{$rol->id}}">{{$rol->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <div id="validation_rol" class="invalid-feedback"></div>
                                </div>                                
                            </div>

                            <div id="form_funcionarios_errors"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_crear_funcionario" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    </div> 
                </form>           
        </div>
    </div>
</div>