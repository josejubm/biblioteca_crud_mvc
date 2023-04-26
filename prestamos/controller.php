<?php
session_start();
if (!isset($_SESSION["user_logueado"])) {
    header("Location: /dwp_2023_pf_bmanuel/index.php");
  return;
}
require_once('constants.php');
require_once('model.php');
require_once('view.php');

require_once('../usuarios/model.php');
require_once('../libros/model.php');

function handler()
{
    // redirigir a la vista VIEW_GET_AUTOR si no se especifica ninguna petición
    if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === MODULO) {
        header("Location: " . MODULO . VIEW_SET_PRESTAMO . "/");
        exit();
    }

    $event = VIEW_SET_PRESTAMO;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(
        SET_PRESTAMO,          GET_PRESTAMO,          DELETE_PRESTAMO,           EDIT_PRESTAMO, CONSULT,
        VIEW_SET_PRESTAMO,     VIEW_GET_PRESTAMO,     VIEW_DELETE_PRESTAMO,      VIEW_EDIT_PRESTAMO,
        VIEW_CONSULTAS_PRESTAMO
    );

    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO . $peticion . '/';
        if (strpos($uri, $uri_peticion) == true) {
            $event = $peticion;
        }
    }
    session_start();
    $prestamo = set_obj_prestamo();

    switch ($event) {
        case SET_PRESTAMO:
            if (!empty($_POST)) {
                $result_set = $prestamo->set($_POST);
                $_SESSION['mensaje_action'] = $result_set;

                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/');
            }
            break;
        case GET_PRESTAMO:
            $mensaje = isset($_SESSION['mensaje_action']) ? $_SESSION['mensaje_action'] : '';
            unset($_SESSION['mensaje_action']);
            $libro = new LibroModel();
            $libros = $libro->get();
            $usuario = new UsuarioModel();
            $usuarios = $usuario->get();
            $prestamos = $prestamo->get();
            $prestamos['mensaje'] = $mensaje;
            retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
            break;
        case DELETE_PRESTAMO:
            if (!empty($_POST)) {
                $result_delete = $prestamo->delete($_POST);
                $_SESSION['mensaje_action'] = $result_delete;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/');
            }
            break;
        case EDIT_PRESTAMO:
            if (!empty($_POST)) {
                $result_edited = $prestamo->edit($_POST);
                $_SESSION['mensaje_action'] = $result_edited;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/');
            }
            break;
        case CONSULT:
            if (isset($_POST['Fdevolucion'])) {
                $devolucion = $_POST['Fdevolucion'];
                $consulta = "SELECT libros.ISBN AS ISBN,  libros.Titulo AS TITULO, usuarios.ClaveUsu, 
                        CONCAT(usuarios.Nombre, ' ', usuarios.Paterno, ' ', usuarios.Materno) AS NombreCompleto, prestamos.Salida AS SALIDA, prestamos.Devolucion AS DEVOLUCION
                        FROM prestamos, libros, usuarios
                        WHERE prestamos.ISBN = libros.ISBN AND prestamos.ClaveUsu = usuarios.ClaveUsu AND prestamos.Salida = '$devolucion';
                         ";
                $mensaje = "Aqui Todos Los Prestamos Con Fecha De Devolucion del '$devolucion' ";
                $_POST = null;  
            } elseif (isset($_POST['Fsalida'])) {
                $salida = $_POST['Fsalida'];
                $consulta = "SELECT libros.ISBN AS ISBN,  libros.Titulo AS TITULO, usuarios.ClaveUsu, 
                        CONCAT(usuarios.Nombre, ' ', usuarios.Paterno, ' ', usuarios.Materno) AS NombreCompleto, prestamos.Salida AS SALIDA, prestamos.Devolucion AS DEVOLUCION
                        FROM prestamos, libros, usuarios
                        WHERE prestamos.ISBN = libros.ISBN AND prestamos.ClaveUsu = usuarios.ClaveUsu AND prestamos.Salida = '$salida';
                        ";
                $mensaje = "Aqui Todos Los Prestamos Con Fecha De Salida del '$salida' ";
                $_POST = null;  
            } elseif (isset($_POST['mes'])) {
                $numero_mes = $_POST['mes'];
                $consulta = "SELECT libros.ISBN AS ISBN,  libros.Titulo AS TITULO, usuarios.ClaveUsu, 
                    CONCAT(usuarios.Nombre, ' ', usuarios.Paterno, ' ', usuarios.Materno) AS NombreCompleto, prestamos.Salida AS SALIDA, prestamos.Devolucion AS DEVOLUCION
                    FROM prestamos, libros, usuarios
                    WHERE prestamos.ISBN = libros.ISBN AND prestamos.ClaveUsu = usuarios.ClaveUsu AND
                    MONTH(prestamos.Salida) = '$numero_mes';
                    ";
                    $meses = array(
                        1 => "Enero",
                        2 => "Febrero",
                        3 => "Marzo",
                        4 => "Abril",
                        5 => "Mayo",
                        6 => "Junio",
                        7 => "Julio",
                        8 => "Agosto",
                        9 => "Septiembre",
                        10 => "Octubre",
                        11 => "Noviembre",
                        12 => "Diciembre"
                    );
                    if (array_key_exists($numero_mes, $meses)) {
                        $mes = $meses[$numero_mes];
                    } else {
                        $mes = "Ingresa un mes para ver los resultados";
                    }
                $mensaje = "Aqui Todos Los Prestamos Con Fecha De Salida del '$mes' ";
                $_POST = null;  
            }elseif (isset($_POST['fecha_dia'])) {
                $hoy = $_POST['fecha_dia'];
                $consulta = "SELECT libros.ISBN AS ISBN,  libros.Titulo AS TITULO, usuarios.ClaveUsu, 
                        CONCAT(usuarios.Nombre, ' ', usuarios.Paterno, ' ', usuarios.Materno) AS NombreCompleto, prestamos.Salida AS SALIDA, prestamos.Devolucion AS DEVOLUCION
                        FROM prestamos, libros, usuarios
                        WHERE prestamos.ISBN = libros.ISBN AND prestamos.ClaveUsu = usuarios.ClaveUsu AND prestamos.Salida = '$hoy';
                        ";
                $mensaje = "Aqui Todos Los Prestamos del dia de hoy  '$hoy' "; 
                $_POST = null;    
            }else
            {
                $prestamos = $prestamo->get();
                $mensaje = "Todos Los Prestamos";
                $_POST = null;  
                retornar_vista_consultas(VIEW_CONSULTAS_PRESTAMO, $prestamos, $mensaje);    
            }
            $prestamos = $prestamo->consultaPorFecha($consulta);
            $_POST = null;  
            retornar_vista_consultas(VIEW_CONSULTAS_PRESTAMO, $prestamos, $mensaje);
            break;
        default:
            header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/');
    }
}
function set_obj_prestamo()
{
    $obj = new PrestamoModel();
    return $obj;
}
handler();
