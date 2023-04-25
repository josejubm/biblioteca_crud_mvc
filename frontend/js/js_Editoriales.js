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

    document.getElementById("btnGuardar").style.display = "none";
    document.getElementById("btnCancelar").style.display = "inline-block";
    document.getElementById("btnModificar").style.display = "inline-block";

}

function cancelarEditorial() {

    document.getElementById("nombre").innerHTML = '';

    document.getElementById("alta_editorial").action = "/dwp_2023_pf_bmanuel/editoriales/set/"

    document.getElementById("btnGuardar").style.display = "inline-block";
    document.getElementById("btnCancelar").style.display = "none";
    document.getElementById("btnModificar").style.display = "none";
}
