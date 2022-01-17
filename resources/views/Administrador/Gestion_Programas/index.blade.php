@extends('layouts.app')

@section('htmlheader_title')
Gestión de Programas
@endsection

@section('contentheader_title')
Gestión de Programas
@endsection

@section('contentheader_description')
Gestión de Programas
@endsection

@section('menu-administrador')
menu-open
@endsection

@section('menu-administrador-gestion_programa')
active
@endsection

@section('content')
<div id="editar_programa_modal_container">
	@include('Administrador.Gestion_Programas.modal_editar_programa')
</div>

<div id="crear_programa_modal_container">
	@include('Administrador.Gestion_Programas.modal_crear_programa')
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="card card-primary card-outline">
                    <div class="card-header">Búsqueda de programas</div>
                        <div class="card-body">
                            <form id="form_filtrar" onsubmit="filtrarProgramas()" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="filtro_codigo">Código</label>
                                        <input type="text" id="filtro_codigo" name="filtro_codigo" class="form-control">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="filtro_nombre">Nombre</label>
                                        <input type="text" id="filtro_nombre" name="filtro_nombre" class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="filtro_acronimo">Acrónimo</label>
                                        <input type="text" id="filtro_acronimo" name="filtro_acronimo" class="form-control">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="filtro_nivel_formacion">Nivel de Formación</label>      
                                        <select id="filtro_nivel_formacion" name="filtro_nivel_formacion" class="form-control">   
                                            <option selected value="null" >TODOS</option>                                        
                                            <option value="Auxiliar">Auxiliar</option>
                                            <option value="Complementario">Complementario</option>
                                            <option value="Especialización Tecnológica">Especialización Tecnológica</option>
                                            <option value="Operario">Operario</option>
                                            <option value="Técnico">Técnico</option>
                                            <option value="Tecnólogo">Tecnólogo</option>                        
                                        </select>                          
                                    </div>
                                    
                                    <div class="mt-2 col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary mr-1" style="min-width: 100px;">Consultar</button>
                                        @if(tiene_rol(1))
                                            <button 
                                                type="button" 
                                                class="btn btn-primary d-flex align-items-center justify-content-center" 
                                                style="min-width: 100px;"
                                                onclick="cargarModalCrearPrograma()"
                                            >
                                                <i class="fas fa-plus mr-2"></i>
                                                Nuevo
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabla de busquedas -->

                    <div id="contenido_programas" ></div>

                    @if(isset($programas))
                        <div id="tabla">
                            @include('Administrador.Gestion_Programas.tabla')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection