@if(isset($programas))
    @if( count($programas)>0)
        <div id="list_of_programas" class="card card-primary card-outline">
            <div class="card-header">
                Listado de programas
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                        <thead>
                            <tr>
                                <td>Código</td>
                                <td>Nombre</td>
                                <td>Acrónimo</td>
                                <td>Versión</td>
                                <td>Nivel Formación</td>
                                <td>Estado</td>
                                @if(tiene_rol(1))
                                    <td>Acciones</td>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($programas as $programa)
                            <tr>
                                <td>{{$programa->codigo}}</td>
                                <td>{{$programa->nombre}}</td>
                                <td>{{$programa->acronimo}}</td>
                                <td>{{$programa->version}}</td>
                                <td>{{$programa->nivel_formacion}}</td>
                                <td>{{$programa->estado == 1 ? 'ACTIVO' : 'INACTIVO'}}</td>
                                @if(tiene_rol(1))
                                    <td>
                                        <a id="btn_programas_{{$programa->id}}" href="#" onclick="cargarModalPrograma({{$programa->id}})" class="btn btn-primary" title="Editar">
                                            <i class="fas fa-user-edit"></i>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $programas->links() }}
        </div>
    @else
        <p>No se encontraron registros para la búsqueda</p>
    @endif
@endif