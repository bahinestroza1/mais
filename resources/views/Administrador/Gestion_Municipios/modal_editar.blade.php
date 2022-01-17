<!-- Modal -->
<div id="modal_editar_municipio" class="modal fade mt-5 pt-5  rounded" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            @if(isset($municipio))
            <form method="POST" action="{{url('/admon/gestion_municipios/editar')}}" autocomplete="off">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Editar municipio</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">                
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$municipio->id}}">
                    <div class="container">
                        <div class="form-group">
                            <label for="">Código de Municipio</label>
                            <input type="text" class="form-control" name="codigo" value="{{$municipio->codigo}}">
                        </div>
                            <hr>
                        <div class="form-group">
                            <label for="">Nombre de Municipio</label>
                            <input type="text" class="form-control" name="nombre" value="{{$municipio->nombre}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                </div> 
            </form>
            @else
                <div class="modal-body">
                    <h1>
                        No se ha encontrado el municipio
                    </h1>
                </div>
            @endif
        </div>
    </div>
</div>