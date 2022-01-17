@if (count($ofertas_programas)>0)
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                <thead class="bg-dark">
                    <tr>
                        <td>Identificador del Programa</td>
                        <td>Programa</td>
                        <td>Nivel de Formación</td>
                        @if(tiene_rol(1)) <td>Centro</td> @endif
                        <td>Trimestre</td>
                        <td>Modalidad</td>
                        <td>Municipio</td>
                        <td>Número de cupos</td>
                        <td>Número de cursos</td>
                        <td>Mes de inicio</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ofertas_programas as $oferta_programa)
                    <tr>
                        <td>{{$oferta_programa->programas_centro->programa->codigo}}</td>
                        <td>{{$oferta_programa->programas_centro->programa->nombre}}</td>
                        <td>{{$oferta_programa->programas_centro->programa->nivel_formacion}}</td>
                        @if(tiene_rol(1))<td>{{$oferta_programa->programas_centro->centro->nombre}}</td>@endif
                        <td>{{$oferta_programa->trimestre->numero. "-". $oferta_programa->trimestre->vigencia . " ( " . $oferta_programa->trimestre->fecha_inicio ." / " .      $oferta_programa->trimestre->fecha_fin . " )" }}</td>
                        <td>{{$oferta_programa->modalidad}}</td>
                        <td>{{isset($oferta_programa->municipio->nombre) ? $oferta_programa->municipio->nombre : '---'}}</td>
                        <td>{{$oferta_programa->cupos}}</td>
                        <td>{{$oferta_programa->nro_grupos}}</td>
                        <td>{{convertir_mes($oferta_programa->mes_inicio)}}</td>
                        <td>{{$oferta_programa->estado == 1 ? 'DISPONIBLE' : 'ASIGNADA'}}</td>

                        <td>
                            <a id="btn_ver_oferta_programa_{{$oferta_programa->id}}" href="#" onclick="cargarModalVerOfertaPrograma({{$oferta_programa->id}})" class="btn btn-primary" title="Ver más">
                                <i class="fas fa-expand-arrows-alt mr-1"></i> Ver más
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $ofertas_programas->links() }}
</div>
@else
    <p>No se encontraron registros para la busqueda</p>
@endif
