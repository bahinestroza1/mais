@extends('layouts.app')

@section('htmlheader_title')
Gestión de Municipios
@endsection

@section('contentheader_title')
Gestión de Municipios
@endsection

@section('contentheader_description')
Gestión de Municipios
@endsection

@section('menu-administrador')
menu-open
@endsection

@section('menu-administrador-gestion_municipios')
active
@endsection

@section('content')
<div id="editar_municipio_modal_container">
	@include('Administrador.Gestion_Municipios.modal_editar')
</div>

<div class="container">
    @if (Session::has('message'))
        <div class="row justify-content-center">
            <div class="{{ Session::get('class') }} col-md-12">
                {{ Session::get('message') }}
            </div>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header bg-dark">
                    <h3 class="card-title">Buscar Municipio:</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus" style="color: #FFF;"></i></button>
                    </div>
                </div>

                <div class="card-body">
                    <form id="form_filtrar" onsubmit="filtrarMunicipio(event)" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label for="filtro_codigo">Código de Municipio</label>
                                <input type="number" id="filtro_codigo" name="filtro_codigo" class="form-control" value="{{ old('filtro_codigo') }}" >
                            </div>
                            
                            <div class="col-md-4">
                                <label for="filtro_nombre">Nombre de Municipio</label>
                                <input type="text" id="filtro_nombre" name="filtro_nombre" class="form-control" value="{{ old('filtro_nombre') }}" >
                            </div>
                            
                            <div class="mt-2 col-md-2 d-flex align-items-end">
                                <button class="btn btn-primary w-100">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            @if(isset($data))
                <div id="tabla">
                    @include('Administrador.Gestion_Municipios.tabla')
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
