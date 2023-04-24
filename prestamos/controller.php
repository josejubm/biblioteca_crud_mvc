<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');

require_once('../usuarios/model.php');
require_once('../libros/model.php');

function handler()
{
    /*     // redirigir a la vista VIEW_GET_AUTOR si no se especifica ninguna petición
    if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === MODULO) {
        header("Location: " . MODULO . VIEW_GET_LIBRO . "/");
        exit();
    } */

    $event = VIEW_GET_PRESTAMO;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(
        SET_PRESTAMO,          GET_PRESTAMO,          DELETE_PRESTAMO,           EDIT_PRESTAMO,
        VIEW_SET_PRESTAMO,     VIEW_GET_PRESTAMO,     VIEW_DELETE_PRESTAMO,      VIEW_EDIT_PRESTAMO
    );

    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO . $peticion . '/';
        if (strpos($uri, $uri_peticion) == true) {
            $event = $peticion;
        }
    }

    $prestamo = set_obj_prestamo();

    switch ($event) {
        case SET_PRESTAMO:
            if (!empty($_POST)) {
               $result_set = $prestamo->set($_POST);
                $libro = new LibroModel();
                $libros = $libro->get();
                $usuario = new UsuarioModel();
                $usuarios = $usuario->get();
                $prestamos = $prestamo->get();
                $prestamos['mensaje'] = $result_set;
                retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
            } else {
                $libro = new LibroModel();
                $libros = $libro->get();
                $usuario = new UsuarioModel();
                $usuarios = $usuario->get();
                $prestamos = $prestamo->get();
                retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
            }
            break;
        case GET_PRESTAMO:
                $libro = new LibroModel();
                $libros = $libro->get();
                $usuario = new UsuarioModel();
                $usuarios = $usuario->get();
                $prestamos = $prestamo->get();
                retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
            break;
        case DELETE_PRESTAMO:
            if (!empty($_POST)) {
          
                $result_delete = $prestamo->delete($_POST);
                $prestamos = $prestamo->get();
                $prestamos['mensaje'] = $result_delete;
                // Verificar si hay un mensaje de eliminación
                if ($prestamos['mensaje']['tipo'] == 'success') {
                    // Mostrar el mensaje
                    echo $prestamos['mensaje'];
                    // Eliminar el registro correspondiente del array de registros
                    foreach ($prestamos['registros'] as $key => $registro) {
                        if ($registro['Id'] == $_POST['id_delete']) {
                            unset($prestamos['registros'][$key]);
                            break;
                        }
                    }
                }
                $libro = new LibroModel();
                $libros = $libro->get();
                $usuario = new UsuarioModel();
                $usuarios = $usuario->get();
                retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
            } else {
                $libro = new LibroModel();
                $libros = $libro->get();
                $usuario = new UsuarioModel();
                $usuarios = $usuario->get();
                $prestamos = $prestamo->get();
                retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
            }
            break;
        case EDIT_PRESTAMO: 
            if (!empty($_POST)) {
                $result_edited = $prestamo->edit($_POST);
                $libro = new LibroModel();
                $libros = $libro->get();
                $usuario = new UsuarioModel();
                $usuarios = $usuario->get();
                $prestamos = $prestamo->get();
                $prestamos['mensaje'] = $result_edited;
                retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
                
            } else{
                $libro = new LibroModel();
                $libros = $libro->get();
                $usuario = new UsuarioModel();
                $usuarios = $usuario->get();
                $prestamos = $prestamo->get();
                retornar_vista(VIEW_SET_PRESTAMO, $prestamos, $usuarios, $libros);
            }
            break;
        default:
           /*  $autores = $libro->get();
            retornar_vista($event, $autores); */
    }
}
function set_obj_prestamo()
{
    $obj = new PrestamoModel();
    return $obj;
}
handler();
