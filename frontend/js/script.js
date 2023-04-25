/* PAGINADO DE TABLA */
function showTablePage(tableId, page) {
  const table = document.getElementById(tableId);
  const tableRows = table.getElementsByTagName('tr');
  const totalPages = Math.ceil(tableRows.length / 8);

  // hide all rows
  for (let i = 1; i < tableRows.length; i++) {
      tableRows[i].style.display = 'none';
  }

  // show rows for current page
  const start = (page - 1) * 8;
  const end = start + 8;
  for (let i = start; i < end && i < tableRows.length; i++) {
      tableRows[i].style.display = '';
  }
}
function createPagination(tableId) {
  const table = document.getElementById(tableId);
  const tableRows = table.getElementsByTagName('tr');
  const totalPages = Math.ceil(tableRows.length / 8);

  const pagination = document.createElement('div');
  pagination.classList.add('pagination');
  table.parentNode.insertBefore(pagination, table.nextSibling);

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
      pageButton.addEventListener('click', () => showTablePage(tableId, i));
      list.appendChild(pageButton);

      pageButton.addEventListener('click', () => {
          const paginationItems = document.querySelectorAll('.pagination-item');
          paginationItems.forEach(item => item.classList.remove('active_pagination'));
          pageButton.classList.add('active_pagination');

          showTablePage(tableId, i);
      });

  }
}
const tableId = 'table';
showTablePage(tableId, 1);
createPagination(tableId);

/* FIN PAGINADO */

/* ANIMACION DEL SIDEBAR */

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}

/* alert js script */
// Evento para cerrar la alerta al hacer clic en la "X"
var close = document.getElementsByClassName("closebtn");
for (var i = 0; i < close.length; i++) {
    close[i].addEventListener("click", function () {
        var div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function () { div.parentNode.removeChild(div); }, 600);
    });
}
/* FIN ANIMACION DEL SIDEBAR */

/* paginado de la tabla INICIO */

const root = document.documentElement;
const colors = ['#B1B695', '#E7CBA9', '#DECDBE', '#B5D8CC', '#D5C5A7'];

/* genera un color aleatorio de la paleta de colores pastel */
function getRandomColor() {
  return colors[Math.floor(Math.random() * colors.length)];
}

/* actualiza la variable CSS para el color aleatorio */
function setRandomColor() {
  root.style.setProperty('--random-color', getRandomColor());
}

/* agrega la clase 'tr-hover' a cada fila de la tabla */
const rows = document.getElementsByTagName('tr');
for (let i = 0; i < rows.length; i++) {
  rows[i].classList.add('tr-hover');
}

/* actualiza el color aleatorio cada vez que se pase el cursor sobre una fila */
const trHover = document.getElementsByClassName('tr-hover');
for (let i = 0; i < trHover.length; i++) {
  trHover[i].addEventListener('mouseover', setRandomColor);
}


/* FUNCIONA PARA BUCAR EN TABLA */
function buscarEnTabla() {
  var datoBuscar = document.getElementById("tfBuscar").value.toLowerCase();
  var tblDatos = document.getElementById("table");

  for (let i = 1; i < tblDatos.rows.length; i++) {
      var celdas = tblDatos.rows[i].getElementsByTagName("td");
      var encontrado = false;

      for (let j = 0; j < celdas.length && !encontrado; j++) {
          var valorCelda = celdas[j].innerHTML.toLowerCase();

          if (datoBuscar.length == 0 || valorCelda.indexOf(datoBuscar) > -1) {

              encontrado = true;
              /* break; */
          }
      }
      if (encontrado) {
          tblDatos.rows[i].style.display = "";
      } else {
          tblDatos.rows[i].style.display = "none";
      }

  }
}


/* MODAL */

function mostrarModal(valor, nombre) {
  document.getElementById("modal").style.display = "block";
  document.getElementById("id_a_eliminar").textContent = nombre;


  const form = document.getElementById('modal_form');
  const input = document.createElement('input');
  input.setAttribute('type', 'hidden');
  input.setAttribute('name', 'id_delete');
  input.setAttribute('value', valor);
  form.appendChild(input);

}

function ocultarModal() {
  document.getElementById("modal").style.display = "none";
}

/* FIN MODAL */







