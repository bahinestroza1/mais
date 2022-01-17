const SERVER_URL = 'http://localhost/proyectos/Appmunicipios/public/'

$('.pagination a').on('click', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');

    $.get(url, $('#form_filtrar').serialize(), function (data) {
        $('#tabla').html(data);
    });
});

function change_custom_file(input, idLabel) {
    $(idLabel).html(input.files[0].name);
}

// Gestion de MUNICIPIOS
function filtrarMunicipio(event) {
    event.preventDefault();
    // Validaciones
    const codigoMunicipio = $('#filtro_codigo').val();
    const nombreMunicipio = $('#filtro_nombre').val()

    if (codigoMunicipio != "" && isNaN(codigoMunicipio)) {
        swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'El código del municipio debe ser un número.',
            confirmButtonText: 'Aceptar',
        });
        return;
    }

    if (nombreMunicipio != "") {
        const pattern = /^[A-Za-z ]+$/;
        if (!pattern.test(nombreMunicipio)) {
            swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'El nombre del municipio no debe contener números.',
                confirmButtonText: 'Aceptar',
            });
            return;
        }
    }

    let url = `${SERVER_URL}admon/gestion_municipios`;
    let datos = $('#form_filtrar').serialize();

    $.ajax({
        url,
        method: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        xhrFields: { withCredentials: true },
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        $('#tabla').html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        swal.fire({
            icon: 'error',
            title: 'Error!',
            text: textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText,
            confirmButtonText: 'Aceptar',
        });

        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalEditarMunicipio(idMunicipio) {
    event.preventDefault();
    $(`#btn_municipios_${idMunicipio}`).prop('disabled', true);
    let url = `${SERVER_URL}admon/gestion_municipios`
    $.ajax({
        url,
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            idMunicipio
        },
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#editar_municipio_modal_container").html(msg);
        $('#modal_editar_municipio').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);

    }).always(function () {
        $(`#btn_municipios_${idMunicipio}`).prop('disabled', false)
    });
}

// Gestion de USUARIOS
function filtrarUsuarios() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_usuarios`;
    let datos = $('#form_filtrar').serialize();

    const documentoUsuario = $('#filtro_documento').val();

    if (documentoUsuario != "" && isNaN(documentoUsuario)) {
        swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'El número de documento debe ser un número.',
            confirmButtonText: 'Aceptar',
        });
        return;
    }

    $.ajax({
        url,
        method: "GET",
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        $("#tabla").html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalUsuario(tipo, idUsuario) {
    event.preventDefault();
    $(`#btn_usuarios_${idUsuario}`).prop('disabled', true);

    let url = `${SERVER_URL}admon/gestion_usuarios`

    $.ajax({
        url,
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            idUsuario,
            tipo
        },
        datatype: "json"

    }).done(function (msg) {
        $(`#btn_usuarios_${idUsuario}`).prop('disabled', false);
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#usuario_modal_container").html(msg);

        $('#modal_usuario').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        $(`#btn_usuarios_${idUsuario}`).prop('disabled', false);
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function editarUsuario() {
    event.preventDefault();
    swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        text: 'El usuario se actualizara en el sistema.',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_editar_usuario`).prop('disabled', true);
            const errors = validarCreacionUsuario();
            if (Object.keys(errors).length > 0) {
                Object.values(errors).forEach(error => {
                    $(`#${error[0]}`).addClass('is-invalid');
                    $(`#validation_${error[0]}`).html(error[1]);
                });
                $(`#btn_editar_usuario`).prop('disabled', false);
                return;
            }

            let url = `${SERVER_URL}admon/gestion_usuarios/editar`;
            let datos = $('#form_editar_usuario').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_usuarios_errors').html(errors);
                    return;
                }

                data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarUsuarios()
                        $('#modal_usuario').modal('hide');
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(function () {
                $(`#btn_editar_usuario`).prop('disabled', false);
            });
        }
    })
}

function eliminarUsuario(idUsuario) {
    event.preventDefault();
    swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        text: 'El usuario se eliminara del sistema.',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            let url = `${SERVER_URL}/admon/gestion_usuarios/delete`;

            $.ajax({
                url,
                method: "POST",
                data: { idUsuario },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                datatype: "json"
            }).done(response => {
                if (typeof response == "object") {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: response[0]
                    });
                    return;
                }

                swal.fire({
                    icon: 'success',
                    title: 'Correcto!',
                    confirmButtonText: 'Aceptar',
                    text: response
                }).then(() => {
                    window.location.reload();
                });

            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            });
        }
    });
}

function cargarModalCrearUsuario() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_usuarios/crear`

    $.ajax({
        url,
        method: "GET",
        datatype: "json"
    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_usuario_modal_container").html(msg);

        $('#modal_crear_usuario').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function crearUsuario(event) {
    event.preventDefault();
    swal.fire({
        icon: 'question',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Crear Usuario',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_crear_usuario`).prop('disabled', true);
            const errors = validarCreacionUsuario();

            if (Object.keys(errors).length > 0) {
                Object.values(errors).forEach(error => {
                    $(`#${error[0]}`).addClass('is-invalid');
                    $(`#validation_${error[0]}`).html(error[1]);
                });
                $(`#btn_crear_usuario`).prop('disabled', false);
                return;
            }

            let url = `${SERVER_URL}admon/gestion_usuarios/crear`;
            let datos = $('#form_crear_usuario').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_usuarios_errors').html(errors);
                    return;
                }

                data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarUsuarios()
                        $('#modal_crear_usuario').modal('hide');
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_crear_usuario`).prop('disabled', false));
        }
    })
}


function cargarModalCrearUsuarioMasivo() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_usuarios/carga_masiva`

    $.ajax({
        url,
        method: "GET",
        datatype: "json"
    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_usuario_masivo_modal_container").html(msg);

        $('#modal_crear_usuario_masivo').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function closeModalCargaMasivaUsuarios() {
    $('#modal_crear_usuario_masivo').modal('hide');
}

// Gestion de FUNCIONARIOS
function filtrarFuncionarios() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_funcionarios`;
    let datos = $('#form_filtrar').serialize();

    const documentoFuncionario = $('#filtro_documento').val();

    if (documentoFuncionario != "" && isNaN(documentoFuncionario)) {
        swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'El número de documento debe ser un número.',
            confirmButtonText: 'Aceptar',
        });
        return;
    }

    $.ajax({
        url,
        method: "GET",
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        $("#tabla").html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalFuncionario(tipo, idFuncionario) {
    event.preventDefault();
    $(`#btn_funcionarios_${idFuncionario}`).prop('disabled', true);

    let url = `${SERVER_URL}admon/gestion_funcionarios`

    $.ajax({
        url,
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            idFuncionario,
            tipo
        },
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#funcionario_modal_container").html(msg);

        $('#modal_funcionario').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    }).always(() => $(`#btn_funcionarios_${idFuncionario}`).prop('disabled', false));
}

function cargarModalCrearFuncionario() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_funcionarios/crear`

    $.ajax({
        url,
        method: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        datatype: "json"
    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_funcionario_modal_container").html(msg);

        $('#modal_crear_funcionario').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function crearFuncionario() {
    event.preventDefault();
    swal.fire({
        icon: 'question',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Crear Funcionario',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_crear_funcionario`).prop('disabled', true);

            const errors = validarCreacionFuncionario();
            if (Object.keys(errors).length > 0) {
                console.log("Aqui")
                Object.values(errors).forEach(error => {
                    $(`#${error[0]}`).addClass('is-invalid');
                    $(`#validation_${error[0]}`).html(error[1]);
                });
                $(`#btn_crear_funcionario`).prop('disabled', false);
                return;
            }

            let url = `${SERVER_URL}admon/gestion_funcionarios/crear`;
            let datos = $('#form_crear_funcionario').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                console.log(response)
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_funcionarios_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarFuncionarios()
                        $('#modal_crear_funcionario').modal('hide');
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_crear_funcionario`).prop('disabled', false));
        }
    })
}

function editarFuncionario() {
    event.preventDefault();
    swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_editar_funcionario`).prop('disabled', true);

            const errors = validarCreacionFuncionario();
            if (Object.keys(errors).length > 0) {
                Object.values(errors).forEach(error => {
                    $(`#${error[0]}`).addClass('is-invalid');
                    $(`#validation_${error[0]}`).html(error[1]);
                });
                $(`#btn_editar_funcionario`).prop('disabled', false);
                return;
            }

            let url = `${SERVER_URL}admon/gestion_funcionarios/editar`;
            let datos = $('#form_editar_funcionario').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_funcionarios_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarFuncionarios()
                        $('#modal_funcionario').modal('hide');
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(function () {
                $(`#btn_editar_funcionario`).prop('disabled', false);
            });
        }
    })
}

function eliminarFuncionario(idFuncionario) {
    event.preventDefault();
    swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        text: 'El funcionario se eliminara del sistema.',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            let url = `${SERVER_URL}/admon/gestion_funcionarios/delete`;

            $.ajax({
                url,
                method: "POST",
                data: { idFuncionario },
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                datatype: "json"
            }).done(response => {
                if (typeof response == "object") {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: response[0]
                    });
                    return;
                }

                swal.fire({
                    icon: 'success',
                    title: 'Correcto!',
                    confirmButtonText: 'Aceptar',
                    text: response
                }).then(() => {
                    window.location.reload();
                });

            }).fail(function (jqXHR, textStatus) {
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            });
        }
    });
}

// Gestión de PROGRAMAS
function filtrarProgramas() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_programas`;
    let datos = $('#form_filtrar').serialize();

    $.ajax({
        url,
        method: "GET",
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        $("#tabla").html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalCrearPrograma() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_programas/crear`

    $.ajax({
        url,
        method: "GET",
        datatype: "json"
    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_programa_modal_container").html(msg);

        $('#modal_crear_programa').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR.responseText);
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function crearProgramaDeFormacion() {
    event.preventDefault();
    swal.fire({
        icon: 'question',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Crear Programa',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_crear_programa`).prop('disabled', true);

            const errors = validarCreacionPrograma();
            if (Object.keys(errors).length > 0) {
                Object.values(errors).forEach(error => {
                    $(`#${error[0]}`).addClass('is-invalid');
                    $(`#validation_${error[0]}`).html(error[1]);
                });
                $(`#btn_crear_programa`).prop('disabled', false);
                return;
            }

            let url = `${SERVER_URL}admon/gestion_programas/crear`;
            let datos = $('#form_crear_programa').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_programas_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarProgramas();
                        $('#modal_crear_programa').modal('hide');
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_crear_programa`).prop('disabled', false));
        }
    })
}

function cargarModalPrograma(idPrograma) {
    event.preventDefault();
    $(`#btn_programas_${idPrograma}`).prop('disabled', true);
    let url = `${SERVER_URL}admon/gestion_programas`
    $.ajax({
        url,
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            idPrograma
        },
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#editar_programa_modal_container").html(msg);

        $('#modal_editar_programa').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    }).always(function () {
        $(`#btn_programas_${idPrograma}`).prop('disabled', false);
    });
}

function editarPrograma() {
    event.preventDefault();
    swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_editar_programa`).prop('disabled', true);

            const errors = validarCreacionPrograma();
            if (Object.keys(errors).length > 0) {
                Object.values(errors).forEach(error => {
                    $(`#${error[0]}`).addClass('is-invalid');
                    $(`#validation_${error[0]}`).html(error[1]);
                });
                $(`#btn_editar_programa`).prop('disabled', false);
                return;
            }

            let url = `${SERVER_URL}admon/gestion_programas/editar`;
            let datos = $('#form_editar_programa').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_programas_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarProgramas();
                        $('#modal_editar_programa').modal('hide');
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_editar_programa`).prop('disabled', false));
        }
    })
}

// Gestión de Oferta

function filtrarOfertaProgramas() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_ofertas`;
    let datos = $('#contenedor_oferta_programa  #form_filtrar').serialize();

    $.ajax({
        url,
        method: "GET",
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        $('#contenedor_oferta_programa  #tabla').html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalCrearOfertaPrograma() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_ofertas/crear`

    $.ajax({
        url,
        method: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        datatype: "json"
    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_oferta_programa_modal_container").html(msg);

        $('#modal_crear_oferta_programa').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function crearOfertaDePrograma() {
    event.preventDefault();
    swal.fire({
        icon: 'question',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Crear Oferta de Formación',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_crear_oferta_programa`).prop('disabled', true);
            let url = `${SERVER_URL}admon/gestion_ofertas/crear`;
            let datos = $('#form_crear_oferta_programa').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_ofertas_programas_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarOfertaProgramas();
                        $('#modal_crear_oferta_programa').modal('hide');
                        //window.location.reload();
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_crear_oferta_programa`).prop('disabled', false));
        }
    })
}

function validarModalidadOfertaPrograma(form, type, municipio) {
    console.log($(`#${form} #${type}`).val());
    if ($(`#${form} #${type}`).val() == "VIRTUAL") {
        console.log(("Es virtual"))
        $(`#${municipio}`).hide();
        $(`#${municipio.split('_'[0])}`).prop('disabled', true);
    } else {
        console.log(("Es presencial"))
        $(`#${municipio}`).show();
        $(`#${municipio.split('_'[0])}`).prop('disabled', false);
    }

}

function cargarModalOfertaProgramaMasivo() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_ofertas/carga_masiva`

    $.ajax({
        url,
        method: "GET",
        datatype: "json"
    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_oferta_programa_masivo_modal_container").html(msg);

        $('#modal_crear_oferta_programa_masivo').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function closeModalOfertaProgramaMasivo() {
    $('#modal_crear_oferta_programa_masivo').modal('hide');
}

function cargarModalOfertaPrograma(editar, idOfertaPrograma) {
    event.preventDefault();
    $(`#btn_oferta_programa_${idOfertaPrograma}`).prop('disabled', true);

    let url = `${SERVER_URL}admon/gestion_ofertas`

    $.ajax({
        url,
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: {
            idOfertaPrograma,
            editar
        },
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#oferta_programa_modal_container").html(msg);

        $('#modal_oferta_programa').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    }).always(function () {
        $(`#btn_oferta_programa_${idOfertaPrograma}`).prop('disabled', false);
    });
}

function editarOfertaDePrograma() {
    event.preventDefault();
    swal.fire({
        icon: 'warning',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Aceptar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_editar_oferta_programa`).prop('disabled', true);

            // const errors = validarCreacionOfertaPrograma();
            // if (Object.keys(errors).length > 0) {
            //     Object.values(errors).forEach(error => {
            //         $(`#${error[0]}`).addClass('is-invalid');
            //         $(`#validation_${error[0]}`).html(error[1]);
            //     });
            //     $(`#btn_editar_oferta_programa`).prop('disabled', false);
            //     return;
            // }

            let url = `${SERVER_URL}admon/gestion_ofertas/editar`;
            let datos = $('#form_editar_oferta_programa').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_oferta_programa_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        window.location.reload()
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_editar_oferta_programa`).prop('disabled', false));
        }
    })
}

function filtrarOfertaCompetencias() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_ofertas/buscarCompetencia`;
    let datos = $('#form_filtrar_oferta_competencias').serialize();

    $.ajax({
        url,
        method: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        console.log(msg)
        $("#tabla_ofertas_competencias").html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalCrearOfertaCompetencia() {
    event.preventDefault();
    let url = `${SERVER_URL}admon/gestion_ofertas/crearCompetencia`

    $.ajax({
        url,
        method: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        datatype: "json"
    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_oferta_competencias_modal_container").html(msg);

        $('#modal_crear_oferta_competencia').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function crearOfertaDeCompetencia() {
    event.preventDefault();
    swal.fire({
        icon: 'question',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Crear Oferta',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_crear_oferta_competencia`).prop('disabled', true);
            let url = `${SERVER_URL}admon/gestion_ofertas/crearCompetencia`;
            let datos = $('#form_crear_oferta_competencia').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                console.log(response)
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_ofertas_competencias_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        filtrarOfertaCompetencias();
                        $('#modal_crear_oferta_competencia').modal('hide');
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_crear_oferta_competencia`).prop('disabled', false));
        }
    })
}

/**
 * Servicios
 */

function filtrarOfertaPrograma() {
    event.preventDefault();
    let url = `${SERVER_URL}servicios/ofertas`;
    let datos = $('#form_filtrar').serialize();

    $.ajax({
        url,
        method: "GET",
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        $("#tabla").html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalVerOfertaPrograma(idOfertaPrograma) {
    event.preventDefault();
    $(`#btn_ver_oferta_programa_${idOfertaPrograma}`).prop('disabled', true);

    let url = `${SERVER_URL}servicios/ofertas`

    $.ajax({
        url,
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idOfertaPrograma },
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#ver_oferta_programa_modal_container").html(msg);

        $('#modal_ver_oferta_programa').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    }).always(function () {
        $(`#btn_ver_oferta_programa_${idOfertaPrograma}`).prop('disabled', false);
    });
}


function filtrarSolicitudes() {
    event.preventDefault();
    let url = `${SERVER_URL}servicios/solicitudes`;
    let datos = $('#form_filtrar_solicitudes').serialize();

    $.ajax({
        url,
        method: "GET",
        data: datos,
        datatype: "json"
    }).done(function (msg) {
        $("body").html(msg);
    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function cargarModalCrearSolicitud() {
    event.preventDefault();
    let url = `${SERVER_URL}servicios/solicitudes/crear`

    $.ajax({
        url,
        method: "GET",
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#crear_solicitud_modal_container").html(msg);

        $('#modal_crear_solicitud').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR.responseText)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    });
}

function onChangeCrearSolicitud() {
    $('#container_solicitud').children().each((index, tipo) => {
        $(tipo).hide();
        $(tipo).prop('disabled', true);
    });

    $(`#container_solicitud_${$("#tipo_solicitud").val()}`).show();
    $(tipo).prop('disabled', false);
}

function crearSolicitud() {
    event.preventDefault();
    swal.fire({
        icon: 'question',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Crear Solicitud',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_crear_solicitud`).prop('disabled', true);
            let url = `${SERVER_URL}servicios/solicitudes/crear`;
            let datos = $('#form_crear_solicitud').serialize();

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: datos,
                datatype: "json"

            }).done(response => {
                if (Array.isArray(response)) {
                    let errors = '<div class="alert alert-danger">';
                    response.forEach(error => {
                        errors += `<p class="m-0">${error}</p>`;
                    });
                    errors += '</div>';

                    $('#form_crear_solicitud_errors').html(errors);
                    return;
                }

                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        // filtrarSolicitudes();
                        // $('#modal_crear_solicitud').modal('hide');
                        //window.location.reload();
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_crear_solicitud`).prop('disabled', false));
        }
    })
}

function cargarModalVerSolicitud(idSolicitud) {
    event.preventDefault();
    $(`#btn_ver_solicitud_${idSolicitud}`).prop('disabled', true);

    let url = `${SERVER_URL}servicios/solicitudes`

    $.ajax({
        url,
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idSolicitud },
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
        console.log("Aqu")

        $("#ver_solicitud_modal_container").html(msg);

        $('#modal_ver_solicitud').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    }).always(function () {
        $(`#btn_ver_solicitud_${idSolicitud}`).prop('disabled', false);
    });
}

function cargarModalTomarSolicitudOfertaPrograma(idSolicitud) {
    event.preventDefault();
    $(`#btn_tomar_solicitud_programa_${idSolicitud}`).prop('disabled', true);

    let url = `${SERVER_URL}servicios/solicitudes/tomar`

    $.ajax({
        url,
        method: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idSolicitud },
        datatype: "json"

    }).done(function (msg) {
        if ($('.modal-backdrop').is(':visible')) {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }

        $("#tomar_solicitud_modal_container").html(msg);

        $('#modal_tomar_solicitud').modal('toggle');

    }).fail(function (jqXHR, textStatus) {
        console.log(jqXHR)
        console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
    }).always(function () {
        $(`#btn_ver_solicitud_${idSolicitud}`).prop('disabled', false);
    });
}

function tomarSolicitud(idSolicitud, idOferta = null) {
    event.preventDefault();
    swal.fire({
        icon: 'question',
        title: '¿Estás seguro?',
        showConfirmButton: true,
        confirmButtonText: 'Asignar Solicitud',
        showCancelButton: true,
        cancelButtonText: 'Cancelar'
    }).then(({ isConfirmed }) => {
        if (isConfirmed) {
            $(`#btn_asignar_solicitud_${idSolicitud}`).prop('disabled', true);
            let url = `${SERVER_URL}servicios/solicitudes/tomar`;

            $.ajax({
                url,
                method: "POST",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    idSolicitud,
                    idOferta
                },
                datatype: "json"

            }).done(response => {
                let data = JSON.parse(response);

                if (data.type == 'error') {
                    swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    })
                } else {
                    swal.fire({
                        icon: 'success',
                        title: 'Correcto!',
                        confirmButtonText: 'Aceptar',
                        text: data.message
                    }).then(() => {
                        window.location.reload();
                    });
                }

            }).fail(function (jqXHR, textStatus) {
                console.log(jqXHR)
                console.log(textStatus + ": " + jqXHR.status + " - " + jqXHR.statusText);
            }).always(() => $(`#btn_asignar_solicitud_${idSolicitud}`).prop('disabled', false));
        }
    })
}
