/* COPIAR DE TABLA A FORMULARIO DE REGISTRO DE LIBROS  */

function editarLibro(isbn) {
    var celdas = document.getElementById(isbn).getElementsByTagName("td");
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
    document.getElementById("editorial").value = celdas[3].innerHTML;
    document.getElementById("editorial").options[celdas[3].innerHTML].selected = true;

    // Leer la cadena de números en la celda 4 y crear inputs para cada número separado
    var autoresString = celdas[5].innerHTML;
    var autoresArray = autoresString.split("-"); // Dividir la cadena en un array

    var autoresNameString = celdas[6].innerHTML;
    var autoresNameArray = autoresNameString.split(",");

    var autoresContainer = document.getElementById("autores-container");
    autoresContainer.innerHTML = ""; // Limpiar el contenedor antes de agregar los nuevos inputs

    for (var i = 0; i < autoresArray.length; i++) {
        var autor_id = autoresArray[i].trim(); // Eliminar espacios en blanco
        var autor_name = autoresNameArray[i].trim();
        if (autor_id.length > 0 ) { // Verificar si el autor no está vacío

            const inputContainer = document.createElement('div');

            const input = document.createElement('input');
            input.setAttribute('type', 'hidden');
            input.setAttribute('name', 'autores[]');
            input.setAttribute('value', autor_id);
            input.setAttribute('placeholder', autor_name);
    
            const label = document.createElement('label');
            label.setAttribute('class', 'label_autor_add');
            label.innerText = `AUTOR: ${autor_name}.`;
    
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
        
            autoresContainer.appendChild(inputContainer);
        }

    }
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



function cancelarUpdateLibro() {

    document.getElementById("title_libro").innerHTML = "Registrar Nuevo Libro";
    document.getElementById("label_isbn").innerHTML = "ISBN:";
    document.getElementById("label_titulo").innerHTML = "TITULO:";
    document.getElementById("label_editoriales").innerHTML = "Selecciona la Editorial";
    document.getElementById("label_autores").innerHTML = "Selecciona los Autores del Libro:";

    document.getElementById("isbn").value = null;
    document.getElementById("isbn_old").value = null;
    document.getElementById("titulo").value = null;

    var autoresContainer = document.getElementById("autores-container");
    autoresContainer.innerHTML = null;

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