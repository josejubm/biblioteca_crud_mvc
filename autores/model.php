<?php
# Importar modelo de abstracción de base de datos
require_once('../core/db_abstract_model.php');

class AutorModel extends DBAbstractModel
{

    public function get()
    {
        $this->query = "SELECT * FROM autores";
        $this->get_results_from_query();

        if (!$this->rows) {
            return [
                'mensaje' => 'No se encontraron autores',
                'registros' => []
            ];
        }
        $resultados = array_map(function ($row) {
            return [
                'Id' => $row['Id'],
                'Nombre' => $row['Nombre'],
                'Paterno' => $row['Paterno'],
                'Materno' => $row['Materno']
            ];
        }, $this->rows);

        return [
            'mensaje' => 'Autores encontrados',
            'registros' => $resultados
        ];
    }

    public function set($autor_data_insert = array())
    {
        $nombre  = $autor_data_insert['nombre'];
        $paterno = $autor_data_insert['paterno'];
        $materno = $autor_data_insert['materno'];

        // Comprobar si los datos del autor ya existen
        $this->query = "SELECT Id FROM autores WHERE Nombre='$nombre' AND Paterno='$paterno' AND Materno='$materno'";
        $this->get_results_from_query();

        if (count($this->rows) > 0) {

            $mensaje = "Error: El Autor [ $nombre $paterno $materno ] ya existe";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        } else {
            // Insertar los datos del autor
            $this->query = "INSERT INTO autores (Nombre, Paterno, Materno) VALUES ('$nombre', '$paterno', '$materno')";
            $this->execute_single_query();

            $mensaje = "Autor [ $nombre $paterno $materno ] agregado correctamente";

            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        }
    }

    public function edit($data_new = array())
    {
        $id = $data_new['id_old'];
        $nombre =  $data_new['nombre'];
        $paterno = $data_new['paterno'];
        $materno = $data_new['materno'];
            
         // Comprobar si los datos del autor existen
         $this->query = "SELECT Id, Nombre, Paterno, Materno FROM autores WHERE Id ='$id'";
         $this->get_results_from_query();
         $data  = $this->rows;
         if (count($this->rows) > 0) {
            $this->query = "UPDATE autores SET Nombre='$nombre', Paterno='$paterno' , Materno='$materno'WHERE id=$id";
            $this->execute_single_query();
 
             $mensaje = $this->mensaje = "SE MODIFICO EL AUTOR: " . $data[0]['Nombre'] . " " . $data[0]['Paterno'] ." " . $data[0]['Materno'] . "";
             return array(
                 'tipo' => "success",
                 'menss' => $mensaje
             );
         } else {
             $mensaje = "NO SE PUDO MODIFICAR AL AUTOR";
             return array(
                 'tipo' => "error",
                 'menss' => $mensaje
             );
         }
     }
    

    public function delete($id = '')
    {
        // Comprobar si los datos del autor existen
        $this->query = "SELECT Id, Nombre, Paterno, Materno FROM autores WHERE Id ='$id'";
        $this->get_results_from_query();
        $data  = $this->rows;

        if (count($this->rows) > 0) {
            $this->query = "DELETE FROM autores WHERE id=$id";
            $this->execute_single_query();

            $mensaje = $this->mensaje = "SE ELIMINO EL AUTOR: " . $data[0]['Nombre'] . " " . $data[0]['Paterno'] ." " . $data[0]['Materno'] . "";
            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        } else {
            $mensaje = "NO EXISTE EL AUTOR";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        }
    }

   
}
