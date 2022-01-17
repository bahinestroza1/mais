<!-- Modal -->
<div id="modal_editar_programa" class="modal fade mt-5 pt-5  rounded" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            @if(isset($programa))
            <form id="form_editar_programa" onsubmit="editarPrograma()" autocomplete="off">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Editar Programa</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">                
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$programa->id}}">
                    <div class="container">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="acronimo">Acrónimo</label>
                                <input id="acronimo" name="acronimo" type="text" class="form-control" value="{{$programa->acronimo}}" onchange="removeValidation(this)">
                                <div id="validation_acronimo" class="invalid-feedback"></div> 
                            </div>
                            <div class="col-md-6">
                                <label for="codigo">Código</label>
                                <input id="codigo" name="codigo" type="number" class="form-control" value="{{$programa->codigo}}" onchange="removeValidation(this)">
                                <div id="validation_codigo" class="invalid-feedback"></div> 
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" name="nombre" type="text" class="form-control" value="{{$programa->nombre}}" onchange="removeValidation(this)">
                                <div id="validation_nombre" class="invalid-feedback"></div> 
                            </div>
                            <div class="col-md-6">
                                <label for="version">Versión</label>
                                <input id="version" name="version" type="number" class="form-control" value="{{$programa->version}}" onchange="removeValidation(this)">
                                <div id="validation_version" class="invalid-feedback"></div> 
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="nivel_formacion">Nivel de Formación</label>
                                <select id="nivel_formacion" name="nivel_formacion" class="form-control" onchange="removeValidation(this)">   
                                    <option {{$programa->nivel_formacion == "Auxiliar" ? 'selected' : ''}} value="Auxiliar">Auxiliar</option>
                                    <option {{$programa->nivel_formacion == "Complementario" ? 'selected' : ''}} value="Complementario">Complementario</option>
                                    <option {{$programa->nivel_formacion == "Especialización Tecnológica" ? 'selected' : ''}} value="Especialización Tecnológica">Especialización Tecnológica</option>
                                    <option {{$programa->nivel_formacion == "Operario" ? 'selected' : ''}} value="Operario">Operario</option>
                                    <option {{$programa->nivel_formacion == "Técnico" ? 'selected' : ''}} value="Técnico">Técnico</option>
                                    <option {{$programa->nivel_formacion == "Tecnólogo" ? 'selected' : ''}} value="Tecnólogo">Tecnólogo</option>                           
                                </select>   
                                <div id="validation_" class="invalid-feedback"></div> 
                            </div>   
                            <div class="col-md-6">
                                <label for="estado">Estado</label>
                                <select name="estado" id="estado" class="form-control" onchange="removeValidation(this)">
                                    <option {{$programa->estado == 1 ? 'selected' : ''}} value="1">Activo</option>
                                    <option {{$programa->estado == 0 ? 'selected' : ''}} value="0">Inactivo</option>
                                </select>
                                <div id="validation_estado" class="invalid-feedback"></div> 
                            </div>                    
                        </div>
                        <div id="form_programas_errors" class="row"></div>                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn_editar_programa" class="btn btn-success">Actualizar</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                </div> 
            </form>
            @else
                <div class="modal-body">
                    <h1>
                        No se ha encontrado el programa
                    </h1>
                </div>
            @endif
        </div>
    </div>
</div>