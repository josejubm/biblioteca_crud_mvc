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


/* COPIAR DE TABLA A FORMULARIO DE REGISTRO DE LIBROS  */

function editarLibro(isbn) {
    var celdas = document.getElementById(isbn).getElementsByTagName("td");

    console.log("entro a la fincion");

    // Verificar si el input haiden ya ha sido agregado
    var haidenInput = document.getElementById("isbn_old");
    if (!haidenInput) {
        // Si el input no ha sido agregado, agregarlo
        var newInput = '<input type="hidden" id="isbn_old" name="isbn_old">';
        document.getElementById("alta_libro").insertAdjacentHTML("beforeend", newInput);
    }

    // Asignar el valor del atributo "value" del input haiden
    document.getElementById("isbn_old").value = isbn;

    document.getElementById("isbn").value = isbn;
    document.getElementById("titulo").value = celdas[2].innerHTML;

    document.getElementById("title_libro").innerHTML = "Actualizar Registro";
    document.getElementById("label_isbn").innerHTML = "NUEVO ISBN";
    document.getElementById("label_titulo").innerHTML = "NUEVO TITULO";
    document.getElementById("label_editoriales").innerHTML = "SELECCIONA LA NUEVA EDITORIAL";
    document.getElementById("label_autores").innerHTML = "SELECCIONA A LOS NUEVOS AUTORES";

    document.getElementById("alta_libro").action = "/dwp_2023_pf_bmanuel/libros/edit/"

    document.getElementById("btnGuardar").style.display = "none";
    document.getElementById("btnCancelar").style.display = "inline-block";
    document.getElementById("btnModificar").style.display = "inline-block";

}
function cancelarUpdateLibro(){

    document.getElementById("title_libro").innerHTML = "Registrar Nuevo Libro";
    document.getElementById("label_isbn").innerHTML = "ISBN:";
    document.getElementById("label_titulo").innerHTML = "TITULO:";
    document.getElementById("label_editoriales").innerHTML = "Selecciona la Editorial";
    document.getElementById("label_autores").innerHTML = "Selecciona los Autores del Libro:";

    document.getElementById("isbn").value = '';
    document.getElementById("titulo").value = '';

    document.getElementById("alta_libro").action = "/dwp_2023_pf_bmanuel/libros/set/"

    document.getElementById("btnGuardar").style.display = "inline-block";
    document.getElementById("btnCancelar").style.display = "none";
    document.getElementById("btnModificar").style.display = "none";
}
/* FIN DE COPIAR A  FORMULARIO */


/* Autor a form libros*/

const selectAutor = document.getElementById('autor');
const inputContainer = document.createElement('div');

selectAutor.addEventListener('change', (event) => {
  const selectedOption = event.target.options[event.target.selectedIndex].text;
  const valueO = event.target.value;

  if (selectedOption) {
    const input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'autores[]');
    input.setAttribute('value', valueO);
    input.setAttribute('placeholder', selectedOption);

    const label = document.createElement('label'); 
    label.setAttribute('class', 'label_autor_add');
    label.innerText = `AUTOR: ${selectedOption}. AGREGADO`;

    const icon = document.createElement('i'); 
    icon.setAttribute('class', 'bx bx-user');

    const br = document.createElement('br'); 

    const removeButton = document.createElement('button');
    removeButton.innerHTML = '<i class="bx bx-trash"></i>';
    removeButton.setAttribute('class', 'btn-remove-autor boton boton-outline-danger');
    removeButton.setAttribute('style', 'margin-left: 6px;');

    removeButton.addEventListener('click', () => {
      inputContainer.removeChild(input);
      inputContainer.removeChild(icon);
      inputContainer.removeChild(label);
      inputContainer.removeChild(removeButton);
      inputContainer.removeChild(br);
    });

    inputContainer.appendChild(input);
    inputContainer.appendChild(icon);
    inputContainer.appendChild(label);
    inputContainer.appendChild(removeButton);
    inputContainer.appendChild(br);
    selectAutor.before(inputContainer);
  }
});

/* fin */

/* PAGINADO DE TABLA */

const table = document.getElementById('table');
const tableRows = table.getElementsByTagName('tr');
const totalPages = Math.ceil(tableRows.length / 11);

function showTablePage(page) {
  // hide all rows
  for (let i = 1; i < tableRows.length; i++) {
    tableRows[i].style.display = 'none';
  }

  // show rows for current page
  const start = (page - 1) * 11;
  const end = start + 11;
  for (let i = start; i < end && i < tableRows.length; i++) {
    tableRows[i].style.display = '';
  }
}

function createPagination() {
    const pagination = document.getElementById('pagination');
    const list = document.createElement('ul');
    list.classList.add('pagination-list');
    pagination.appendChild(list);
    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement('li');
      pageButton.classList.add('pagination-item');
      const pageLink = document.createElement('a');
      pageLink.href = '#';
      pageLink.innerText = i;
      pageButton.appendChild(pageLink);
      pageButton.addEventListener('click', () => showTablePage(i));
      list.appendChild(pageButton);
    }
  }
  

showTablePage(1);
createPagination();



/* FUNCIONA PARA BUCAR EN TABLA */

function buscar() {
    var datoBuscar = document.getElementById("tfBuscar").value.toLowerCase();
    var tblDatos = document.getElementById("table");
    const mensaje = document.getElementById("mensaje");
    mensaje.innerHTML = "";

    for (let i = 1; i < tblDatos.rows.length; i++) {
        var celdas = tblDatos.rows[i].getElementsByTagName("td");
        var encontrado = false;

        for (let j = 0; j < celdas.length && !encontrado; j++) {
            var valorCelda = celdas[j].innerHTML.toLowerCase();

            if (datoBuscar.length== 0 || valorCelda.indexOf(datoBuscar) > -1) {

                encontrado = true;
            }
        }
        if (encontrado) {
            tblDatos.rows[i].style.display="";
        } else {
            tblDatos.rows[i].style.display="none";
        }
    }
}




