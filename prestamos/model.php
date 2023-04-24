<?php
# Importar modelo de abstracción de base de datos
require_once('../core/db_abstract_model.php');

class PrestamoModel extends DBAbstractModel
{

    public function get()
    {
        $this->query = "SELECT libros.ISBN AS ISBN,  libros.Titulo AS TITULO, usuarios.ClaveUsu, 
                                CONCAT(usuarios.Nombre, ' ', usuarios.Paterno, ' ', usuarios.Materno) AS NombreCompleto, prestamos.Salida AS SALIDA, prestamos.Devolucion AS DEVOLUCION
                        FROM prestamos, libros, usuarios
                        WHERE prestamos.ISBN = libros.ISBN AND prestamos.ClaveUsu = usuarios.ClaveUsu;
                        ";
        $this->get_results_from_query();

        if (!$this->rows) {
            return [
                'mensaje' => 'No se encontraron los Prestamos',
                'registros' => []
            ];
        }
        $resultados = array_map(function ($row) {
            return [
                'ISBN' => $row['ISBN'],
                'TITULO' => $row['TITULO'],
                'ClaveUsu' => $row['ClaveUsu'],
                'NombreCompleto' => $row['NombreCompleto'],
                'SALIDA' => $row['SALIDA'],
                'DEVOLUCION' => $row['DEVOLUCION']
            ];
        }, $this->rows);

        return [
            'mensaje' => 'Prestamos Encontrados',
            'registros' => $resultados
        ];
    }

    public function set($data_insert = array())
    {
        $isbn = $data_insert['libro'];
        $claveUsu = $data_insert['usuario'];
        $salida = $data_insert['salida'];

        // Insertar los datos en la tabla de préstamos
        $this->query = "INSERT INTO prestamos   (Salida, Devolucion, ClaveUsu, ISBN) 
                                        VALUES  ('$salida', null    ,  '$claveUsu', '$isbn' )";
        $this->execute_single_query();

        $mensaje = "Préstamo del libro con ISBN $isbn registrado correctamente";
        return array(
            'tipo' => "success",
            'menss' => $mensaje
        );
    }



    public function edit($data_new = array())
    {
        $salida = $data_new['salida'];
        $devolucion = $data_new['devolucion'];
        $claveUsu = $data_new['usuario'];
        $isbn = $data_new['libro'];


        // Comprobar si los datos del autor existen
        $this->query = "SELECT * FROM prestamos WHERE Salida = '$salida' AND ClaveUsu='$claveUsu' AND ISBN = '$isbn' ;";
        $this->get_results_from_query();
        $data  = $this->rows;
        if (count($this->rows) > 0) {
            $this->query = "UPDATE prestamos SET Salida='$salida', Devolucion='$devolucion' , ClaveUsu='$claveUsu', ISBN ='$isbn' 
                            WHERE Salida = '$salida' AND ClaveUsu='$claveUsu' AND ISBN = '$isbn' ";
            $this->execute_single_query();

            $mensaje = $this->mensaje = "SE MODIFICO EL PRESTAMO DEL LIBRO". $data[0]['ISBN'] ." CON FECHA DE SALIDA: " . $data[0]['Salida'] . "";
            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        } else {
            $mensaje = "NO SE PUDO MODIFICAR AL PRESTAMO";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        }
    }


    public function delete($DATA = '')
    {
        $salida = $DATA['salida'];
        $claveUsu = $DATA['user_id'];
        $isbn = $DATA['isbn'];

        // Comprobar si los dato existen
        $this->query = "SELECT * FROM prestamos WHERE Salida = '$salida' AND ClaveUsu='$claveUsu' AND ISBN = '$isbn' ;";
        $this->get_results_from_query();
        $data  = $this->rows;

        if (count($this->rows) > 0) {
            $this->query = "DELETE FROM prestamos WHERE Salida = '$salida' AND ClaveUsu='$claveUsu' AND ISBN = '$isbn' ;";
            $this->execute_single_query();

            $mensaje = $this->mensaje = "SE ELIMINO EL PRESTAMO";
            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        } else {
            $mensaje = "NO EXISTE EL PRESTAMO";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        }
    }
}
