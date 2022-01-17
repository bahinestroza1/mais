<!-- Modal -->
<div id="modal_crear_programa" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">        
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Creación de programa</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_crear_funcionario" onsubmit="crearProgramaDeFormacion()" autocomplete="off">           
                <div class="modal-body">     
                        {{ csrf_field() }}
                        <div class="container">
                            <div class="row">
                                <p>Tener en cuenta que debes diligenciar todos los campos para el correcto registro del programa de formación.</p>
                            </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="acronimo">Acrónimo</label>
                                <input id="acronimo" name="acronimo" type="text" class="form-control" onchange="removeValidation(this)">
                                <div id="validation_acronimo" class="invalid-feedback"></div>  
                            </div>
                            <div class="col-md-6">
                                <label for="codigo">Código</label>
                                <input id="codigo" name="codigo" type="number" class="form-control" onchange="removeValidation(this)">
                                <div id="validation_codigo" class="invalid-feedback"></div>  
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="nombre">Nombre</label>
                                <input id="nombre" name="nombre" type="text" class="form-control" onchange="removeValidation(this)">
                                <div id="validation_nombre" class="invalid-feedback"></div>  
                            </div>
                            <div class="col-md-6">
                                <label for="version">Versión</label>
                                <input id="version" name="version" type="number" class="form-control" onchange="removeValidation(this)">
                                <div id="validation_version" class="invalid-feedback"></div>  
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="nivel_formacion">Nivel de Formación</label>
                                <select id="nivel_formacion" name="nivel_formacion" class="form-control" onchange="removeValidation(this)">   
                                    <option selected disabled>Seleccione...</option>                                        
                                    <option value="Auxiliar">Auxiliar</option>
                                    <option value="Complementario">Complementario</option>
                                    <option value="Especialización Tecnológica">Especialización Tecnológica</option>
                                    <option value="Operario">Operario</option>
                                    <option value="Técnico">Técnico</option>
                                    <option value="Tecnólogo">Tecnólogo</option>                           
                                </select>   
                                <div id="validation_nivel_formacion" class="invalid-feedback"></div>  
                            </div>                       
                        </div>
                        <div id="form_programas_errors" class="row"></div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_crear_programa" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    </div> 
                </form>           
        </div>
    </div>
</div>