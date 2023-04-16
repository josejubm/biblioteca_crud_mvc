<?php
# Importar modelo de abstracción de base de datos
require_once('../core/db_abstract_model.php');

class LibroModel extends DBAbstractModel
{

    public function get()
    {
        $this->query = "SELECT 
                            libros.ISBN AS ISBN, 
                            libros.Titulo AS TITULO, 
                            GROUP_CONCAT(CONCAT(autores.Nombre, ' ', autores.Paterno, ' ', autores.Materno)SEPARATOR ',<br>\n ') AS AUTOR,
                            editoriales.Nombre AS EDITORIAL
                        FROM 
                            libros, autores, editoriales, libros_autores
                        WHERE 
                            libros.ISBN = libros_autores.ISBN 
                            AND libros_autores.autor_Id = autores.Id 
                            AND libros.editorial_Id = editoriales.Id
                        GROUP BY 
                            libros.ISBN;
                        ;
                        ";
        $this->get_results_from_query();

        if (!$this->rows) {
            return [
                'mensaje' => 'No se encontraron los libros',
                'registros' => []
            ];
        }
        $resultados = array_map(function ($row) {
            return [
                'ISBN' => $row['ISBN'],
                'TITULO' => $row['TITULO'],
                'AUTOR' => $row['AUTOR'],
                'EDITORIAL' => $row['EDITORIAL']
            ];
        }, $this->rows);

        return [
            'mensaje' => 'Libros encontrados',
            'registros' => $resultados
        ];
    }

    public function set($data_insert = array())
    {
        $isbn = $data_insert['isbn'];
        $titulo = $data_insert['titulo'];
        $editorial = $data_insert['editorial'];
        $autores = $data_insert['autores'];

        // Comprobar si los datos ya existen
        $this->query = "SELECT * FROM libros WHERE ISBN='$isbn' AND Titulo='$titulo' AND editorial_id='$editorial'";
        $this->get_results_from_query();

        if (count($this->rows) > 0) {
            $mensaje = "Error: El Libro [ $titulo ] ya existe";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        } else {
            // Insertar los datos 
            $this->query = "INSERT INTO libros (ISBN, Titulo, editorial_Id) VALUES ('$isbn', '$titulo', '$editorial')";
            $this->execute_single_query();

            foreach ($autores as $autor) {
                $this->query = "INSERT INTO libros_autores (ISBN, autor_Id) VALUES ('$isbn', '$autor')";
                $this->execute_single_query();
            }

            $mensaje = "LIBRO  [ $titulo ] agregado correctamente";
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

            $mensaje = $this->mensaje = "SE MODIFICO EL AUTOR: " . $data[0]['Nombre'] . " " . $data[0]['Paterno'] . " " . $data[0]['Materno'] . "";
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
        // Comprobar si los dato existen
        $this->query = "SELECT * FROM libros WHERE ISBN ='$id'";
        $this->get_results_from_query();
        $data  = $this->rows;

        if (count($this->rows) > 0) {
            $this->query = "DELETE FROM libros WHERE ISBN=$id";
            $this->execute_single_query();

            $mensaje = $this->mensaje = "SE ELIMINO EL LIBRO: " . $data[0]['Titulo'] . "";
            return array(
                'tipo' => "success",
                'menss' => $mensaje
            );
        } else {
            $mensaje = "NO EXISTE EL LIBRO";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        }
    }
}
