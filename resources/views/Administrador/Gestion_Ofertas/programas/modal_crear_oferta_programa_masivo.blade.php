<!-- Modal -->
<div id="modal_crear_oferta_programa_masivo" class="modal fade mt-5 pt-5 rounded" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header bg-dark">
                    <h4 class="modal-title ">ADJUNTE EL ARCHIVO .Xlsx</h4>
                    <button type="button" class="close" style="color: #FFF;" data-dismiss="modal">&times;</button>
                </div>
            <form id="form_carga_masiva_oferta_programas" method="POST" action="{{route('carga_masiva_oferta_programas')}}"
                enctype="multipart/form-data" autocomplete="off">
            <div class="modal-body">
                @if (Session::has('message'))
                    <div class="row justify-content-center">
                        <div class="{{ Session::get('class') }} col-md-12">
                            {{ Session::get('message') }}
                        </div>
                    </div>
                @endif
                <h1 class="text-center">Carga masiva de oferta</h1>
                <p class="text-center">Recuerde que debe adjuntar el archivo de reporte descargado de la aplicación <b>INDICATIVA</b></p>
                {{ csrf_field() }}
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input border" id="customFile"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        onchange="change_custom_file(this, '#file_carga_masiva')";
                        >
                    <label id="file_carga_masiva" class="custom-file-label" for="customFile">ADJUNTAR ARCHIVO</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success mx-auto w-50 font-weight-bold" onclick="closeModalOfertaProgramaMasivo()">CARGAR</button>
                </form>
                <!-- <a class="btn btn-primary mx-auto w-25" style="color: white;"
                target="_blank"
                href="{{route('plantilla_carga_masiva_usuarios')}}">
                    <i class="fas fa-file-download" style="color: #F9F9F9;"></i> Formato
                </a> -->
            </div>
        </div>

    </div>
</div>