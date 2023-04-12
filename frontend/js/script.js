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

