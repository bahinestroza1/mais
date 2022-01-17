<!-- Modal -->
<div id="modal_usuario" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            @if(isset($usuario))            
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">{{$disabled ? 'EDITAR USUARIO:' : 'USUARIO : ' . $usuario->nombre . " " . $usuario->apellido }}</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_editar_usuario" onsubmit="editarUsuario()" autocomplete="off">           
                <div class="modal-body">     
                        {{ csrf_field() }}
                        <input id="hidden" type="hidden" name="id" value="{{$usuario->id}}">
                        <div class="container">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="tipo_documento">Tipo de documento</label>
                                    @if($disabled)
                                        <select id="tipo_documento" name="tipo_documento" class="form-control" onchange="removeValidation(this)" >                                           
                                            @foreach ($tipo_documentos as $tipo)
                                            <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                                            @endforeach
                                        </select>    
                                        <div id="validation_tipo_documento" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->tipo_documento->descripcion}}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="documento">Número de documento</label>
                                    @if($disabled)
                                        <input id="documento" type="number" class="form-control" name="documento" value="{{$usuario->documento}}" onchange="removeValidation(this)" >
                                        <div id="validation_documento" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->documento}}</label>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nombres">Nombres</label>
                                    @if($disabled)
                                        <input id="nombres" type="text" class="form-control" name="nombres" value="{{$usuario->nombre}}" onchange="removeValidation(this)" >
                                        <div id="validation_nombres" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->nombre}}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    @if($disabled)
                                        <input id="apellidos" type="text" class="form-control" name="apellidos" value="{{$usuario->apellido}}" onchange="removeValidation(this)" >
                                        <div id="validation_apellidos" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->apellido}}</label>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">Correo Electrónico</label>
                                    @if($disabled)
                                        <input id="email" type="email" class="form-control" name="email" value="{{$usuario->email}}" onchange="removeValidation(this)" >
                                        <div id="validation_email" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->email}}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono">Teléfono</label>
                                    @if($disabled)
                                        <input id="telefono" type="number" class="form-control" name="telefono" value="{{$usuario->telefono}}" onchange="removeValidation(this)" >
                                        <div id="validation_telefono" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->telefono}}</label>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="municipio">Municipio</label>
                                    @if($disabled)
                                        <select id="municipio" name="municipio" class="form-control" onchange="removeValidation(this)" >
                                            @foreach ($municipios as $municipio)
                                                <option {{$usuario->municipios_id == $municipio->id ? 'selected' : ''}} value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                                            @endforeach
                                        </select>
                                        <div id="validation_municipio" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->municipios->nombre}}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cargo">Cargo</label>
                                    @if($disabled)
                                        <input id="cargo" type="text" class="form-control" name="cargo" value="{{$usuario->cargo}}" onchange="removeValidation(this)" >
                                        <div id="validation_cargo" class="invalid-feedback"></div>
                                    @else
                                        <label class="form-control">{{$usuario->cargo}}</label>
                                    @endif
                                </div>
                            </div>
                            <div id="form_usuarios_errors"> </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if($disabled)
                            <button id="btn_editar_usuario" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                        @else
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        @endif
                    </div> 
                </form>
            
            @else
                <div class="modal-body">                   
                    <h1>
                        No se ha encontrado el usuario.
                    </h1>
                </div>
            @endif
        </div>
    </div>
</div>