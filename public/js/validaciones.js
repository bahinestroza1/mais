/**
 * Función que valida los campos ingresados al momento de crear un USUARIO.
 * @return {array} errores
 * 
 */
function validarCreacionUsuario() {
    let errores = [];
    const tipo_documento = $("#tipo_documento").val();
    const documento = $("#documento").val();
    const nombres = $("#nombres").val();
    const apellidos = $("#apellidos").val();
    const email = $("#email").val();
    const telefono = $("#telefono").val();
    const municipio = $("#municipio").val();
    const cargo = $("#cargo").val();

    if (tipo_documento == null) {
        errores = [...errores, ["tipo_documento", "El campo TIPO DE DOCUMENTO es OBLIGATORIO"]];
    }

    if (documento == null || documento == "") {
        errores = [...errores, ["documento", "El campo DOCUMENTO es OBLIGATORIO"]];
    }

    if (nombres == null || nombres == "") {
        errores = [...errores, ["nombres", "El campo NOMBRES es OBLIGATORIO"]];
    } else {
        if (nombres.length > 50) {
            errores = [...errores, ["nombres", "El campo NOMBRES no debe contener más de 50 caracteres."]];
        }
    }

    if (apellidos == null || apellidos == "") {
        errores = [...errores, ["apellidos", "El campo APELLIDOS es OBLIGATORIO"]];
    } else {
        if (apellidos.length > 50) {
            errores = [...errores, ["apellidos", "El campo APELLIDOS no debe contener más de 50 caracteres."]];
        }
    }

    if (email == null || email == "") {
        errores = [...errores, ["email", "El campo CORREO ELECTRÓNICO es OBLIGATORIO"]];
    } else {
        if (email.length > 50) {
            errores = [...errores, ["email", "El campo CORREO ELECTRÓNICO no debe contener más de 50 caracteres."]];
        }
    }

    if (telefono) {
        if (telefono.length > 12) {
            errores = [...errores, ["telefono", "El campo TELÉFONO no debe contener más de 12 caracteres."]];
        }
        if (isNaN(telefono)) {
            errores = [...errores, ["telefono", "El campo TELÉFONO debe ser un número."]];
        }
    }

    if (municipio == null) {
        errores = [...errores, ["municipio", "El campo MUNICIPIO es OBLIGATORIO"]];
    }

    if (cargo == null || cargo == "") {
        errores = [...errores, ["cargo", "El campo CARGO es OBLIGATORIO"]];
    } else {
        if (cargo.length > 50) {
            errores = [...errores, ["cargo", "El campo CARGO no debe contener más de 50 caracteres."]];
        }
    }

    return errores;
}

/**
 * Función que valida los campos ingresados al momento de crear un FUNCIONARIO.
 * @return {array} errores
 * 
 */
function validarCreacionFuncionario() {
    let errores = [];
    const tipo_documento = $("#tipo_documento").val();
    const documento = $("#documento").val();
    const nombres = $("#nombres").val();
    const apellidos = $("#apellidos").val();
    const email = $("#email").val();
    const telefono = $("#telefono").val();
    const rol = $("#rol").val();

    if (tipo_documento == null) {
        errores = [...errores, ["tipo_documento", "El campo TIPO DE DOCUMENTO es OBLIGATORIO"]];
    }

    if (documento == null || documento == "") {
        errores = [...errores, ["documento", "El campo DOCUMENTO es OBLIGATORIO"]];
    }

    if (nombres == null || nombres == "") {
        errores = [...errores, ["nombres", "El campo NOMBRES es OBLIGATORIO"]];
    } else {
        if (nombres.length > 50) {
            errores = [...errores, ["nombres", "El campo NOMBRES no debe contener más de 50 caracteres."]];
        }
    }

    if (apellidos == null || apellidos == "") {
        errores = [...errores, ["apellidos", "El campo APELLIDOS es OBLIGATORIO"]];
    } else {
        if (apellidos.length > 50) {
            errores = [...errores, ["apellidos", "El campo APELLIDOS no debe contener más de 50 caracteres."]];
        }
    }

    if (email == null || email == "") {
        errores = [...errores, ["email", "El campo CORREO ELECTRÓNICO es OBLIGATORIO"]];
    } else {
        if (email.length > 50) {
            errores = [...errores, ["email", "El campo CORREO ELECTRÓNICO no debe contener más de 50 caracteres."]];
        }
    }

    if (telefono) {
        if (telefono.length > 12) {
            errores = [...errores, ["telefono", "El campo TELÉFONO no debe contener más de 12 caracteres."]];
        }
        if (isNaN(telefono)) {
            errores = [...errores, ["telefono", "El campo TELÉFONO debe ser un número."]];
        }
    }

    if (rol == null) {
        errores = [...errores, ["rol", "El campo ROL es OBLIGATORIO"]];
    }

    return errores;
}


/**
 * Función que valida los campos ingresados al momento de crear una OFERTA DE PROGRAMA.
 * @return {array} errores
 * 
 */
function validarCreacionOfertaPrograma() {
    let errores = [];
    const acronimo = $("#acronimo").val();
    const codigo = $("#codigo").val();
    const nombre = $("#nombre").val();
    const version = $("#version").val();
    const nivel_formacion = $("#nivel_formacion").val();

    if (acronimo == null || acronimo == "") {
        errores = [...errores, ["acronimo", "El campo ACRÓNIMO es OBLIGATORIO."]];
    } else {
        if (acronimo.length > 10) {
            errores = [...errores, ["acronimo", "El campo ACRÓNIMO no debe contener más de 10 caracteres."]];
        }
    }

    if (codigo == null || codigo == "") {
        errores = [...errores, ["codigo", "El campo CÓDIGO es OBLIGATORIO."]];
    } else {
        if (isNaN(codigo)) {
            errores = [...errores, ["codigo", "El campo CÓDIGO debe ser un número."]];
        }
    }

    if (nombre == null || nombre == "") {
        errores = [...errores, ["nombre", "El campo NOMBRE es OBLIGATORIO."]];
    } else {
        if (nombre.length > 50) {
            errores = [...errores, ["nombre", "El campo NOMBRE no debe contener más de 100 caracteres."]];
        }
    }

    if (version == null || version == "") {
        errores = [...errores, ["version", "El campo VERSIÓN es OBLIGATORIO."]];
    } else {
        if (isNaN(version)) {
            errores = [...errores, ["version", "El campo VERSIÓN debe ser un número."]];
        }
    }

    if (nivel_formacion == null) {
        errores = [...errores, ["nivel_formacion", "El campo NIVEL DE FORMACIÓN es OBLIGATORIO."]];
    }

    return errores;
}

/**
 * Función que valida los campos ingresados al momento de crear un PROGRAMA.
 * @return {array} errores
 * 
 */
function validarCreacionPrograma() {
    let errores = [];
    const acronimo = $("#acronimo").val();
    const codigo = $("#codigo").val();
    const nombre = $("#nombre").val();
    const version = $("#version").val();
    const nivel_formacion = $("#nivel_formacion").val();

    if (acronimo == null || acronimo == "") {
        errores = [...errores, ["acronimo", "El campo ACRÓNIMO es OBLIGATORIO."]];
    } else {
        if (acronimo.length > 10) {
            errores = [...errores, ["acronimo", "El campo ACRÓNIMO no debe contener más de 10 caracteres."]];
        }
    }

    if (codigo == null || codigo == "") {
        errores = [...errores, ["codigo", "El campo CÓDIGO es OBLIGATORIO."]];
    } else {
        if (isNaN(codigo)) {
            errores = [...errores, ["codigo", "El campo CÓDIGO debe ser un número."]];
        }
    }

    if (nombre == null || nombre == "") {
        errores = [...errores, ["nombre", "El campo NOMBRE es OBLIGATORIO."]];
    } else {
        if (nombre.length > 50) {
            errores = [...errores, ["nombre", "El campo NOMBRE no debe contener más de 100 caracteres."]];
        }
    }

    if (version == null || version == "") {
        errores = [...errores, ["version", "El campo VERSIÓN es OBLIGATORIO."]];
    } else {
        if (isNaN(version)) {
            errores = [...errores, ["version", "El campo VERSIÓN debe ser un número."]];
        }
    }

    if (nivel_formacion == null) {
        errores = [...errores, ["nivel_formacion", "El campo NIVEL DE FORMACIÓN es OBLIGATORIO."]];
    }

    return errores;
}


/**
 * Función que elimina clases de validaciones erróneas en formularios
 * @param {ElementNode} element 
 */
function removeValidation(element) {
    $(element).removeClass('is-invalid')
    $(`#validation_${element.id}`).html("");
}