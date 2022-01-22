@extends('layouts.app')

@section('htmlheader_title')
Reporte de Ofertas
@endsection

@section('contentheader_title')
Reporte de Ofertas
@endsection

@section('contentheader_description')
Reporte de Ofertas
@endsection

@section('menu-reportes')
menu-open
@endsection

@section('menu-reportes-reporte-ofertas')
active
@endsection


@section('content')
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
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="contenedor_reporte_ofertas">
                        <div class="mapdiv">                        
                            @include('Reportes.municipio_valle_ofertas')
                        </div>
                        <div class="contenedor_resultados_reporte_ofertas">
                            <form id="form_reporte_ofertas" method="POST" action="{{ route('descargar_reporte_ofertas_municipio') }}"  class="w-100" autocomplete="off">
                                <div class="card card-primary card-outline">
                                    <div class="card-body">
                                        <div id="prueba"></div>
                                            @csrf
                                            <div class="row">             
                                                <div id="prueba"></div>                
                                                <div class="col-md-12">                                                    
                                                    <label for="filtro_municipio">Municipio</label>      
                                                    <select id="filtro_municipio" name="filtro_municipio" class="form-control" onchange="mostrarInformacionOfertaMunicipio()">
                                                        <option value="null" selected disabled>Seleccione...</option>
                                                        <option value="null">TODOS</option>
                                                        @foreach ($municipios as $municipio)
                                                            <option value="{{str_replace(' ', '_', $municipio->nombre)}}" {{ (old('filtro_municipio') == "{str_replace(' ', '_', $municipio->nombre}") ? 'selected' : '' }}>{{$municipio->nombre}}</option>
                                                        @endforeach
                                                    </select>                          
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ofertas_municipio">                               
                                    </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection