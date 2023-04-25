<?php
# Importar modelo de abstracción de base de datos
require_once('../core/db_abstract_model.php');

class EditorialModel extends DBAbstractModel
{

    public function get()
    {
        $this->query = "SELECT * FROM editoriales";
        $this->get_results_from_query();

        if (!$this->rows) {
            return [
                'mensaje' => 'No se encontraron EDITORIALES',
                'registros' => []
            ];
        }
        $resultados = array_map(function ($row) {
            return [
                'Id' => $row['Id'],
                'Nombre' => $row['Nombre'],
            ];
        }, $this->rows);

        return [
            'mensaje' => 'EDITORIALES ENCONTRADAS',
            'registros' => $resultados
        ];
    }

    public function set($data_insert = array())
    {
        $nombre  = $data_insert['nombre'];

        // Comprobar si los datos del autor ya existen
        $this->query = "SELECT Id FROM editoriales WHERE Nombre='$nombre' ";
        $this->get_results_from_query();

        if (count($this->rows) > 0) {

            $mensaje = "Error: La editorial [ $nombre  ] ya existe";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        } else {
            // Insertar los datos del autor
            $this->query = "INSERT INTO editoriales (Nombre) VALUES ('$nombre')";
            $this->execute_single_query();

            $mensaje = "Autor [ $nombre ] agregado correctamente";

            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        }
    }

    public function edit($data_new = array())
    {
        $id_old = $data_new['id_old'];
        $nombre = $data_new['nombre'];

         // Comprobar si los datos del autor existen
         $this->query = "SELECT * FROM editoriales WHERE Id ='$id_old'";
         $this->get_results_from_query();
         $data  = $this->rows;
         if (count($this->rows) > 0) {
            $this->query = "UPDATE editoriales SET Nombre='$nombre' WHERE Id=$id_old";
            $this->execute_single_query();
 
             $mensaje = $this->mensaje = "SE MODIFICO LA EDITORIAL: " . $data[0]['Nombre'] . "";
             return array(
                 'tipo' => "success",
                 'menss' => $mensaje
             );
         } else {
             $mensaje = "NO SE PUDO MODIFICAR LA EDITORIAL";
             return array(
                 'tipo' => "error",
                 'menss' => $mensaje
             );
         }
     }
    

    public function delete($id = '')
    {
        // Comprobar si los datos del autor existen
        $this->query = "SELECT * FROM editoriales WHERE Id ='$id'";
        $this->get_results_from_query();
        $data  = $this->rows;

        if (count($this->rows) > 0) {
            $this->query = "DELETE FROM editoriales WHERE id=$id";
            $this->execute_single_query();

            $mensaje = $this->mensaje = "SE ELIMINO La EDITORIAL: " . $data[0]['Nombre'] . "";
            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        } else {
            $mensaje = "NO EXISTE LA EDITORIAL";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        }
    }
}
