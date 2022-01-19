@extends('layouts.app')

@section('htmlheader_title')
Gestión de Oferta
@endsection

@section('contentheader_title')
Gestión de Oferta
@endsection

@section('contentheader_description')
Gestión de Oferta
@endsection

@section('menu-administrador')
menu-open
@endsection

@section('menu-administrador-gestion_oferta')
active
@endsection

@section('content')
<div id="crear_oferta_programa_modal_container">
	@include('Administrador.Gestion_Ofertas.programas.modal_crear_oferta')
</div>

<div id="crear_oferta_programa_masivo_modal_container">
    @include('Administrador.Gestion_Ofertas.programas.modal_crear_oferta_programa_masivo')
</div>

<div id="oferta_programa_modal_container">
    @include('Administrador.Gestion_Ofertas.programas.modal_oferta_programa')
</div>


<div id="crear_oferta_competencia_modal_container">
    @include('Administrador.Gestion_Ofertas.competencia_laboral.modal_crear_oferta_competencias')
</div>

<div id="oferta_competencia_modal_container">
    @include('Administrador.Gestion_Ofertas.competencia_laboral.modal_oferta_competencia')
</div>


<div class="container-fluid">
    @if (Session::has('message'))
        <div class="row justify-content-center">
            <div class="{{ Session::get('class') }} col-md-12">
                {{ Session::get('message') }}
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-dark">
            <h3 class="card-title">OFERTA DE PROGRAMAS</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus" style="color: #FFF;"></i></button>
            </div>
        </div>
        <div id="contenedor_oferta_programa" class="card-body">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">{{tiene_rol(1) ? 'Oferta: REGIONAL VALLE' : Auth::user()->centro->nombre }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus" style="color: #FFF;"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form id="form_filtrar" onsubmit="filtrarOfertaProgramas(event)" autocomplete="off">
                            @csrf
                            <input type="hidden" id="type" name="type" value="0">
                            <div class="row">
                                @if(tiene_rol(1))                                
                                    <div class="col-md-3">
                                        <label for="filtro_centro_programas">Centro</label>      
                                        <select id="filtro_centro_programas" name="filtro_centro_programas" class="form-control" value="{{ old('filtro_centro_programas') }}" >
                                            <option value="null">TODOS</option>
                                            @foreach ($centros as $centro)
                                                <option value="{{$centro->id}}" {{ (old('filtro_centro') === "{$centro->id}") ? 'selected' : '' }}>{{$centro->nombre}}</option>
                                            @endforeach
                                        </select>   
                                    </div>
                                @endif
                                
                                <div class="col-md-2">
                                    <label for="filtro_nivel_formacion_programas">Nivel de Formación</label>      
                                    <select id="filtro_nivel_formacion_programas" name="filtro_nivel_formacion_programas" class="form-control">   
                                        <option value="null">TODOS</option>                                        
                                        <option value="Auxiliar" {{ (old('filtro_nivel_formacion_programas') === "Auxiliar") ? 'selected' : '' }}>Auxiliar</option>
                                        <option value="Complementario" {{ (old('filtro_nivel_formacion_programas') === "Complementario") ? 'selected' : '' }}>Complementario</option>
                                        <option value="Especialización Tecnológica" {{ (old('filtro_nivel_formacion_programas') === "Especialización Tecnológica") ? 'selected' : '' }}>Especialización Tecnológica</option>
                                        <option value="Operario" {{ (old('filtro_nivel_formacion_programas') === "Operario") ? 'selected' : '' }}>Operario</option>
                                        <option value="Técnico" {{ (old('filtro_nivel_formacion_programas') === "Técnico") ? 'selected' : '' }}>Técnico</option>
                                        <option value="Tecnólogo" {{ (old('filtro_nivel_formacion_programas') === "Tecnólogo") ? 'selected' : '' }}>Tecnólogo</option>                        
                                    </select>                          
                                </div>

                                <div class="col-md-3">
                                    <label for="filtro_programa_programas">Programa</label>      
                                    <select id="filtro_programa_programas" name="filtro_programa_programas" class="form-control"  >
                                        <option value="null">TODOS</option>
                                        @foreach ($programas as $programa)
                                            <option value="{{$programa->id}}" {{ (old('filtro_programa_programas') === "{$programa->id}") ? 'selected' : '' }}>{{$programa->nombre}}</option>
                                        @endforeach
                                    </select>   
                                </div>
                                
                                <div class="col-md-2">
                                    <label for="filtro_municipio_programas">Municipio</label>      
                                    <select id="filtro_municipio_programas" name="filtro_municipio_programas" class="form-control"  >
                                        <option value="null">TODOS</option>
                                        @foreach ($municipios as $municipio)
                                            <option value="{{$municipio->id}}" {{ (old('filtro_municipio_programas') === "{$municipio->id}") ? 'selected' : '' }}>{{$municipio->nombre}}</option>
                                        @endforeach
                                    </select>   
                                </div>

                                <div class="col-md-3">
                                    <label for="filtro_trimestre_programas">Trimestre</label>
                                    <select id="filtro_trimestre_programas" name="filtro_trimestre_programas" class="form-control"  >
                                        <option value="null">TODOS</option>
                                        @foreach ($trimestres as $trimestre)
                                            <option value="{{$trimestre->id}}" {{ (old('filtro_trimestre_programas') === "{$trimestre->id}") ? 'selected' : '' }}>
                                                {{$trimestre->numero."-".$trimestre->vigencia . " ( " . $trimestre->fecha_inicio ." / " . $trimestre->fecha_fin . " )" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> 
                                
                                <div class="col-md-2">
                                    <label for="filtro_modalidad_programas">Modalidad</label>
                                    <select id="filtro_modalidad_programas" name="filtro_modalidad_programas" class="form-control"  >
                                        <option selected value="null">TODOS</option>
                                        <option value="PRESENCIAL" {{ (old('filtro_modalidad_programas') === "PRESENCIAL") ? 'selected' : '' }}>PRESENCIAL</option>
                                        <option value="VIRTUAL" {{ (old('filtro_modalidad_programas') === "VIRTUAL") ? 'selected' : '' }}>VIRTUAL</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="row mt-1">
                                <div class="mt-2 col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mr-1" style="min-width: 100px;">Consultar</button>
                                    <button 
                                        type="button" 
                                        class="btn btn-primary d-flex align-items-center justify-content-center mr-1" 
                                        style="min-width: 100px;"
                                        onclick="cargarModalCrearOfertaPrograma()"
                                    >
                                        <i class="fas fa-plus mr-2"></i>
                                        Nueva
                                    </button>
                                    <button 
                                        type="button" 
                                        class="btn btn-primary d-flex align-items-center justify-content-center" 
                                        style="min-width: 150px;"
                                        onclick="cargarModalOfertaProgramaMasivo()"
                                    >
                                        <i class="fas fa-plus mr-2"></i>
                                        Carga Masiva
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>   
            @if(isset($ofertas_programas))
                <div id="tabla">
                    @include('Administrador.Gestion_Ofertas.programas.tabla')
                </div>
            @endif
        </div>
    </div>


    <!-- Oferta de Competencias Laborales -->
    <div class="card">
        <div class="card-header bg-dark">
            <h3 class="card-title">OFERTA DE CERTIFICACIÓN LABORAL</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus" style="color: #FFF;"></i></button>
            </div>
        </div>
        <div id="contenedor_oferta_competencia" class="card-body">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">{{tiene_rol(1) ? 'Oferta: REGIONAL VALLE' : Auth::user()->centro->nombre }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fas fa-minus" style="color: #FFF;"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container">
                        <form id="form_filtrar" onsubmit="filtrarOfertaCompetencias()" autocomplete="off">
                            <input type="hidden" id="type" name="type" value="1">
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
                                            <option value="null">TODOS</option>
                                            @foreach ($centros as $centro)
                                                <option value="{{$centro->id}}" {{ (old('filtro_centro') === "{$centro->id}") ? 'selected' : '' }}>{{$centro->nombre}}</option>
                                            @endforeach
                                        </select>   
                                    </div>
                                @endif
                                
                                <div class="col-md-2">
                                    <label for="filtro_municipio">Municipio</label>      
                                    <select id="filtro_municipio" name="filtro_municipio" class="form-control">
                                        <option value="null">TODOS</option>
                                        @foreach ($municipios as $municipio)
                                            <option value="{{$municipio->id}}" {{ (old('filtro_municipio') === "{$municipio->id}") ? 'selected' : '' }}>{{$municipio->nombre}}</option>
                                        @endforeach
                                    </select>   
                                </div>

                                <div class="col-md-2">
                                    <label for="filtro_trimestre">Trimestre</label>
                                    <select id="filtro_trimestre" name="filtro_trimestre" class="form-control">
                                        <option value="null">TODOS</option>
                                        @foreach ($trimestres as $trimestre)
                                            <option value="{{$trimestre->id}}" {{ (old('filtro_trimestre') === "{$trimestre->id}") ? 'selected' : '' }}>
                                                {{$trimestre->numero."-".$trimestre->vigencia . " ( " . $trimestre->fecha_inicio ." / " . $trimestre->fecha_fin . " )" }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mt-2 col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mr-1" style="min-width: 100px;">Consultar</button>
                                    <button 
                                        type="button" 
                                        class="btn btn-primary d-flex align-items-center justify-content-center" 
                                        style="min-width: 100px;"
                                        onclick="cargarModalCrearOfertaCompetencia()"
                                    >
                                        <i class="fas fa-plus mr-2"></i>
                                        Nueva
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>   
            @if(isset($ofertas_competencias))
                <div id="tabla">
                    @include('Administrador.Gestion_Ofertas.competencia_laboral.tabla_competencia')
                </div>
            @endif
        </div>
    </div> 
</div>
@endsection