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
    document.getElementById("colonia").value = celdas[6].innerHTML;
    document.getElementById("calle").value = celdas[7].innerHTML;
    document.getElementById("numero").value = celdas[7].innerHTML;
    document.getElementById("telefono").value = celdas[9].innerHTML;

    document.getElementById("alta_usuario").action = "/dwp_2023_pf_bmanuel/usuarios/edit/"

    document.getElementById("btnGuardar").style.display = "none";
    document.getElementById("btnCancelar").style.display = "inline-block";
    document.getElementById("btnModificar").style.display = "inline-block";
}


function cancelarUsuario() {
    document.getElementById("ClaveUsu_old").value = '';
    document.getElementById("ClaveUsu").innerHTML = '';
    document.getElementById("nombre").innerHTML = '';
    document.getElementById("paterno").innerHTML = '';
    document.getElementById("materno").innerHTML = '';
    document.getElementById("colonia").innerHTML = '';
    document.getElementById("calle").innerHTML = '';
    document.getElementById("numero").innerHTML = '';
    document.getElementById("telefono").innerHTML = '';

    document.getElementById("alta_usuario").action = "/dwp_2023_pf_bmanuel/usuarios/set/"

    document.getElementById("btnGuardar").style.display = "inline-block";
    document.getElementById("btnCancelar").style.display = "none";
    document.getElementById("btnModificar").style.display = "none";
}
