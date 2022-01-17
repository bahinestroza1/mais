@extends('layouts.app')

@section('htmlheader_title')
Gestión de Funcionarios
@endsection

@section('contentheader_title')
Gestión de Funcionarios
@endsection

@section('contentheader_description')
Gestión de Funcionarios
@endsection

@section('menu-administrador')
menu-open
@endsection

@section('menu-administrador-gestion_funcionarios')
active
@endsection


@section('content')
<div id="funcionario_modal_container">
	@include('Administrador.Gestion_Funcionarios.modal_funcionario')
</div>

<div id="crear_funcionario_modal_container">
	@include('Administrador.Gestion_Funcionarios.modal_crear_funcionario')
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
                        <button class="btn btn-primary" onclick="cargarModalCrearFuncionario()">Crear Funcionario</button>
                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header bg-dark">
                            <h3 class="card-title">Buscar Funcionario:</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                    <i class="fas fa-minus" style="color: #FFF;"></i></button>
                            </div>
                        </div>

                        <div class="card-body">
                            <form id="form_filtrar" onsubmit="filtrarFuncionarios()" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="filtro_tipo">Tipo de documento</label>      
                                        <select id="filtro_tipo" name="filtro_tipo" class="form-control">                                           
                                            @foreach ($tipo_documentos as $tipo)
                                                <option value="{{$tipo->id}}" {{ (old('filtro_tipo') === "{$tipo->id}") ? 'selected' : '' }}>{{$tipo->descripcion}}</option>
                                            @endforeach
                                        </select>                          
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="filtro_documento">Número de documento</label>
                                        <input type="number" id="filtro_documento" name="filtro_documento" class="form-control" value="{{ old('filtro_documento') }}">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="filtro_nombre">Nombre completo</label>
                                        <input type="text" id="filtro_nombre" name="filtro_nombre" class="form-control" value="{{ old('filtro_nombre') }}">
                                    </div>

                                    @if(tiene_rol(1))
                                        <div class="col-md-3">
                                            <label for="filtro_centro">Centro</label>      
                                            <select id="filtro_centro" name="filtro_centro" class="form-control" value="{{ old('filtro_centro') }}">
                                                <option selected disabled>Seleccione Centro</option>
                                                @foreach ($centros as $centro)
                                                    <option value="{{$centro->id}}" {{ (old('filtro_centro') === "{$centro->id}") ? 'selected' : '' }}>{{$centro->nombre}}</option>
                                                @endforeach
                                            </select>                          
                                        </div>
                                    @endif

                                    <div class="col-md-3">
                                        <label for="filtro_rol">Rol</label>      
                                        <select id="filtro_rol" name="filtro_rol" class="form-control" value="{{ old('filtro_rol') }}">
                                            <option selected disabled>Seleccione Rol</option>
                                            @foreach ($roles as $rol)
                                                <option value="{{$rol->id}}" {{ (old('filtro_rol') === "{$rol->id}") ? 'selected' : '' }}>{{$rol->nombre}}</option>
                                            @endforeach
                                        </select>                          
                                    </div>     
                                    
                                    <div class="col-md-3">
                                        <label for="filtro_estado">Estado</label>      
                                        <select id="filtro_estado" name="filtro_estado" class="form-control" value="{{ old('filtro_estado') }}">
                                            <option value="1" {{ (old('filtro_estado') == "1") ? 'selected' : '' }}>ACTIVO</option>
                                            <option value="0" {{ (old('filtro_estado') == "0") ? 'selected' : '' }}>INACTIVO</option>
                                        </select>                          
                                    </div>
                                    
                                    <div class="mt-2 col-md-2 d-flex align-items-end">
                                        <button class="btn btn-primary w-100">Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    @if(isset($funcionarios))
                        <div id="tabla">
                            @include('Administrador.Gestion_Funcionarios.tabla')
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
