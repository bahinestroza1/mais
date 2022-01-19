<!-- Modal -->
<div id="modal_oferta_competencia" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">
            @if(isset($oferta_competencia))
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">{{$editar == true ? 'Editar' : 'Ver'}} Oferta de Competencia Laboral</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_editar_oferta_competencia" onsubmit="editarOfertaDeCompetencia()" autocomplete="off">     
                <input type="hidden" id="id" name="id" value="{{$oferta_competencia->id}}">      
                <div class="modal-body">     
                        {{ csrf_field() }}
                    <div class="container">
                        @if($editar)
                            <div class="row">
                                <p>Tener en cuenta que debes diligenciar todos los campos.</p>
                            </div>
                        @endif
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="trimestre">Trimestre</label>
                                <select id="trimestre" name="trimestre" class="form-control" {{$editar ? '' : 'disabled'}} >
                                    <option selected disabled >Seleccione</option>
                                    @foreach ($trimestres as $trimestre)
                                        <option value="{{$trimestre->id}}" {{$oferta_competencia->trimestres_id == $trimestre->id ? 'selected' : ''}}>
                                            {{$trimestre->numero."-".$trimestre->vigencia . " ( " . $trimestre->fecha_inicio ." / " . $trimestre->fecha_fin . " )" }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="duracion">Duración <span style="font-size: 14px; font-weight: normal; ">(Meses)</span></label>
                                <input id="duracion" name="duracion" type="number" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_competencia->duracion}}">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <input id="fecha_inicio" name="fecha_inicio" type="date" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_competencia->fecha_inicio}}">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <input id="fecha_fin" name="fecha_fin" type="date" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_competencia->fecha_fin}}">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="cupos">Cupos de la Certificación</label>
                                <input id="cupos" name="cupos" type="number" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_competencia->cupos}}">
                            </div>
                            <div class="col-md-6">
                                <label for="municipio">Municipio de la oferta</label>
                                <select id="municipio" name="municipio" class="form-control" {{$editar ? '' : 'disabled'}}>
                                    <option selected disabled >Seleccione...</option>
                                    @foreach ($municipios as $municipio)
                                    <option value="{{$municipio->id}}" {{$oferta_competencia->municipios_id == $municipio->id ? 'selected' : ''}}>{{$municipio->nombre}}</option>
                                    @endforeach
                                </select> 
                            </div>                                  
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="competencia">Competencia de la oferta</label>
                                <select id="competencia" name="competencia" class="form-control" {{$editar ? '' : 'disabled'}}>
                                    <option selected disabled >Seleccione...</option>
                                    @foreach ($competencias as $competencia)
                                        <option value="{{$competencia->id}}" {{$oferta_competencia->competencias_centro->competencias_id == $competencia->id ? 'selected' : ''}}>{{$competencia->nombre}}</option>
                                    @endforeach
                                </select> 
                            </div>  
                            @if(tiene_rol(1))
                                <div class="col-md-6">
                                    <label for="centro">Centro de Oferta</label>
                                    <select id="centro" name="centro" class="form-control" {{$editar ? '' : 'disabled'}}>
                                        <option selected disabled >Seleccione...</option>
                                        @foreach ($centros as $centro)
                                            <option value="{{$centro->id}}" {{$oferta_competencia->competencias_centro->centros_id == $centro->id ? 'selected' : ''}}>
                                                {{$centro->nombre}}
                                            </option>
                                        @endforeach
                                    </select> 
                                </div>                                 
                            @endif                  
                        </div>

                        @if(!$editar)
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="funcionario">Funcionario que registro: </label>
                                    <input id="funcionario" name="funcionario" type="text" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_competencia->registrado_por->nombre_completo()}}">
                                </div>
                                @if(isset($oferta_competencia->actualizado_por))
                                <div class="col-md-6">
                                    <label for="funcionario">Funcionario que actualizo: </label>
                                    <input id="funcionario" name="funcionario" type="text" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_competencia->actualizado_por->nombre_completo()}}">
                                </div>
                                @endif
                            </div>
                        @endif
                        <div id="form_ofertas_competencias_errors" class="row"></div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        @if($editar)
                            <button id="btn_editar_oferta_competencia" class="btn btn-primary">Actualizar</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                        @else
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                        @endif
                    </div> 
                </form>   
                @endif        
        </div>
    </div>
</div>