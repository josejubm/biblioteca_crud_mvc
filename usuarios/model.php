<?php
# Importar modelo de abstracción de base de datos
require_once('../core/db_abstract_model.php');

class UsuarioModel extends DBAbstractModel
{

    public function get()
    {
        $this->query = "SELECT * FROM usuarios";
        $this->get_results_from_query();

        if (!$this->rows) {
            return [
                'mensaje' => 'No se encontraron usuarios',
                'registros' => []
            ];
        }
        $resultados = array_map(function ($row) {
            return [
                'Id' => $row['ClaveUsu'],
                'Nombre' => $row['Nombre'],
                'Paterno' => $row['Paterno'],
                'Materno' => $row['Materno'],
                'Colonia' => $row['Colonia'],
                'Calle' => $row['Calle'],
                'Numero' => $row['Numero'],
                'Telefono' => $row['Telefono']
            ];
        }, $this->rows);

        return [
            'mensaje' => 'USUARIOS encontrados',
            'registros' => $resultados
        ];
    }

    public function set($data_insert = array())
    {
        $id  = $data_insert['ClaveUsu'];
        $nombre  = $data_insert['nombre'];
        $paterno = $data_insert['paterno'];
        $materno = $data_insert['materno'];
        $colonia = $data_insert['colonia'];
        $calle = $data_insert['calle'];
        $numero = $data_insert['numero'];
        $telefono = $data_insert['telefono'];

        // Comprobar si los datos del usuarios ya existen
        $this->query = "SELECT * FROM usuarios WHERE ClaveUsu = '$id' ";
        $this->get_results_from_query();

        if (count($this->rows) > 0) {

            $mensaje = "Error: El Usuarios [ $nombre $paterno $materno ] ya existe";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        } else {
            // Insertar los datos del Usuario
            $this->query = "INSERT INTO usuarios (ClaveUsu, Nombre, Paterno, Materno, Colonia, Calle, Numero, Telefono)
                            VALUES ('$id','$nombre', '$paterno', '$materno', '$colonia', '$calle', '$numero', '$telefono')";
            $this->execute_single_query();

            $mensaje = "usuario [ $nombre $paterno $materno ] agregado correctamente";

            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        }
    }

    public function edit($data_new = array())
    {
        $id_old = $data_new['id_old'];
        $id  = $data_new['ClaveUsu'];
        $nombre  = $data_new['nombre'];
        $paterno = $data_new['paterno'];
        $materno = $data_new['materno'];
        $colonia = $data_new['colonia'];
        $calle = $data_new['calle'];
        $numero = $data_new['numero'];
        $telefono = $data_new['telefono'];
            
         // Comprobar si los datos del autor existen
         $this->query = "SELECT * FROM usuarios WHERE ClaveUsu ='$id_old'";
         $this->get_results_from_query();
         $data  = $this->rows;
         if (count($this->rows) > 0) {
            $this->query = "UPDATE usuarios SET
                            ClaveUsu='$id',
                            Nombre='$nombre',
                            Paterno='$paterno',
                            Materno='$materno',
                            Colonia='$colonia',
                            Calle='$calle',
                            Numero='$numero',
                            Telefono = '$telefono'
                            WHERE ClaveUso=$id_old";
            $this->execute_single_query();
 
             $mensaje = $this->mensaje = "SE MODIFICO EL USUARIO: " . $data[0]['Nombre'] . " " . $data[0]['Paterno'] ." " . $data[0]['Materno'] . "";
             return array(
                 'tipo' => "success",
                 'menss' => $mensaje
             );
         } else {
             $mensaje = "NO SE PUDO MODIFICAR AL USUARIO";
             return array(
                 'tipo' => "error",
                 'menss' => $mensaje
             );
         }
     }
    

    public function delete($id = '')
    {
        // Comprobar si los datos del usuarios existen
        $this->query = "SELECT * FROM usuarios WHERE ClaveUsu ='$id'";
        $this->get_results_from_query();
        $data  = $this->rows;

        if (count($this->rows) > 0) {
            $this->query = "DELETE FROM usuarios WHERE ClaveUsu=$id";
            $this->execute_single_query();

            $mensaje = $this->mensaje = "SE ELIMINO EL USUARIO: " . $data[0]['Nombre'] . " " . $data[0]['Paterno'] ." " . $data[0]['Materno'] . "";
            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        } else {
            $mensaje = "NO EXISTE EL USUARIO";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        }
    }
}
