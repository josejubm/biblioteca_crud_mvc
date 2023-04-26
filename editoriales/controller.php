<?php
session_start();
if (!isset($_SESSION["user_logueado"])) {
    header("Location: /dwp_2023_pf_bmanuel/index.php");
  return;
}
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler()
{
    session_start();
    // redirigir a la vista VIEW_GET_AUTOR si no se especifica ninguna petición
    if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === MODULO) {
        header("Location: " . MODULO . VIEW_GET_EDITORIAL . "/");
        exit();
    }

    $event = VIEW_GET_EDITORIAL;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(
        SET_EDITORIAL,          GET_EDITORIAL,          DELETE_EDITORIAL,           EDIT_EDITORIAL,
        VIEW_SET_EDITORIAL,     VIEW_GET_EDITORIAL,     VIEW_DELETE_EDITORIAL,      VIEW_EDIT_EDITORIAL
    );

    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO . $peticion . '/';
        if (strpos($uri, $uri_peticion) == true) {
            $event = $peticion;
        }
    }

    $editorial = set_obj_editorial();

    switch ($event) {
      case SET_EDITORIAL:
            if (!empty($_POST) && $_POST['nombre'] != '') {
             $result_set = $editorial->set($_POST); 
             $_SESSION['mensaje_action'] = $result_set;
             header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/');
            } else {
            header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/');
            }
            break;
        case GET_EDITORIAL:
            $mensaje = isset($_SESSION['mensaje_action']) ? $_SESSION['mensaje_action'] : '';
            unset($_SESSION['mensaje_action']);
            $editoriales = $editorial->get();
            $editoriales['mensaje'] = $mensaje;
            retornar_vista(VIEW_SET_EDITORIAL, $editoriales);
            break;
        case DELETE_EDITORIAL:
            if (!empty($_POST)) {
                $result_delete = $editorial->delete($_POST['id_delete']);
                $_SESSION['mensaje_action'] = $result_delete;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/');
            }
           break;
       case EDIT_EDITORIAL:
            if (!empty($_POST) && $_POST['nombre'] != '') {
                $result_edited = $editorial->edit($_POST);
                $_SESSION['mensaje_action'] = $result_edited;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/');
            } else{
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/');
            }
            break;
        default:
        header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/');

    }
}
function set_obj_editorial()
{
    $obj_Editorial = new EditorialModel();
    return $obj_Editorial;
}
handler();
