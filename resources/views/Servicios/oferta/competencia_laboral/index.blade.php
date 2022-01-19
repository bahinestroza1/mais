@extends('layouts.app')

@section('htmlheader_title')
Oferta Competencias SENA
@endsection

@section('contentheader_title')
Oferta Competencias SENA
@endsection

@section('contentheader_description')
Oferta Competencias SENA
@endsection

@section('menu-servicios')
menu-open
@endsection

@section('menu-servicios-oferta-competencia')
active
@endsection

@section('content')
<div id="ver_oferta_competencia_modal_container">
	@include('Servicios.oferta.competencia_laboral.modal')
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-dark">
            <h3 class="card-title">{{tiene_rol(1) ? 'OFERTA PROGRAMAS: REGIONAL VALLE' : Auth::user()->centro->nombre }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus" style="color: #FFF;"></i></button>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form id="form_filtrar" onsubmit="filtrarOfertasCompetencias()" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="filtro_nombre">Nombre</label>      
                            <input name="filtro_nombre" id="filtro_nombre" type="text" class="form-control" value="{{ old('filtro_nombre') }}">
                        </div>

                        <div class="col-md-2">
                            <label for="filtro_codigo_nscl">Código NSCL</label>      
                            <input type="number" name="filtro_codigo_nscl" id="filtro_codigo_nscl" class="form-control" value="{{ old('filtro_codigo_nscl') }}">                          
                        </div>

                        @if(tiene_rol(1))                                
                            <div class="col-md-3">
                                <label for="filtro_centro">Centro</label>      
                                <select id="filtro_centro" name="filtro_centro" class="form-control">
                                    <option selected value="null">TODOS</option>
                                    @foreach ($centros as $centro)
                                        <option value="{{$centro->id}}" {{ (old('filtro_centro') === "{$centro->id}") ? 'selected' : '' }}>{{$centro->nombre}}</option>
                                    @endforeach
                                </select>   
                            </div>
                        @endif
                        
                        <div class="col-md-2">
                            <label for="filtro_municipio">Municipio</label>      
                            <select id="filtro_municipio" name="filtro_municipio" class="form-control">
                                <option selected value="null">TODOS</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{$municipio->id}}" {{ (old('filtro_municipio') === "{$municipio->id}") ? 'selected' : '' }}>{{$municipio->nombre}}</option>
                                @endforeach
                            </select>   
                        </div>

                        <div class="col-md-2">
                            <label for="filtro_trimestre">Trimestre</label>
                            <select id="filtro_trimestre" name="filtro_trimestre" class="form-control">
                                <option selected value="null">TODOS</option>
                                @foreach ($trimestres as $trimestre)
                                    <option value="{{$trimestre->id}}" {{ (old('filtro_trimestre') === "{$trimestre->id}") ? 'selected' : '' }}>
                                        {{$trimestre->numero."-".$trimestre->vigencia . " ( " . $trimestre->fecha_inicio ." / " . $trimestre->fecha_fin . " )" }}
                                    </option>
                                @endforeach
                            </select>
                        </div>                             
                    </div>
                    <div class="row">
                        <div class="mt-2 col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary mr-1" style="min-width: 100px;">Consultar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(isset($ofertas_competencias))
        <div id="tabla">
            @include('Servicios.oferta.competencia_laboral.tabla')
        </div>
    @endif

</div>

@endsection