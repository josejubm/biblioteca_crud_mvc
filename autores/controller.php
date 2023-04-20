<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler()
{
    // redirigir a la vista VIEW_GET_AUTOR si no se especifica ninguna petición
    if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === MODULO) {
        header("Location: " . MODULO . VIEW_GET_AUTOR . "/");
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

    switch ($event) {
        case SET_AUTOR:
            if (!empty($_POST) && $_POST['nombre'] != '') {
                $autor_data_insert = array();
                $autor_data_insert['nombre'] = $_POST['nombre'];
                $autor_data_insert['paterno'] = $_POST['paterno'];
                $autor_data_insert['materno'] = $_POST['materno'];
                $result = $autor->set($autor_data_insert);
                $autor_data_insert = array();
                $_POST = array();
                $autores = $autor->get();
                $autores['mensaje'] = $result;
                retornar_vista(VIEW_SET_AUTOR, $autores);
                $autores = array();
            } else {
                $autores = $autor->get();
                retornar_vista(VIEW_SET_AUTOR, $autores);
            }
            break;
        case GET_AUTOR:
            $autores = $autor->get();
            retornar_vista(VIEW_SET_AUTOR, $autores);
            break;
        case DELETE_AUTOR:
            if (!empty($_POST)) {
                $result_delete = $autor->delete($_POST['id_delete']);
                $autores = $autor->get();
                $autores['mensaje'] = $result_delete;
                // Verificar si hay un mensaje de eliminación
                if ($autores['mensaje']['tipo'] == 'success') {
                    // Mostrar el mensaje
                    echo $autores['mensaje'];
                    // Eliminar el registro correspondiente del array de registros
                    foreach ($autores['registros'] as $key => $registro) {
                        if ($registro['Id'] == $_POST['id_delete']) {
                            unset($autores['registros'][$key]);
                            break;
                        }
                    }
                }
                retornar_vista(VIEW_SET_AUTOR, $autores);
                $_POST = array();
            } else {
                $autores = $autor->get();
                retornar_vista(VIEW_SET_AUTOR, $autores);
            }
            /* header("Location: /dwp_2023_pf_bmanuel/autores/mostrar/"); */
            break;
        case EDIT_AUTOR:
            if (!empty($_POST) && $_POST['nombre'] != '') {
                $result_edited = $autor->edit($_POST);
                $autores = $autor->get();
                $autores['mensaje'] = $result_edited;                
                retornar_vista(VIEW_SET_AUTOR, $autores);
                $autores = array();
                $_POST = array();
            } else{
                $autores = $autor->get();
                retornar_vista(VIEW_SET_AUTOR, $autores); 
            }
            break;
        default:
            $autores = $autor->get();
            retornar_vista($event, $autores);
    }
}
function set_obj_autor()
{
    $obj_Autor = new AutorModel();
    return $obj_Autor;
}
handler();
