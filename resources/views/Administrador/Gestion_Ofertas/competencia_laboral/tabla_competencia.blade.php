@if (count($ofertas_competencias)>0)
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                <thead>
                    <tr>
                        <td>Codigo NSCL</td>
                        <td>Competencia</td>
                        <td>Centro</td>
                        <td>Municipio</td>
                        <td>Trimestre</td>
                        <td>Mesa Sectorial</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ofertas_competencias as $oferta_competencia)
                    <tr>
                        <td>{{$oferta_competencia->competencias_centro->competencia_laboral->codigo_nscl}}</td>
                        <td>{{$oferta_competencia->competencias_centro->competencia_laboral->nombre}}</td>
                        <td>{{$oferta_competencia->competencias_centro->centro->nombre}}</td>
                        <td>{{$oferta_competencia->municipio->nombre}}</td>                       
                        <td>{{$oferta_competencia->trimestre->numero. "-". $oferta_competencia->trimestre->vigencia . " ( " . $oferta_competencia->trimestre->fecha_inicio ." / " . $oferta_competencia->trimestre->fecha_fin . " )" }}</td>
                        <td>{{$oferta_competencia->competencias_centro->competencia_laboral->mesa_sectorial}}</td>                        
                        <td>
                            <a id="btn_oferta_competencia_{{$oferta_competencia->id}}" href="#" onclick="" class="btn btn-primary" title="Editar/Ver">
                                <i class="fas fa-user-edit"></i> Editar
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $ofertas_competencias->links() }}
</div>
@else
    <p>No se encontraron registros para la busqueda</p>
@endif
