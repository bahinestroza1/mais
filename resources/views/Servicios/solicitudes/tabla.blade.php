@if(count($solicitudes)>0)

<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                <thead class="bg-dark">
                    <tr>
                        <td>ID. Solicitud</td>
                        <td>Titulo</td>
                        <td>Tipo de Servicio</td>
                        <td>Servicio Solicitado</td>
                        <td>Cupos Requeridos</td>
                        <td>Fecha de Solicitud</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($solicitudes as $solicitud)
                        <tr>
                            <td>{{$solicitud->id}}</td>
                            <td>{{$solicitud->titulo}}</td>
                            <td>{{$solicitud->servicio->nombre}}</td>
                            @if(isset($solicitud->programas_id))
                                <td>{{$solicitud->programa->nombre}}</td>
                            @else 
                                @if(isset($solicitud->competencias_id))
                                    <td>{{$solicitud->competencia_laboral->nombre}}</td>
                                @else
                                <td>{{$solicitud->servicio->nombre}}</td>
                                @endif
                            @endif
                            <td>{{$solicitud->cupos}}</td>
                            <td>{{$solicitud->fecha_solicitud}}</td>
                            <td>{{$solicitud->estado == 1 ? 'PENDIENTE' : 'APROBADO'}}</td>
                            <td>
                                <a id="btn_ver_solicitud_{{$solicitud->id}}" href="#" onclick="cargarModalVerSolicitud({{$solicitud->id}})" class="btn btn-primary" title="Ver detalle">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </a>&nbsp;&nbsp;
                                @if(tiene_rol(2,4) && $solicitud->estado == 1)
                                    <a id="btn_tomar_solicitud_programa_{{$solicitud->id}}" href="#" onclick="cargarModalTomarSolicitudOfertaPrograma({{$solicitud->id}})" class="btn btn-success" title="Tomar Solicitud">
                                        <i class="fas fa-check"></i> 
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>       
    </div>
    {{ $solicitudes->links() }}
</div>
@else
    <p>No se encontraron registros</p>
@endif