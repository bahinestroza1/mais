@if (count($ofertas_programas)>0)
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                <thead>
                    <tr>
                        <td>Centro</td>
                        <td>Nivel de Formación</td>
                        <td>Programa</td>
                        <td>Trimestre</td>
                        <td>Modalidad</td>
                        <td>Municipio</td>
                        <td>Número de cursos</td>
                        <td>Número de cupos</td>
                        <td>Mes de inicio</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ofertas_programas as $oferta_programa)
                    <tr>
                        <td>{{$oferta_programa->programas_centro->centro->nombre}}</td>
                        <td>{{$oferta_programa->programas_centro->programa->nivel_formacion}}</td>
                        <td>{{$oferta_programa->programas_centro->programa->nombre}}</td>
                        <td>{{$oferta_programa->trimestre->numero. "-". $oferta_programa->trimestre->vigencia . " ( " . $oferta_programa->trimestre->fecha_inicio ." / " . $oferta_programa->trimestre->fecha_fin . " )" }}</td>
                        <td>{{$oferta_programa->modalidad}}</td>
                        <td>{{isset($oferta_programa->municipio->nombre) ? $oferta_programa->municipio->nombre : '---'}}</td>
                        <td>{{$oferta_programa->nro_grupos}}</td>
                        <td>{{$oferta_programa->cupos}}</td>
                        <td>{{convertir_mes($oferta_programa->mes_inicio)}}</td>
                        <td>
                            <a id="btn_oferta_programa_{{$oferta_programa->id}}" href="#" onclick="cargarModalOfertaPrograma(0,{{$oferta_programa->id}})" class="btn btn-success" title="Ver detalle">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a id="btn_oferta_programa_{{$oferta_programa->id}}" href="#" onclick="cargarModalOfertaPrograma(1,{{$oferta_programa->id}})" class="btn btn-primary" title="Editar">
                                <i class="fas fa-user-edit"></i> Editar
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
    <p>No se encontraron registros para la búsqueda</p>
@endif
