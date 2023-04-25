<?php
$diccionario = array(
    'subtitulo' => array(
        VIEW_SET_LIBRO =>    'Agregar Libro',
        VIEW_GET_LIBRO =>    'Ver Libros',
        VIEW_DELETE_LIBRO => 'Eliminar Libro',
        VIEW_EDIT_LIBRO =>   'Modificar Libro'
    ),
    'links_menu' => array(
        'VIEW_SET_LIBRO' =>      MODULO . VIEW_SET_LIBRO . '/',
        'VIEW_GET_LIBRO' =>      MODULO . VIEW_GET_LIBRO . '/',
        'VIEW_EDIT_LIBRO' =>     MODULO . VIEW_EDIT_LIBRO . '/',
        'VIEW_DELETE_LIBRO' =>   MODULO . VIEW_DELETE_LIBRO . '/'
    ),
    'form_actions' => array(
        'SET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . SET_LIBRO . '/',
        'GET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . GET_LIBRO . '/',
        'DELETE' => '/dwp_2023_pf_bmanuel/' . MODULO . DELETE_LIBRO . '/',
        'EDIT' =>   '/dwp_2023_pf_bmanuel/' . MODULO . EDIT_LIBRO . '/'
    )
);

function get_main_template($value = 'header or footer file')
{
    $file = '../frontend/html/main_' . $value . '.html';
    $main_template = file_get_contents($file);
    return $main_template;
}

function get_vista_html($form = 'get')
{
    $file = '../frontend/html/libros/libro_' . $form . '.html';
    $template = file_get_contents($file);
    return $template;
}

function render_dinamic_data($html, $data)
{
    foreach ($data as $clave => $valor) {
        $html = str_replace('{' . $clave . '}', $valor, $html);
    }
    return $html;
}

function retornar_vista($vista, $data = array(), $data_autor = array(), $data_editorial = array())
{
    global $diccionario;
    $html = get_main_template('template');
    $html = str_replace(
        '{subtitulo}',
        $diccionario['subtitulo'][$vista],
        $html
    );

    if (is_array($data['mensaje']) && !empty($data['mensaje'])) {
        ########### mensaje de alerta ###########
        if ($data['mensaje']['tipo'] == 'success') {
            $mensaje = $data['mensaje']['menss'];
            $alert = '<div class="alert success">
                    <span class="closebtn">&times;</span>
                    <i class="bx bx-check-circle"></i>
                    <strong>¡Éxito!</strong> ' . $mensaje . '.
                </div>';
        } else if ($data['mensaje']['tipo'] == 'error') {
            $mensaje = $data['mensaje']['menss'];
            $alert = '<div class="alert error">
                    <span class="closebtn">&times;</span>
                    <i class="bx bx-error-alt"></i>
                    <strong>¡Error!</strong>' . $mensaje . '.
                </div>';
        } else {
            $alert = ' <div class="alert warning">
                    <span class="closebtn">&times;</span>
                    <i class="bx bx-warning"></i>
                    <strong>¡Advertencia!</strong> Ocurrio un error .
                </div> ';
        }
    } else {
        $alert = "";
    }
    ########### fin mensaje de alerta ########

    #######tabla contenido###
    $comilla = "'";
    $tabla_body = '<tbody>';
    $contador_lista = 1;
    foreach ($data['libros'] as $registro) {
        if (!empty($registro['ISBN']) && !empty($registro['TITULO'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $fila = '<tr id="' . $registro['ISBN'] . '">';
            $fila .= '<td>' . $contador_lista++ . '</td>';
            $fila .= '<td>' . $registro['ISBN'] . '</td>';
            $fila .= '<td>' . $registro['TITULO'] . '</td>';
            $fila .= '<td  class="celda_oculta">' . $registro['ID_EDITORIAL'] . '</td>';
            $fila .= '<td>' . $registro['NOMBRE_EDITORIAL'] . '</td>';

            /*  foreach ($registro['AUTORES'] as $autor) {
                if ($registro['ISBN'] === $autor['ISBN_LIBRO']) {
                    $fila .= '<td class="celda_oculta">' . $autor['ID_AUTOR'] . '</td>'; // Agregar el ID de autor en la fila
                    $fila .= '<td class="celda_oculta">' . $autor['NOMBRE_COMPLETO_AUTOR'] . '</td>';
                }
            } */

            $fila .= '<td class="celda_oculta">';
            foreach ($registro['AUTORES'] as $autor) {
                if ($registro['ISBN'] === $autor['ISBN_LIBRO']) {
                    $fila .=  $autor['ID_AUTOR'] . '-';
                }
            }
            $fila = rtrim($fila, '-'); 
            $fila .= '</td>';

            $fila .= '<td>';
            foreach ($registro['AUTORES'] as $autor) {
                if ($registro['ISBN'] === $autor['ISBN_LIBRO']) {
                    $fila .= $autor['NOMBRE_COMPLETO_AUTOR'] . ',';
                }
            }
            $fila = rtrim($fila, ','); // Eliminar la última coma y espacio en blanco
            $fila .= '</td>';

            $fila .= '<td>' . '<a class="boton boton-outline-warning" href="#" onclick="editarLibro(' . $comilla . $registro['ISBN'] . $comilla . ')"><i class="bx bx-edit"></i>Editar</a>' . '</td>';
            $fila .= '<td>' . '<a class="boton boton-outline-danger" href="#" onclick="mostrarModal(' . $comilla . $registro['ISBN'] . $comilla . ',' . $comilla . $registro['TITULO'] . $comilla . ')"><i class="bx bx-trash"></i>Eliminar</a>'
                . '</td>';
            $tabla_body .= $fila . '</tr>';
        }
    }
    $tabla_body .= '</tbody>';


    ######fin tabla#######

    /* options del form AUTORES*/
    $options_autor = '';
    foreach ($data_autor['registros'] as $autor) {
        if (!empty($autor['Id']) && !empty($autor['Nombre'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $options_autor .= '<option value="' . $autor['Id'] . '">'
                . $autor['Nombre'] . ' ' . $autor['Paterno'] . ' ' . $autor['Materno'] . '</option>';
        }
    }
    /* FIN options del form */
    /* options del form EDITORIALES */
    $options_editorial = '';
    foreach ($data_editorial['registros'] as $editorial) {
        if (!empty($editorial['Id']) && !empty($editorial['Nombre'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $options_editorial .= '<option value="' . $editorial['Id'] . '">'
                . $editorial['Nombre'] . '</option>';
        }
    }
    /* FIN options del form */

    $html = str_replace('{contenido}', get_vista_html($vista), $html);
    $html = str_replace('{TBODY}', $tabla_body, $html);
    $html = str_replace('{ALERT}', $alert, $html);
    $html = str_replace('{options_autor}',  $options_autor, $html);
    $html = str_replace('{options_editorial}',  $options_editorial, $html);
    $html = str_replace('{TABLA_NAME}',  'LIBROS', $html);
    $html = str_replace('<!--MODULO_JS-->',  '<script src="../../frontend/js/js_Libros.js"></script>', $html);



    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);

    print $html;
}
