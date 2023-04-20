<?php
# Importar modelo de abstracción de base de datos
require_once('../core/db_abstract_model.php');

class LibroModel extends DBAbstractModel
{
    public function get()
    {
        $this->query = "SELECT libros.ISBN AS ISBN, libros.Titulo AS TITULO, editoriales.Id AS ID_EDITORIAL, editoriales.Nombre AS NOMBRE_EDITORIAL 
                    FROM libros, editoriales 
                    WHERE libros.editorial_Id = editoriales.Id;";
        $this->get_results_from_query();

        if (!$this->rows) {
            return [
                'mensaje' => 'No se encontraron los libros',
                'libros' => []
            ];
        }

        $resultados = [];

        foreach ($this->rows as $row) {
            // obtener los autores correspondientes a este libro
            $query_autores = "SELECT libros_autores.ISBN AS ISBN, autores.Id AS ID_AUTOR, CONCAT(autores.Nombre, ' ', autores.Paterno, ' ', autores.Materno) AS NOMBRE_COMPLETO_AUTOR
                          FROM autores, libros_autores
                          WHERE libros_autores.ISBN = '{$row['ISBN']}' AND libros_autores.autor_Id = autores.Id;";
            $this->query = $query_autores;
            $this->get_results_from_query();

            $autores = [];

            if ($this->rows) {
                foreach ($this->rows as $autor) {
                    if (!empty($autor['ID_AUTOR']) && !empty($autor['NOMBRE_COMPLETO_AUTOR'])) {
                        $autores[] = [
                            'ISBN_LIBRO' => $autor['ISBN'],
                            'ID_AUTOR' => $autor['ID_AUTOR'],
                            'NOMBRE_COMPLETO_AUTOR' => $autor['NOMBRE_COMPLETO_AUTOR']
                        ];
                    }
                }
            }

            $resultados[] = [
                'ISBN' => $row['ISBN'],
                'TITULO' => $row['TITULO'],
                'ID_EDITORIAL' => $row['ID_EDITORIAL'],
                'NOMBRE_EDITORIAL' => $row['NOMBRE_EDITORIAL'],
                'AUTORES' => $autores
            ];
        }

        return [
            'mensaje' => 'Libros encontrados',
            'libros' => $resultados
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


    public function edit($data_update = array())
    {
        $isbn = $data_update['isbn'];
        $titulo = $data_update['titulo'];
        $editorial = $data_update['editorial'];
        $autores = $data_update['autores'];
        $isbn_old = $data_update['isbn_old'];
    
        // Comprobar si el libro ya existe
        $this->query = "SELECT * FROM libros WHERE ISBN='$isbn_old'";
        $this->get_results_from_query();
    
        if (count($this->rows) == 0) {
            $mensaje = "Error: El Libro con ISBN [ $isbn_old ] no existe";
            return array(
                'tipo' => "error",
                'menss' => $mensaje
            );
        } else {
            // Actualizar los datos 
            $this->query = "UPDATE libros SET ISBN='$isbn', Titulo='$titulo', editorial_Id='$editorial' WHERE ISBN='$isbn_old'";
            $this->execute_single_query();
    
            // Eliminar autores actuales del libro
            $this->query = "DELETE FROM libros_autores WHERE ISBN='$isbn_old'";
            $this->execute_single_query();
    
            // Insertar autores actualizados del libro
            foreach ($autores as $autor) {
                $this->query = "INSERT INTO libros_autores (ISBN, autor_Id) VALUES ('$isbn', '$autor')";
                $this->execute_single_query();
            }
    
            $mensaje = "LIBRO  [ $titulo ] actualizado correctamente";
            return array(
                'tipo' => "success",
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
