<?php
session_start();
if (!isset($_SESSION["user_logueado"])) {
    header("Location: /dwp_2023_pf_bmanuel/index.php");
  return;
}

require_once('constants.php');
require_once('model.php');
require_once('view.php');

require_once('../editoriales/model.php');
require_once('../autores/model.php');

function handler()
{
    session_start();
        // redirigir a la vista VIEW_GET_AUTOR si no se especifica ninguna petición
    if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === MODULO) {
        header("Location: /dwp_2023_pf_bmanuel/libros/set/");
        exit();
    }

    $event = VIEW_GET_LIBRO;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(
        SET_LIBRO,          GET_LIBRO,          DELETE_LIBRO,           EDIT_LIBRO,
        VIEW_SET_LIBRO,     VIEW_GET_LIBRO,     VIEW_DELETE_LIBRO,      VIEW_EDIT_LIBRO
    );

    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO . $peticion . '/';
        if (strpos($uri, $uri_peticion) == true) {
            $event = $peticion;
        }
    }

    $libro = set_obj_libro();

    switch ($event) {
        case SET_LIBRO:
            if (!empty($_POST)) {
               $result_set = $libro->set($_POST);
               $_SESSION['mensaje_action'] = $result_set;
               header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/');
            }
            break;
        case GET_LIBRO:
            $mensaje = isset($_SESSION['mensaje_action']) ? $_SESSION['mensaje_action'] : '';
            unset($_SESSION['mensaje_action']);
            $autor = new AutorModel();
            $autores = $autor->get();
            $editorial = new EditorialModel;
            $editoriales = $editorial->get();
            $libros = $libro->get();
            $libros['mensaje'] = $mensaje;
            retornar_vista(VIEW_SET_LIBRO, $libros, $autores, $editoriales);
            
            break;
        case DELETE_LIBRO:
            if (!empty($_POST)) {
                $result_delete = $libro->delete($_POST['id_delete']);
                $_SESSION['mensaje_action'] = $result_delete;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/');
            }
            break;
        case EDIT_LIBRO:
            if (!empty($_POST) ) {
                $result_edited = $libro->edit($_POST);
                $_SESSION['mensaje_action'] = $result_edited;

                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/');
            } else{
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/');

            }
            break;
        default:
        header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/');
    }
}
function set_obj_libro()
{
    $obj = new LibroModel();
    return $obj;
}
handler();






