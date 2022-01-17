<!-- Modal -->
<div id="modal_funcionario" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">
            @if(isset($funcionario))            
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">{{$disabled ? 'Editar Funcionario' : 'Ver Funcionario'}}</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_editar_funcionario" onsubmit="editarFuncionario()" autocomplete="off">           
                <div class="modal-body">     
                        {{ csrf_field() }}
                        <input id="hidden" type="hidden" name="id" value="{{$funcionario->id}}">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="tipo_documento">Tipo de documento</label>
                                    @if($disabled)
                                        <select id="tipo_documento" name="tipo_documento" class="form-control" onchange="removeValidation(this)">                                           
                                            @foreach ($tipo_documentos as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                                            @endforeach
                                        </select>    
                                        <div id="validation_tipo_documento" class="invalid-feedback"></div>  
                                    @else
                                        <label class="form-control">{{$funcionario->tipo_documento->descripcion}}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="documento">Número de documento</label>
                                    @if($disabled)
                                        <input id="documento" type="number" class="form-control" name="documento" value="{{$funcionario->documento}}" onchange="removeValidation(this)">
                                        <div id="validation_documento" class="invalid-feedback"></div>  
                                    @else
                                        <label class="form-control">{{$funcionario->documento}}</label>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nombres">Nombres</label>
                                    @if($disabled)
                                        <input id="nombres" type="text" class="form-control" name="nombres" value="{{$funcionario->nombre}}" onchange="removeValidation(this)">
                                        <div id="validation_nombres" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$funcionario->nombre}}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    @if($disabled)
                                        <input id="apellidos" type="text" class="form-control" name="apellidos" value="{{$funcionario->apellido}}" onchange="removeValidation(this)">
                                        <div id="validation_apellidos" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$funcionario->apellido}}</label>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Correo Electrónico</label>
                                    @if($disabled)
                                        <input id="email" type="email" class="form-control" name="email" value="{{$funcionario->email}}" onchange="removeValidation(this)">
                                        <div id="validation_email" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$funcionario->email}}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono">Teléfono</label>
                                    @if($disabled)
                                        <input id="telefono" type="number" class="form-control" name="telefono" value="{{$funcionario->telefono}}" onchange="removeValidation(this)">
                                        <div id="validation_telefono" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$funcionario->telefono}}</label>
                                    @endif
                                </div>
                            </div>

                            @if($disabled)
                                @if(tiene_rol(1))
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="centro">Centro</label>            
                                            <select id="centro" name="centro" class="form-control" onchange="removeValidation(this)">
                                                @foreach ($centros as $centro)
                                                    <option {{$funcionario->centros_id == $centro->id ? 'selected' : ''}} value="{{$centro->id}}">{{$centro->nombre}}</option>
                                                @endforeach
                                            </select>
                                            <div id="validation_centro" class="invalid-feedback"></div>
                                        </div>                                
                                    </div>
                                @endif
                            @else
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="centro">Centro</label>
                                        <label class="form-control">{{$funcionario->centro->nombre}}</label>
                                    </div>
                                </div>

                            @endif
                            
                            

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="rol">Rol</label>
                                    @if($disabled)
                                        <select id="rol" name="rol" class="form-control" onchange="removeValidation(this)">
                                            @foreach ($roles as $rol)
                                                <option {{$funcionario->roles_id == $rol->id ? 'selected' : ''}} value="{{$rol->id}}">{{$rol->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <div id="validation_rol" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$funcionario->rol->nombre}}</label>
                                    @endif
                                </div>   
                                <div class="form-group col-md-6">
                                    <label for="estado">Estado</label>
                                    @if($disabled)
                                        <select id="estado" name="estado" class="form-control" onchange="removeValidation(this)">
                                            <option {{$funcionario->estado == 1 ? 'selected' : ''}} value="1">ACTIVO</option>
                                            <option {{$funcionario->estado == 0 ? 'selected' : ''}} value="0">INACTIVO</option>
                                        </select>
                                    @else
                                        <label class="form-control">{{$funcionario->estado == 1 ? 'ACTIVO' : 'INACTIVO'}}</label>
                                    @endif
                                </div>                            
                            </div>
                            <div id="form_funcionarios_errors"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($disabled)
                        <button id="btn_editar_funcionario" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                        @else
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        @endif
                    </div> 
                </form>
            
            @else
                <div class="modal-body">                   
                    <h1>
                        No se ha encontrado el funcionario
                    </h1>
                </div>
            @endif
        </div>
    </div>
</div>