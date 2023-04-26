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
    // redirigir a la vista VIEW_GET_AUTOR si no se especifica ninguna petición
    if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === MODULO) {
        header("Location: " . MODULO . VIEW_SET_AUTOR . "/");
        exit();
    }

    $event = VIEW_GET_AUTOR;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(
        SET_AUTOR,          GET_AUTOR,          DELETE_AUTOR,           EDIT_AUTOR,
        VIEW_SET_AUTOR,     VIEW_GET_AUTOR,     VIEW_DELETE_AUTOR,      VIEW_EDIT_AUTOR
    );

    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO . $peticion . '/';
        if (strpos($uri, $uri_peticion) == true) {
            $event = $peticion;
        }
    }

    $autor = set_obj_autor();

    session_start();

    switch ($event) {
        case SET_AUTOR:
            if (!empty($_POST) && $_POST['nombre'] != '') {
                $result_set = $autor->set($_POST);
                $_SESSION['mensaje_action'] = $result_set;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_AUTOR . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_AUTOR . '/');
            }
            break;
        case GET_AUTOR:
            $mensaje = isset($_SESSION['mensaje_action']) ? $_SESSION['mensaje_action'] : '';
            unset($_SESSION['mensaje_action']);
            $autores = $autor->get(); 
            $autores['mensaje'] = $mensaje;
            retornar_vista(VIEW_SET_AUTOR, $autores);
            break;
        case DELETE_AUTOR:
            if (!empty($_POST)) {
                $result_delete = $autor->delete($_POST['id_delete']);
                $_SESSION['mensaje_action'] = $result_delete;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_AUTOR . '/');  
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_AUTOR . '/');
            }
            break;
        case EDIT_AUTOR:
            if (!empty($_POST) && $_POST['nombre'] != '') {
                $result_edited = $autor->edit($_POST);
                $_SESSION['mensaje_action'] = $result_edited;
                header('Location:  http://localhost/dwp_2023_pf_bmanuel/autores/set/');
            } else{
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_AUTOR . '/');
            }
            break;
        default:
        header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_AUTOR . '/');
    }
}
function set_obj_autor()
{
    $obj_Autor = new AutorModel();
    return $obj_Autor;
}
handler();
