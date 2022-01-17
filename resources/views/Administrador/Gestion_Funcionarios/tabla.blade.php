@if (count($funcionarios)>0)
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                <thead>
                    <tr>
                        <td>Tipo Documento</td>
                        <td>Cédula</td>
                        <td>Nombre Completo</td>
                        <td>Centro</td>
                        <td>Rol</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($funcionarios as $funcionario)
                    <tr>
                        <td>{{$funcionario->tipo_documento->codigo}}</td>
                        <td>{{$funcionario->documento}}</td>
                        <td>{{$funcionario->nombre . " " . $funcionario->apellido }}</td>
                        <td>{{$funcionario->centro->nombre}}</td>
                        <td>{{$funcionario->rol->nombre}}</td>
                        <td>{{$funcionario->estado == 1 ? 'ACTIVO' : 'INACTIVO'}}</td>
                        <td>
                            <a id="btn_funcionarios_{{$funcionario->id}}" href="#" onclick="cargarModalFuncionario(1, {{$funcionario->id}})" class="btn btn-primary" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>&nbsp;&nbsp;

                            <a id="btn_funcionarios_{{$funcionario->id}}" href="#" onclick="cargarModalFuncionario(2, {{$funcionario->id}})" class="btn btn-warning" title="Editar">
                                <i class="fas fa-user-edit"></i>
                            </a>&nbsp;&nbsp;
                            
                            @if($funcionario->estado == 1)
                                <a id="btn_funcionarios_{{$funcionario->id}}" href="#" onclick="eliminarFuncionario({{$funcionario->id}})" class="btn btn-danger" title="Eliminar">
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
    {{ $funcionarios->links() }}
</div>
@else
    <p>No se encontraron registros para la búsqueda</p>
@endif