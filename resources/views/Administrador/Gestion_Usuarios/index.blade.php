@extends('layouts.app')

@section('htmlheader_title')
Gestión de Usuarios
@endsection

@section('contentheader_title')
Gestión de Usuarios
@endsection

@section('contentheader_description')
Gestión de Usuarios
@endsection

@section('menu-administrador')
menu-open
@endsection

@section('menu-administrador-gestion_usuario')
active
@endsection


@section('content')
<div id="usuario_modal_container">
	@include('Administrador.Gestion_Usuarios.modal_usuario')
</div>

<div id="crear_usuario_modal_container">
	@include('Administrador.Gestion_Usuarios.modal_usuario')
</div>

<div id="crear_usuario_masivo_modal_container">
	@include('Administrador.Gestion_Usuarios.modal_usuario')
</div>

<div class="container-fluid">
    @if (Session::has('message'))
        <div class="row justify-content-center">
            <div class="{{ Session::get('class') }} col-md-12">
                {{ Session::get('message') }}
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <button class="btn btn-primary" onclick="cargarModalCrearUsuario()">Crear Usuario</button>
                        <button class="btn btn-outline-primary" onclick="cargarModalCrearUsuarioMasivo()" >Carga Masiva Usuarios</button>
                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header bg-dark">
                            <h3 class="card-title">Buscar Usuario:</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                    <i class="fas fa-minus" style="color: #FFF;"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
                            <form id="form_filtrar" onsubmit="filtrarUsuarios()" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="filtro_tipo">Tipo de documento</label>      
                                        <select id="filtro_tipo" name="filtro_tipo" class="form-control">                                           
                                            @foreach ($tipo_documentos as $tipo)
                                                <option value="{{$tipo->id}}">{{$tipo->descripcion}}</option>
                                            @endforeach
                                        </select>                          
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="filtro_documento">Número de documento</label>
                                        <input type="text" id="filtro_documento" name="filtro_documento" class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="filtro_municipio">Municipio</label>      
                                        <select id="filtro_municipio" name="filtro_municipio" class="form-control">
                                            <option selected value="null">TODOS</option>
                                            @foreach ($municipios as $municipio)
                                                <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                                            @endforeach
                                        </select>                          
                                    </div>

                                    <div class="col-md-3">
                                        <label for="filtro_estado">Estado</label>      
                                        <select id="filtro_estado" name="filtro_estado" class="form-control">
                                            <option value="1">ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>                          
                                    </div>
                                
                                    
                                    <div class="mt-2 col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary w-100">Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    @if(isset($usuarios))
                        <div id="tabla">
                            @include('Administrador.Gestion_Usuarios.tabla')
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
