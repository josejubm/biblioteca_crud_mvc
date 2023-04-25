<?php
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
            case GET_EDITORIAL:

            retornar_vista(VIEW_GET_EDITORIAL);
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
