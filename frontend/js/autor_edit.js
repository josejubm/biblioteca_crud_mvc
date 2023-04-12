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


// JavaScript
const table = document.getElementById('tablaAutores');
let currentPage = 1;
const rowsPerPage = 15;
const totalPages = Math.ceil(table.rows.length / rowsPerPage);

function updateTable(page) {
    for (let i = 0; i < table.rows.length; i++) {
        const row = table.rows[i];
        if (i < (page - 1) * rowsPerPage || i >= page * rowsPerPage) {
            row.style.display = 'none';
        } else {
            row.style.display = '';
        }
    }
}

updateTable(currentPage);

document.getElementById('anterior').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        updateTable(currentPage);
    }
});

document.getElementById('siguiente').addEventListener('click', () => {
    if (currentPage < totalPages) {
        currentPage++;
        updateTable(currentPage);
    }
});
