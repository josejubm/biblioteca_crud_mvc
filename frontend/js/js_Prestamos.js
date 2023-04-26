
function editarPrestamo(id) {
    var celdas = document.getElementById(id).getElementsByTagName("td");
    document.getElementById("libro").value = celdas[1].innerHTML;
    document.getElementById("usuario").value = celdas[3].innerHTML;
    document.getElementById("salida").value = celdas[5].innerHTML;
    document.getElementById("devolucion").value = null;
    document.getElementById("devolucion").style='display: inline-block;';
    document.getElementById("label_devolucion").style='display: inline-block;';

    // Selección de la opción del libro
    var libroValue = celdas[1].innerHTML;
    var libroSelect = document.getElementById("libro");
    for (var i = 0; i < libroSelect.options.length; i++) {
        if (libroSelect.options[i].value === libroValue) {
            libroSelect.options[i].selected = true;
            break;
        }
    }

    // Selección de la opción del usuario
    var usuarioValue = celdas[3].innerHTML;
    var usuarioSelect = document.getElementById("usuario");
    for (var i = 0; i < usuarioSelect.options.length; i++) {
        if (usuarioSelect.options[i].value === usuarioValue) {
            usuarioSelect.options[i].selected = true;
            break;
        }
    }

    document.getElementById("alta_libro").action = "/dwp_2023_pf_bmanuel/prestamos/edit/"

    document.getElementById("btnGuardar").style.display = "none";
    document.getElementById("btnCancelar").style.display = "inline-block";
    document.getElementById("btnModificar").style.display = "inline-block";
}



function cancelarUpdatePrestamo() {

    document.getElementById("libro").value = null;
    document.getElementById("usuario").value = null;
    document.getElementById("salida").value = null;
    document.getElementById("devolucion").style='display: none;';
    document.getElementById("label_devolucion").style='display: none;';

  
    document.getElementById("alta_libro").action = "/dwp_2023_pf_bmanuel/prestamos/set/"

    document.getElementById("btnGuardar").style.display = "inline-block";
    document.getElementById("btnCancelar").style.display = "none";
    document.getElementById("btnModificar").style.display = "none";
}



/* MODAL Prestamos */

function modalPrestamos(user_id, isbn, salida, user, libro) {
    document.getElementById("modal").style.display = "block";
    document.getElementById("text_an").style.display = "none";

    const mensaje = document.getElementById("id_a_eliminar");
    mensaje.style.fontSize = '1.4em';
    mensaje.innerHTML = '';

    const texto1 = document.createElement('span');
    texto1.textContent = 'Se Eliminara el Prestamo de: ';
    texto1.style.color = 'black';
    mensaje.appendChild(texto1);

    const variable1 = document.createElement('span');
    variable1.textContent = user;
    variable1.style.color = 'green';
    mensaje.appendChild(variable1);

    const texto2 = document.createElement('span');
    texto2.textContent = ' Con el Libro: ';
    texto2.style.color = 'black';
    mensaje.appendChild(texto2);

    const variable2 = document.createElement('span');
    variable2.textContent = libro;
    variable2.style.color = 'green';
    mensaje.appendChild(variable2);

    const texto3 = document.createElement('span');
    texto3.textContent = ' Realisado el: ';
    texto3.style.color = 'black';
    mensaje.appendChild(texto3);

    const variable3 = document.createElement('span');
    variable3.textContent = salida;
    variable3.style.color = 'green';
    mensaje.appendChild(variable3);

    const form = document.getElementById('modal_form');
    const input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'user_id');
    input.setAttribute('value', user_id);
    const input2 = document.createElement('input');
    input2.setAttribute('type', 'hidden');
    input2.setAttribute('name', 'isbn');
    input2.setAttribute('value', isbn);
    const input3 = document.createElement('input');
    input3.setAttribute('type', 'date');
    input3.setAttribute('style', 'display: none;');
    input3.setAttribute('name', 'salida');
    input3.setAttribute('value', salida);
    form.appendChild(input);
    form.appendChild(input2);
    form.appendChild(input3);
}
/* FIN MODAL */

/* ORDEN ALFAVETICA METE DE LOS SELECT */
function ordenarSelect(idSelect) {
    // Seleccionar el select por su ID
    var select = document.getElementById(idSelect);
    // Crear un array vacío para las opciones
    var options = [];
    // Recorrer todas las opciones del select
    for (var i = 0; i < select.options.length; i++) {
      // Agregar la opción al array
      options.push(select.options[i]);
    }
    // Ordenar alfabéticamente el array de opciones
    options.sort(function(a, b) {
      return a.text.localeCompare(b.text);
    });
    // Crear una cadena de texto con el código HTML de las opciones ordenadas
    var html = "";
    for (var i = 0; i < options.length; i++) {
      html += "<option value=\"" + options[i].value + "\">" + options[i].text + "</option>";
    }
    // Reemplazar el contenido del select con las opciones ordenadas
    select.innerHTML = html;
  }
  
  // Llamar a la función para ordenar los selects con diferentes IDs
  ordenarSelect("usuario");
  ordenarSelect("libro");
  /* FIN DEL ORDENAMIENTO */