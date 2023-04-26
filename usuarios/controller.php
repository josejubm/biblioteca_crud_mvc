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
        header("Location: " . MODULO . VIEW_GET_USUARIO . "/");
        exit();
    }

    $event = VIEW_SET_USUARIO;
    $uri = $_SERVER['REQUEST_URI'];
    $peticiones = array(
        SET_USUARIO,          GET_USUARIO,          DELETE_USUARIO,           EDIT_USUARIO,
        VIEW_SET_USUARIO,     VIEW_GET_USUARIO,     VIEW_DELETE_USUARIO,      VIEW_EDIT_USUARIO
    );

    foreach ($peticiones as $peticion) {
        $uri_peticion = MODULO . $peticion . '/';
        if (strpos($uri, $uri_peticion) == true) {
            $event = $peticion;
        }
    }

    $usuario = set_obj_usuario();

    switch ($event) {
        case SET_USUARIO:
            if (!empty($_POST)) {
                $result_set = $usuario->set($_POST);
                $_SESSION['mensaje_action'] = $result_set;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/');
            }
            break;
        case GET_USUARIO:
            $mensaje = isset($_SESSION['mensaje_action']) ? $_SESSION['mensaje_action'] : '';
            unset($_SESSION['mensaje_action']);
            $usuarios = $usuario->get();
            $usuarios['mensaje'] = $mensaje;
            retornar_vista(VIEW_SET_USUARIO, $usuarios);
            break;
        case DELETE_USUARIO:
            if (!empty($_POST)) {
                $result_delete = $usuario->delete($_POST['id_delete']);
                $_SESSION['mensaje_action'] = $result_delete;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/');
            }
            /* header("Location: /dwp_2023_pf_bmanuel/autores/mostrar/"); */
            break;
        case EDIT_USUARIO:
            if (!empty($_POST)) {
                $result_edited = $usuario->edit($_POST);
                $_SESSION['mensaje_action'] = $result_edited;
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/');
            } else {
                header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/');
            }
            break;
        default:
        header('Location: ' . '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/');

    }
}
function set_obj_usuario()
{
    $obj = new UsuarioModel();
    return $obj;
}
handler();
