<!-- Modal -->
<div id="modal_oferta_programa" class="modal fade mt-0 mb-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog" style="max-width: 50%!important;">
        <!-- Modal content-->
        <div class="modal-content">
            @if(isset($oferta_programa))
                <div class="modal-header bg-dark">
                    <h4 class="modal-title ">{{$editar == true ? 'Editar' : 'Ver'}} Oferta de Programa de Formación</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
                <form id="form_editar_oferta_programa" onsubmit="editarOfertaDePrograma()" autocomplete="off">     
                <input type="hidden" id="id" name="id" value="{{$oferta_programa->id}}">      
                <div class="modal-body">     
                        {{ csrf_field() }}
                    <div class="container">
                        <div id="pruebajeje"></div>
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
                                        <option value="{{$trimestre->id}}" {{$oferta_programa->trimestres_id == $trimestre->id ? 'selected' : ''}}>
                                            {{$trimestre->numero."-".$trimestre->vigencia . " ( " . $trimestre->fecha_inicio ." / " . $trimestre->fecha_fin . " )" }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="municipio_container" class="col-md-6">
                                <label for="modalidad">Modalidad</label>
                                <select id="modalidad" name="modalidad" type="number" class="form-control" {{$editar ? '' : 'disabled'}} onchange="validarModalidadOfertaPrograma('form_editar_oferta_programa', 'modalidad', 'municipio_container')">
                                    <option disabled >Seleccione</option>
                                    <option value="PRESENCIAL" {{$oferta_programa->modalidad == 'PRESENCIAL' ? 'selected' : ''}}>PRESENCIAL</option>
                                    <option value="VIRTUAL" {{$oferta_programa->modalidad == 'VIRTUAL' ? 'selected' : ''}}>VIRTUAL</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="mes_inicio">Mes de Inicio</label>
                                <select id="mes_inicio" name="mes_inicio" class="form-control" {{$editar ? '' : 'disabled'}}>
                                    <option selected disabled >Seleccione</option>
                                    <option value="0" {{$oferta_programa->mes_inicio == 0 ? 'selected' : ''}}>ENERO</option>
                                    <option value="1" {{$oferta_programa->mes_inicio == 1 ? 'selected' : ''}}>FEBRERO</option>
                                    <option value="2" {{$oferta_programa->mes_inicio == 2 ? 'selected' : ''}}>MARZO</option>
                                    <option value="3" {{$oferta_programa->mes_inicio == 3 ? 'selected' : ''}}>ABRIL</option>
                                    <option value="4" {{$oferta_programa->mes_inicio == 4 ? 'selected' : ''}}>MAYO</option>
                                    <option value="5" {{$oferta_programa->mes_inicio == 5 ? 'selected' : ''}}>JUNIO</option>
                                    <option value="6" {{$oferta_programa->mes_inicio == 6 ? 'selected' : ''}}>JULIO</option>
                                    <option value="7" {{$oferta_programa->mes_inicio == 7 ? 'selected' : ''}}>AGOSTO</option>
                                    <option value="8" {{$oferta_programa->mes_inicio == 8 ? 'selected' : ''}}>SEPTIEMBRE</option>
                                    <option value="9" {{$oferta_programa->mes_inicio == 9 ? 'selected' : ''}}>OCTUBRE</option>
                                    <option value="10" {{$oferta_programa->mes_inicio == 10 ? 'selected' : ''}}>NOVIEMBRE</option>
                                    <option value="11" {{$oferta_programa->mes_inicio == 11 ? 'selected' : ''}}>DICIEMBRE</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="anho_fin">Año de Finalización</label>
                                <input id="anho_fin" name="anho_fin" type="number" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_programa->anho_fin}}">
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div class="col-md-6">
                                <label for="vigencia">Vigencia del Programa</label>
                                <input id="vigencia" name="vigencia" type="number" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_programa->vigencia}}">
                            </div>
                            <div class="col-md-3">
                                <label for="cursos">Cursos del Programa</label>
                                <input id="cursos" name="cursos" type="number" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_programa->nro_grupos}}">
                            </div>
                            <div class="col-md-3">
                                <label for="cupos">Cupos del Programa</label>
                                <input id="cupos" name="cupos" type="number" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_programa->cupos}}">
                            </div>
                        </div>
                        
                        <div class="row form-group">                                               
                            <div class="{{$editar ? 'col-md-6' : 'col-md-8'}}">
                                <label for="programa">Programa de la oferta</label>
                                <select id="programa" name="programa" class="form-control" {{$editar ? '' : 'disabled'}}>
                                    <option selected disabled >Seleccione...</option>
                                    @foreach ($programas as $programa)
                                        <option value="{{$programa->id}}" {{$oferta_programa->programas_centro->programas_id == $programa->id ? 'selected' : ''}}>{{$programa->nombre . " " . $programa->version}}</option>
                                    @endforeach
                                </select> 
                            </div>  
                            
                            <div class="{{$editar ? 'col-md-6' : 'col-md-4'}}">
                                <label for="programa_especial">Programa Especial</label>
                                <select id="programa_especial" name="programa_especial" class="form-control" {{$editar ? '' : 'disabled'}}>
                                    <option selected disabled >Seleccione...</option>
                                    <option value="NINGUNO" {{$oferta_programa->programa_especial == 'NINGUNO' ? 'selected' : ''}}>NINGUNO</option>
                                    <option value="INTEGRACION CON LA EDUCACION MEDIA TECNICA" {{$oferta_programa->programa_especial == 'INTEGRACION CON LA EDUCACION MEDIA TECNICA' ? 'selected' : ''}}>INTEGRACIÓN CON LA EDUCACIÓN MEDIA TÉCNICA</option>
                                    <option value="ATENCION A INSTITUCIONES" {{$oferta_programa->programa_especial == 'ATENCION A INSTITUCIONES' ? 'selected' : ''}}>ATENCIÓN A INSTITUCIONES</option>
                                </select>
                            </div>
                        </div>

                        <div class="row form-group">                                               
                            <div class="col-md-6">
                                <label for="tipo_oferta">Tipo de Oferta</label>
                                <select id="tipo_oferta" name="tipo_oferta" class="form-control" {{$editar ? '' : 'disabled'}}>
                                    <option selected disabled >Seleccione...</option>
                                    <option value="ABIERTA DE FORMACION" {{$oferta_programa->tipo_oferta == 'ABIERTA DE FORMACION' ? 'selected' : ''}}>ABIERTA DE FORMACIÓN</option>
                                    <option value="ESPECIAL EMPRESARIAL" {{$oferta_programa->tipo_oferta == 'ESPECIAL EMPRESARIAL' ? 'selected' : ''}}>ESPECIAL EMPRESARIAL</option>
                                    <option value="ESPECIAL SOCIAL" {{$oferta_programa->tipo_oferta == 'ESPECIAL SOCIAL' ? 'selected' : ''}}>ESPECIAL SOCIAL</option>
                                </select> 
                            </div>  

                            @if($oferta_programa->modalidad == "PRESENCIAL")                            
                                <div id="municipio_container" class="col-md-6">
                                    <label for="municipio">Municipio de la oferta</label>
                                    <select id="municipio" name="municipio" class="form-control" {{$editar ? '' : 'disabled'}}>
                                        <option selected disabled >Seleccione...</option>
                                        @foreach ($municipios as $municipio)
                                        <option value="{{$municipio->id}}" {{$oferta_programa->municipios_id == $municipio->id ? 'selected' : ''}}>{{$municipio->nombre}}</option>
                                        @endforeach
                                    </select> 
                                </div> 
                            @endif
                        </div>

                        <div class="row form-group">
                            @if(tiene_rol(1))
                                <div class="col-md-12">
                                    <label for="centro">Centro de Oferta</label>
                                    <select id="centro" name="centro" class="form-control" {{$editar ? '' : 'disabled'}}>
                                        <option selected disabled >Seleccione...</option>
                                        @foreach ($centros as $centro)
                                            <option value="{{$centro->id}}" {{$oferta_programa->programas_centro->centros_id == $centro->id ? 'selected' : ''}}>
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
                                    <input id="funcionario" name="funcionario" type="text" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_programa->registrado_por->nombre_completo()}}">
                                </div>
                                @if(isset($oferta_programa->actualizado_por))
                                <div class="col-md-6">
                                    <label for="funcionario">Funcionario que actualizo: </label>
                                    <input id="funcionario" name="funcionario" type="text" class="form-control" {{$editar ? '' : 'disabled'}} value="{{$oferta_programa->actualizado_por->nombre_completo()}}">
                                </div>
                                @endif
                            </div>
                        @endif
                        <div id="form_oferta_programa_errors" class="row"></div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        @if($editar)
                            <button id="btn_editar_oferta_programa" class="btn btn-primary">Actualizar</button>
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