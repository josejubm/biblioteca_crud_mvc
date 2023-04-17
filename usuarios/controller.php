<?php
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

    $event = VIEW_GET_USUARIO;
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
                $result = $usuario->set($_POST);
                $usuarios = $usuario->get();
                $usuarios['mensaje'] = $result;
                retornar_vista(VIEW_SET_USUARIO, $usuarios);
                $autores = array();
            } else {
                $usuarios = $usuario->get();
                retornar_vista(VIEW_SET_USUARIO, $usuarios);
            }
            break;
        case GET_USUARIO:
            $usuarios = $usuario->get();
            retornar_vista(VIEW_SET_USUARIO, $usuarios);
            break;
        case DELETE_USUARIO:
            if (!empty($_POST)) {
                $result_delete = $usuario->delete($_POST['id_delete']);
                $usuarios = $usuario->get();
                $usuarios['mensaje'] = $result_delete;
                // Verificar si hay un mensaje de eliminación
                if ($usuarios['mensaje']['tipo'] == 'success') {
                    // Mostrar el mensaje
                    echo $usuarios['mensaje'];
                    // Eliminar el registro correspondiente del array de registros
                    foreach ($usuarios['registros'] as $key => $registro) {
                        if ($registro['Id'] == $_POST['id_delete']) {
                            unset($usuarios['registros'][$key]);
                            break;
                        }
                    }
                }
                retornar_vista(VIEW_SET_USUARIO, $usuarios);
                $_POST = array();
            } else {
                $autores = $usuario->get();
                retornar_vista(VIEW_SET_AUTOR, $autores);
            }
            /* header("Location: /dwp_2023_pf_bmanuel/autores/mostrar/"); */
            break;
        case EDIT_USUARIO:
            if (!empty($_POST)) {
                $result_edited = $usuario->edit($_POST);
                $usuarios = $usuario->get();
                $usuarios['mensaje'] = $result_edited;
                retornar_vista(VIEW_SET_USUARIO, $usuarios);
                $usuarios = array();
                $_POST = array();
            } else {
                $usuarios = $usuario->get();
                retornar_vista(VIEW_SET_AUTOR, $usuarios);
            }
            break;
        default:
            $usuarios = $usuario->get_Two();
            retornar_vista($event, $usuarios);
    }
}
function set_obj_usuario()
{
    $obj = new UsuarioModel();
    return $obj;
}
handler();
