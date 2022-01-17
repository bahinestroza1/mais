@if (count($data)>0)
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="table-responsive">
            <table cellpadding="0" cellspacing="0" class="table table-bordered table-hover text-center text-nowrap">
                <thead>
                    <tr>
                        <td>Código de Municipio</td>
                        <td>Nombre de Municipio</td>
                        @if(tiene_rol(1))<td>Acciones</td>@endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $municipio)
                    <tr>
                        <td>{{$municipio->codigo}}</td>
                        <td>{{$municipio->nombre}}</td>
                        @if(tiene_rol(1)) 
                            <td>
                                <a id="btn_municipios_{{$municipio->id}}" href="#" onclick="cargarModalEditarMunicipio({{$municipio->id}})" class="btn btn-primary" title="Editar/Ver">
                                    <i class="fas fa-user-edit"></i> Editar
                                </a>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $data->links() }}
</div>
@else
    <p>No se encontraron registros para la busqueda</p>
@endif