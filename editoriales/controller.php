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
               

                $data_insert['nombre'] = $_POST['nombre'];

                $result = $editorial->set($data_insert);

                print_r($result);

                $data_insert = array();
                $_POST = array();

                $autores = $editorial->get();
                $autores['mensaje'] = $result;
                retornar_vista(VIEW_SET_EDITORIAL, $autores);
                $autores = array();
            } else {
                $autores = $editorial->get();
                retornar_vista(VIEW_SET_EDITORIAL, $autores);
            }
            break;
         /*  case GET_EDITORIAL:
            $autores = $autor->get();
            retornar_vista(VIEW_GET_EDITORIAL, $autores);
            break;
        case DELETE_EDITORIAL:
            if (!empty($_POST)) {
                $result_delete = $autor->delete($_POST['EliminarAutor']);
                $autores = $autor->get();
                $autores['mensaje'] = $result_delete;
                // Verificar si hay un mensaje de eliminación
                if ($autores['mensaje']['tipo'] == 'success') {
                    // Mostrar el mensaje
                    echo $autores['mensaje'];
                    // Eliminar el registro correspondiente del array de registros
                    foreach ($autores['registros'] as $key => $registro) {
                        if ($registro['Id'] == $_POST['EliminarAutor']) {
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
           /*  break  */
       /*  case EDIT_EDITORIAL:
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
            break; */
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
