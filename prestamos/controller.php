<?php
require_once('constants.php');
require_once('model.php');
require_once('view.php');

require_once('../editoriales/model.php');
require_once('../autores/model.php');

function handler()
{
    /*     // redirigir a la vista VIEW_GET_AUTOR si no se especifica ninguna petición
    if (empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] === MODULO) {
        header("Location: " . MODULO . VIEW_GET_LIBRO . "/");
        exit();
    } */

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

                print_r($_POST);
               $result_set = $libro->set($_POST);

               print_r($result_set);

                $autor = new AutorModel();
                $autores = $autor->get();

                $editorial = new EditorialModel;
                $editoriales = $editorial->get();

                $libros = $libro->get();
                $libros['mensaje'] = $result_set;
                retornar_vista(VIEW_SET_LIBRO, $libros, $autores, $editoriales);
            } else {

                $autor = new AutorModel();
                $autores = $autor->get();

                $editorial = new EditorialModel;
                $editoriales = $editorial->get();

                $libros = $libro->get();
                retornar_vista(VIEW_SET_LIBRO, $libros, $autores, $editoriales);
            }
            break;
        case GET_LIBRO:
            $libros = $libro->get();
            retornar_vista(VIEW_SET_LIBRO, $libros);
            break;
        case DELETE_LIBRO:
            if (!empty($_POST)) {
                $result_delete = $libro->delete($_POST['id_delete']);
                $libros = $libro->get();
                $libros['mensaje'] = $result_delete;
                // Verificar si hay un mensaje de eliminación
                if ($libros['mensaje']['tipo'] == 'success') {
                    // Mostrar el mensaje
                    echo $libros['mensaje'];
                    // Eliminar el registro correspondiente del array de registros
                    foreach ($libros['registros'] as $key => $registro) {
                        if ($registro['Id'] == $_POST['id_delete']) {
                            unset($libros['registros'][$key]);
                            break;
                        }
                    }
                }
                $autor = new AutorModel();
                $autores = $autor->get();
                $editorial = new EditorialModel;
                $editoriales = $editorial->get();
                retornar_vista(VIEW_SET_LIBRO, $libros, $autores, $editoriales);
                $_POST = array();
            } else {
                $autor = new AutorModel();
                $autores = $autor->get();
                $editorial = new EditorialModel;
                $editoriales = $editorial->get();
                $libros = $libro->get();
                retornar_vista(VIEW_SET_LIBRO, $libros, $autores, $editoriales);
            }
            break;
        case EDIT_LIBRO:
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
            $autores = $libro->get();
            retornar_vista($event, $autores);
    }
}
function set_obj_libro()
{
    $obj = new LibroModel();
    return $obj;
}
handler();
