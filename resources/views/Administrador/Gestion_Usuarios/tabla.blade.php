@if (count($usuarios)>0)
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                <thead>
                    <tr>
                        <td>Tipo Documento</td>
                        <td>Cédula</td>
                        <td>Nombre Completo</td>
                        <td>Municipio</td>
                        <td>Cargo</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{$usuario->tipo_documento->codigo}}</td>
                        <td>{{$usuario->documento}}</td>
                        <td>{{$usuario->nombre . " " . $usuario->apellido }}</td>
                        <td>{{$usuario->municipios->nombre}}</td>
                        <td>{{$usuario->cargo}}</td>
                        <td>{{$usuario->estado == 1 ? 'ACTIVO' : 'INACTIVO'}}</td>
                        <td>
                            <a id="btn_usuarios_{{$usuario->id}}" href="#" onclick="cargarModalUsuario(1, {{$usuario->id}})" class="btn btn-primary" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>&nbsp;&nbsp;

                            <a id="btn_usuarios_{{$usuario->id}}" href="#" onclick="cargarModalUsuario(2, {{$usuario->id}})" class="btn btn-warning" title="Editar">
                                <i class="fas fa-user-edit"></i>
                            </a>&nbsp;&nbsp;
                            
                            @if($usuario->estado == 1)
                                <a id="btn_usuarios_{{$usuario->id}}" href="#" onclick="eliminarUsuario({{$usuario->id}})" class="btn btn-danger" title="Eliminar">
                                    <i class="fas fa-user-times"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $usuarios->links() }}
</div>
@else
    <p>No se encontraron registros para la búsqueda</p>
@endif