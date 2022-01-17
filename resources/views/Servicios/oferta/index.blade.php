@extends('layouts.app')

@section('htmlheader_title')
Oferta SENA
@endsection

@section('contentheader_title')
Oferta Programas SENA
@endsection

@section('contentheader_description')
Oferta Programas SENA
@endsection

@section('menu-servicios')
menu-open
@endsection

@section('menu-servicios-oferta')
active
@endsection

@section('content')
<div id="ver_oferta_programa_modal_container">
	@include('Servicios.oferta.modal')
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
                <form id="form_filtrar_oferta_programa" onsubmit="filtrarOfertaPrograma()" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="filtro_centro">Centro</label>      
                            <select id="filtro_centro" name="filtro_centro" class="form-control" >
                                <option selected value="null">TODOS</option>
                                @foreach ($centros as $centro)
                                    <option value="{{$centro->id}}" {{ (old('filtro_centro') === "{$centro->id}") ? 'selected' : '' }}>{{$centro->nombre}}</option>
                                @endforeach
                            </select>   
                        </div>
                        
                        <div class="col-md-2">
                            <label for="filtro_nivel_formacion">Nivel de Formación</label>      
                            <select id="filtro_nivel_formacion" name="filtro_nivel_formacion" class="form-control"  >   
                                <option value="null">TODOS</option>                                        
                                <option value="Auxiliar" {{ (old('filtro_nivel_formacion') === "Auxiliar") ? 'selected' : '' }}>Auxiliar</option>
                                <option value="Complementario" {{ (old('filtro_nivel_formacion') === "Complementario") ? 'selected' : '' }}>Complementario</option>
                                <option value="Especialización Tecnológica" {{ (old('filtro_nivel_formacion') === "Especialización Tecnológica") ? 'selected' : '' }}>Especialización Tecnológica</option>
                                <option value="Operario" {{ (old('filtro_nivel_formacion') === "Operario") ? 'selected' : '' }}>Operario</option>
                                <option value="Técnico" {{ (old('filtro_nivel_formacion') === "Técnico") ? 'selected' : '' }}>Técnico</option>
                                <option value="Tecnólogo" {{ (old('filtro_nivel_formacion') === "Tecnólogo") ? 'selected' : '' }}>Tecnólogo</option>                            
                            </select>                          
                        </div>

                        <div class="col-md-3">
                            <label for="filtro_programa">Programa</label>      
                            <select id="filtro_programa" name="filtro_programa" class="form-control"  >
                                <option selected value="null">TODOS</option>
                                @foreach ($programas as $programa)
                                    <option value="{{$programa->id}}" {{ (old('filtro_programa') === "{$programa->id}") ? 'selected' : '' }}>{{$programa->nombre}}</option>
                                @endforeach
                            </select>   
                        </div>
                        
                        <div class="col-md-2">
                            <label for="filtro_municipio">Municipio</label>      
                            <select id="filtro_municipio" name="filtro_municipio" class="form-control"  >
                                <option selected value="null">TODOS</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{$municipio->id}}" {{ (old('filtro_municipio') === "{$municipio->id}") ? 'selected' : '' }}>{{$municipio->nombre}}</option>
                                @endforeach
                            </select>   
                        </div>

                        <div class="col-md-2">
                            <label for="filtro_trimestre">Trimestre</label>
                            <select id="filtro_trimestre" name="filtro_trimestre" class="form-control"  >
                                <option selected value="null">TODOS</option>
                                @foreach ($trimestres as $trimestre)
                                    <option value="{{$trimestre->id}}" {{ (old('filtro_trimestre') === "{$trimestre->id}") ? 'selected' : '' }}>
                                        {{$trimestre->numero."-".$trimestre->vigencia . " ( " . $trimestre->fecha_inicio ." / " . $trimestre->fecha_fin . " )" }}
                                    </option>
                                @endforeach
                            </select>
                        </div>     

                        <div class="col-md-2">
                            <label for="filtro_modalidad">Modalidad</label>
                            <select id="filtro_modalidad" name="filtro_modalidad" class="form-control"  >
                                <option selected value="null">TODOS</option>
                                <option value="PRESENCIAL" {{ (old('filtro_modalidad') === "PRESENCIAL") ? 'selected' : '' }}>PRESENCIAL</option>
                                <option value="VIRTUAL" {{ (old('filtro_modalidad') === "VIRTUAL") ? 'selected' : '' }}>VIRTUAL</option>
                            </select>
                        </div>                               
                        
                        <div class="col-md-2">
                            <label for="filtro_estado_oferta">Estado Oferta</label>
                            <select id="filtro_estado_oferta" name="filtro_estado_oferta" class="form-control"  >
                                <option value="1" {{ (old('filtro_estado_oferta') === "1") ? 'selected' : '' }}>DISPONIBLE</option>
                                <option value="2" {{ (old('filtro_estado_oferta') === "2") ? 'selected' : '' }}>ASIGNADA</option>
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

    @if(isset($ofertas_programas))
        <div id="tabla_oferta_programa">
            @include('Servicios.oferta.tabla')
        </div>
    @endif

</div>

@endsection