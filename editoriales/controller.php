<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');
function handler()
{
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
        print "entro al set";
            if (!empty($_POST) && $_POST['nombre'] != '') {
             $result = $editorial->set($_POST);
            
                $editoriales = $editorial->get();
                $editoriales['mensaje'] = $result;
                retornar_vista(VIEW_SET_EDITORIAL, $editoriales);
                $editoriales = array();
            } else {
                $editoriales = $editorial->get();
                retornar_vista(VIEW_SET_EDITORIAL, $editoriales);
            }
            break;
        case GET_EDITORIAL:
            $editoriales = $editorial->get();
            retornar_vista(VIEW_GET_EDITORIAL, $editoriales);
            break;
        case DELETE_EDITORIAL:
            if (!empty($_POST)) {
                $result_delete = $editorial->delete($_POST['EliminarEditorial']);
                $editoriales = $editorial->get();

                $editoriales['mensaje'] = $result_delete;

                // Verificar si hay un mensaje de eliminación
                if ($editoriales['mensaje']['tipo'] == 'success') {
                    // Mostrar el mensaje
                    echo $editoriales['mensaje'];
                    // Eliminar el registro correspondiente del array de registros
                    foreach ($editoriales['registros'] as $key => $registro) {
                        if ($registro['Id'] == $_POST['EliminarAutor']) {
                            unset($editoriales['registros'][$key]);
                            break;
                        }
                    }
                }
                retornar_vista(VIEW_SET_EDITORIAL, $editoriales);
                $_POST = array();
            } else {
                $editoriales = $editorial->get();
                retornar_vista(VIEW_SET_EDITORIAL, $editoriales);
            }
            /* header("Location: /dwp_2023_pf_bmanuel/autores/mostrar/"); */
           break;
       case EDIT_EDITORIAL:
        print_r($_POST);
            if (!empty($_POST) && $_POST['nombre'] != '') {
                $result_edited = $editorial->edit($_POST);
                $editoriales = $editorial->get();
                $editoriales['mensaje'] = $result_edited;                
                retornar_vista(VIEW_SET_EDITORIAL, $editoriales);
                $editoriales = array();
                $_POST = array();
            } else{
                $editoriales = $editorial->get();
                retornar_vista(VIEW_SET_EDITORIAL, $editoriales); 
            }
            break;
        default:

            print "defaulta case editorial";
            $editoriales = $editorial->get();
            print_r($editoriales);
            retornar_vista($event, $editoriales);
    }
}
function set_obj_editorial()
{
    $obj_Editorial = new EditorialModel();
    return $obj_Editorial;
}
handler();
