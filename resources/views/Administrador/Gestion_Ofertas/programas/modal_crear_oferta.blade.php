<!-- Modal -->
<div id="modal_crear_oferta_programa" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">        
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">Creación de Oferta para Programas de Formación</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_crear_oferta_programa" onsubmit="crearOfertaDePrograma()" autocomplete="off">           
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
                                <label for="modalidad">Modalidad</label>
                                <select id="modalidad" name="modalidad" type="number" class="form-control" onchange="validarModalidadOfertaPrograma('form_crear_oferta_programa', 'modalidad', 'municipio_container')">
                                    <option selected disabled >Seleccione</option>
                                    <option value="PRESENCIAL">PRESENCIAL</option>
                                    <option value="VIRTUAL">VIRTUAL</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="mes_inicio">Mes de Inicio</label>
                                <select id="mes_inicio" name="mes_inicio" class="form-control">
                                    <option selected disabled >Seleccione</option>
                                    <option value="0">ENERO</option>
                                    <option value="1">FEBRERO</option>
                                    <option value="2">MARZO</option>
                                    <option value="3">ABRIL</option>
                                    <option value="4">MAYO</option>
                                    <option value="5">JUNIO</option>
                                    <option value="6">JULIO</option>
                                    <option value="7">AGOSTO</option>
                                    <option value="8">SEPTIEMBRE</option>
                                    <option value="9">OCTUBRE</option>
                                    <option value="10">NOVIEMBRE</option>
                                    <option value="11">DICIEMBRE</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="anho_fin">Año de Finalización</label>
                                <input id="anho_fin" name="anho_fin" type="number" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="vigencia">Vigencia del Programa</label>
                                <input id="vigencia" name="vigencia" type="number" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="cursos">Cursos del Programa</label>
                                <input id="cursos" name="cursos" type="number" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="cupos">Cupos del Programa</label>
                                <input id="cupos" name="cupos" type="number" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row form-group">                                               
                            <div class="col-md-6">
                                <label for="programa">Programa de la oferta</label>
                                <select id="programa" name="programa" class="form-control">
                                    <option selected disabled >Seleccione...</option>
                                    @foreach ($programas as $programa)
                                        <option value="{{$programa->id}}">{{$programa->nombre . " " . $programa->version}}</option>
                                    @endforeach
                                </select> 
                            </div>  
                            
                            <div class="col-md-6">
                                <label for="programa_especial">Programa Especial</label>
                                <select id="programa_especial" name="programa_especial" class="form-control">
                                    <option selected disabled >Seleccione...</option>
                                    <option value="NINGUNO">NINGUNO</option>
                                    <option value="INTEGRACION CON LA EDUCACION MEDIA TECNICA">INTEGRACIÓN CON LA EDUCACIÓN MEDIA TÉCNICA</option>
                                    <option value="ATENCION A INSTITUCIONES">ATENCIÓN A INSTITUCIONES</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">                                               
                            <div class="col-md-6">
                                <label for="tipo_oferta">Tipo de Oferta</label>
                                <select id="tipo_oferta" name="tipo_oferta" class="form-control">
                                    <option selected disabled >Seleccione...</option>
                                    <option value="ABIERTA DE FORMACION">ABIERTA DE FORMACIÓN</option>
                                    <option value="ESPECIAL EMPRESARIAL">ESPECIAL EMPRESARIAL</option>
                                    <option value="ESPECIAL SOCIAL">ESPECIAL SOCIAL</option>
                                </select> 
                            </div>  
                        </div>

                        <div class="row form-group">
                            <div id="municipio_container" class="col-md-6">
                                <label for="municipio">Municipio de la oferta</label>
                                <select id="municipio" name="municipio" class="form-control">
                                    <option selected disabled >Seleccione...</option>
                                    @foreach ($municipios as $municipio)
                                        <option value="{{$municipio->id}}">{{$municipio->nombre}}</option>
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
                        <div id="form_ofertas_programas_errors" class="row"></div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn_crear_oferta_programa" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                    </div> 
                </form>           
        </div>
    </div>
</div>