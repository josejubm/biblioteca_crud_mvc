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

    document.getElementById("btnGuardar").style.display = "none";
    document.getElementById("btnCancelar").style.display = "inline-block";
    document.getElementById("btnModificar").style.display = "inline-block";

}

function cancelarUpdateAutor() {



    document.getElementById("nombre").value = '';
    document.getElementById("paterno").value = '';
    document.getElementById("materno").value = '';

    document.getElementById("alta_autor").action = "/dwp_2023_pf_bmanuel/autores/set/"

    document.getElementById("btnGuardar").style.display = "inline-block";
    document.getElementById("btnCancelar").style.display = "none";
    document.getElementById("btnModificar").style.display = "none";
}

