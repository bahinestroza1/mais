@extends('layouts.app')

@section('htmlheader_title')
Solicitudes SENA
@endsection

@section('contentheader_title')
Solicitudes SENA
@endsection

@section('contentheader_description')
Solicitudes
@endsection

@section('menu-servicios')
menu-open
@endsection

@section('menu-servicios-solicitudes')
active
@endsection

@section('content')
<div id="crear_solicitud_modal_container">
	@include('Servicios.solicitudes.modal_crear_solicitud')
</div>

<div id="ver_solicitud_modal_container">
	@include('Servicios.solicitudes.modal_ver_solicitud')
</div>

<div id="tomar_solicitud_modal_container">
	@include('Servicios.solicitudes.modal_tomar_solicitud')
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-dark">
            <h3 class="card-title">SOLICITUDES</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus" style="color: #FFF;"></i></button>
            </div>
        </div>
        <div class="card-body">      
            <div class="container-fluid">      
                <form id="form_filtrar" onsubmit="filtrarSolicitudes()" autocomplete="off">
                    @csrf
                    <div class="row">                      
                        <div class="col-md-3">
                            <label for="filtro_servicio">Tipo de Servicio</label>      
                            <select id="filtro_servicio" name="filtro_servicio" class="form-control"  >   
                                <option value="null">TODOS</option>  
                                @foreach ($servicios as $servicio)
                                    <option value="{{$servicio->id}}" {{ (old('filtro_servicio') === "{$servicio->id}") ? 'selected' : '' }}>{{$servicio->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="filtro_fecha_inicio">Fecha inicio de solicitud</label>
                            <input type="date" name="filtro_fecha_inicio" id="filtro_fecha_inicio" class="form-control" value="{{ old('filtro_fecha_inicio') }}">
                        </div>
                        
                        <div class="col-md-2">
                            <label for="filtro_fecha_fin">Fecha fin de solicitud</label>
                            <input type="date" name="filtro_fecha_fin" id="filtro_fecha_fin" class="form-control" value="{{ old('filtro_fecha_fin') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="filtro_estado">Estado</label>
                            <select id="filtro_estado" name="filtro_estado" class="form-control"  >
                                <option selected value="null">TODOS</option>
                                <option value="0" {{ (old('filtro_estado') === "0") ? 'selected' : '' }}>ELIMINADA</option>
                                <option value="1" {{ (old('filtro_estado') === "1") ? 'selected' : '' }}>PENDIENTE</option>
                                <option value="2" {{ (old('filtro_estado') === "2") ? 'selected' : '' }}>APROBADO</option>
                            </select>
                        </div>                               
                    </div>
                    <div class="row">
                        <div class="mt-2 col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-1" style="min-width: 100px;">Consultar</button>
                            <button 
                                type="button" 
                                class="btn btn-primary d-flex align-items-center justify-content-center mr-1" 
                                style="min-width: 100px;"
                                onclick="cargarModalCrearSolicitud()"
                            >
                                <i class="fas fa-plus mr-2"></i>
                                Crear Solicitud
                            </button>                            
                        </div>                        
                    </div>
                </form>
            </div>            
        </div>
    </div>
    @if(isset($solicitudes))
        <div id="tabla">
            @include('Servicios.solicitudes.tabla')
        </div>
    @endif
</div>
@endsection