/* FUNCION PARA PASAR LOS DATOS DE LA TABLA AL FORMULARIO AUTORES */
function editarAutor(id) {
    var celdas = document.getElementById(id).getElementsByTagName("td");

    // Verificar si el input haiden ya ha sido agregado
    var haidenInput = document.getElementById("id_old");
    if (!haidenInput) {
        // Si el input no ha sido agregado, agregarlo
        var newInput = '<input type="hidden" id="id_old" name="id_old">';
        document.getElementById("alta_autor").insertAdjacentHTML("beforeend", newInput);
    }

    // Asignar el valor del atributo "value" del input haiden
    document.getElementById("id_old").value = id;

    document.getElementById("nombre").value = celdas[1].innerHTML;
    document.getElementById("paterno").value = celdas[2].innerHTML;
    document.getElementById("materno").value = celdas[3].innerHTML;


    document.getElementById("alta_autor").action = "/dwp_2023_pf_bmanuel/autores/edit/"

    document.getElementById("btGuardar").style.display = "none";
    document.getElementById("btModificar").style.display = "inline-block";
}


/* FUNCION PARA PASAR LOS DATOS DE LA TABLA AL FORMULARIO DE USUARIOS */

function editarUsuario(claveUsu) {
    var celdas = document.getElementById(claveUsu).getElementsByTagName("td");

    // Verificar si el input haiden ya ha sido agregado
    var haidenInput = document.getElementById("ClaveUsu_old");
    if (!haidenInput) {
        // Si el input no ha sido agregado, agregarlo
        var newInput = '<input type="hidden" id="ClaveUsu_old" name="ClaveUsu_old">';
        document.getElementById("alta_usuario").insertAdjacentHTML("beforeend", newInput);
    }

    // Asignar el valor del atributo "value" del input haiden
    document.getElementById("ClaveUsu_old").value = claveUsu;

    document.getElementById("ClaveUsu").value = celdas[1].innerHTML;
    document.getElementById("nombre").value = celdas[2].innerHTML;
    document.getElementById("paterno").value = celdas[3].innerHTML;
    document.getElementById("materno").value = celdas[4].innerHTML;
    document.getElementById("colonia").value = celdas[5].innerHTML;
    document.getElementById("calle").value = celdas[6].innerHTML;
    document.getElementById("numero").value = celdas[7].innerHTML;
    document.getElementById("telefono").value = celdas[8].innerHTML;

    document.getElementById("alta_autor").action = "/dwp_2023_pf_bmanuel/usuarios/edit/"

    document.getElementById("btGuardar").style.display = "none";
    document.getElementById("btModificar").style.display = "inline-block";
}

/* FUNCION PARA PASAR LOS DATOS DE LA TABLA AL FORMULARIO DE EDITORIALES */

function editarEditorial(id) {
    var celdas = document.getElementById(id).getElementsByTagName("td");


    // Verificar si el input haiden ya ha sido agregado
    var haidenInput = document.getElementById("id_old");
    if (!haidenInput) {
        // Si el input no ha sido agregado, agregarlo
        var newInput = '<input type="hidden" id="id_old" name="id_old">';
        document.getElementById("alta_editorial").insertAdjacentHTML("beforeend", newInput);
    }

    // Asignar el valor del atributo "value" del input haiden
    document.getElementById("id_old").value = id;

    document.getElementById("nombre").value = celdas[2].innerHTML;

    document.getElementById("alta_editorial").action = "/dwp_2023_pf_bmanuel/editoriales/edit/"

    document.getElementById("btGuardar").style.display = "none";
    document.getElementById("btModificar").style.display = "inline-block";
}