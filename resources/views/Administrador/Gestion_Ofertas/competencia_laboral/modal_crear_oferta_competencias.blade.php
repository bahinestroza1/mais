<!-- Modal -->
<div id="modal_crear_oferta_competencia" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">        
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Creación de Oferta para Competencia Laboral</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_crear_oferta_competencia" onsubmit="crearOfertaDeCompetencia()" autocomplete="off">     
                <div class="modal-body">     
                        {{ csrf_field() }}
                        <div class="container">
                            <div class="row">
                                <p>Tener en cuenta que debes diligenciar todos los campos.</p>
                            </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="trimestre">Trimestre</label>
                                <select id="trimestre" name="trimestre" class="form-control">
                                    <option selected disabled >Seleccione</option>
                                    @foreach ($trimestres as $trimestre)
                                        <option value="{{$trimestre->id}}">
                                            {{$trimestre->numero."-".$trimestre->vigencia . " ( " . $trimestre->fecha_inicio ." / " . $trimestre->fecha_fin . " )" }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="duracion">Duración <span style="font-size: 14px; font-weight: normal; ">(Meses)</span></label>
                                <input id="duracion" name="duracion" type="number" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="fecha_inicio">Fecha de Inicio</label>
                                <input id="fecha_inicio" name="fecha_inicio" type="date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="fecha_fin">Fecha de Fin</label>
                                <input id="fecha_fin" name="fecha_fin" type="date" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="cupos">Cupos de la Certificación</label>
                                <input id="cupos" name="cupos" type="number" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="municipio">Municipio de la oferta</label>
                                <select id="municipio" name="municipio" class="form-control">
                                    <option selected disabled >Seleccione...</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
                                    @endforeach
                                </select> 
                            </div>                                  
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="competencia">Competencia de la oferta</label>
                                <select id="competencia" name="competencia" class="form-control">
                                    <option selected disabled >Seleccione...</option>
                                    @foreach ($competencias as $competencia)
                                        <option value="{{$competencia->id}}">{{$competencia->nombre}}</option>
                                    @endforeach
                                </select> 
                            </div>  
                            @if(tiene_rol(1))
                                <div class="col-md-6">
                                    <label for="centro">Centro de Oferta</label>
                                    <select id="centro" name="centro" class="form-control">
                                        <option selected disabled >Seleccione...</option>
                                        @foreach ($centros as $centro)
                                            <option value="{{$centro->id}}">{{$centro->nombre}}</option>
                                        @endforeach
                                    </select> 
                                </div>                                 
                            @endif                  
                        </div>

                        <div id="form_ofertas_competencias_errors" class="row"></div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_crear_oferta_competencia" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    </div> 
                </form>           
        </div>
    </div>
</div>