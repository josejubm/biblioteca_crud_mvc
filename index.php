<?php
// Realizar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adb_2023_act6_Bmanuel";
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
  die("La conexión falló: " . $conn->connect_error);
}

// Consulta para obtener una lista de autores y editoriales similares
$sql_autores = "SELECT DISTINCT Nombre, Paterno, Materno FROM autores WHERE CONCAT(Nombre, ' ', Paterno, ' ', Materno) LIKE '%" . $_POST['autor'] . "%'";
$sql_editoriales = "SELECT DISTINCT Nombre FROM editoriales WHERE Nombre LIKE '%" . $_POST['editorial'] . "%'";

// Ejecutar las consultas y obtener los resultados
$result_autores = $conn->query($sql_autores);
$result_editoriales = $conn->query($sql_editoriales);

// Mostrar los resultados en menús desplegables
echo "<label for='autor'>Autor:</label>";
echo "<select name='autor' required>";
if ($result_autores->num_rows > 0) {
  while ($row = $result_autores->fetch_assoc()) {
    echo "<option value='" . $row['Nombre'] . " " . $row['Paterno'] . " " . $row['Materno'] . "'>" . $row['Nombre'] . " " . $row['Paterno'] . " " . $row['Materno'] . "</option>";
  }
} else {
  echo "<option value=''>No se encontraron autores similares</option>";
}
echo "</select>";

echo "<label for='editorial'>Editorial:</label>";
echo "<select name='editorial' required>";
if ($result_editoriales->num_rows > 0) {
  while ($row = $result_editoriales->fetch_assoc()) {
    echo "<option value='" . $row['Nombre'] . "'>" . $row['Nombre'] . "</option>";
  }
} else {
  echo "<option value=''>No se encontraron editoriales similares</option>";
}
echo "</select>";

// Cerrar la conexión a la base de datos
$conn->close();
?>
