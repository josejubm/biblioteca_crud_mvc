<?php
$diccionario = array(
    'subtitulo' => array(
        VIEW_SET_PRESTAMO =>    'add libro',
        VIEW_GET_PRESTAMO =>    'show libros',
        VIEW_DELETE_PRESTAMO => 'delete libro',
        VIEW_EDIT_PRESTAMO =>   'Modificar libro'
    ),
    'links_menu' => array(
        'VIEW_SET_PRESTAMO' =>      MODULO . VIEW_SET_PRESTAMO . '/',
        'VIEW_GET_PRESTAMO' =>      MODULO . VIEW_GET_PRESTAMO . '/',
        'VIEW_EDIT_PRESTAMO' =>     MODULO . VIEW_EDIT_PRESTAMO . '/',
        'VIEW_DELETE_PRESTAMO' =>   MODULO . VIEW_DELETE_PRESTAMO . '/'
    ),
    'form_actions' => array(
        'SET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . SET_PRESTAMO . '/',
        'GET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . GET_PRESTAMO . '/',
        'DELETE' => '/dwp_2023_pf_bmanuel/' . MODULO . DELETE_PRESTAMO . '/',
        'EDIT' =>   '/dwp_2023_pf_bmanuel/' . MODULO . EDIT_PRESTAMO . '/'
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
    $file = '../frontend/html/prestamos/prestamo_' . $form . '.html';
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

function retornar_vista($vista, $data = array(), $data_usuario = array(), $data_libro = array())
{
    global $diccionario;
    $html = get_main_template('template');
    $html = str_replace('{subtitulo}', $diccionario['subtitulo'][$vista], $html);
    ########### mensaje de alerta ###########
    if (is_array($data['mensaje']) && !empty($data['mensaje'])) {
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
    foreach ($data['registros'] as $registro) {
        if (!empty($registro['ISBN']) && !empty($registro['TITULO'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $idp = $registro['ClaveUsu'].$registro['ISBN'].$registro['SALIDA'] ;
            $fila = '<tr id="'. $idp.'">';
            $fila .= '<td>' . $contador_lista++ . '</td>';
            $fila .= '<td>' . $registro['ISBN'] . '</td>';
            $fila .= '<td>' . $registro['TITULO'] . '</td>';
            $fila .= '<td>' . $registro['ClaveUsu'] . '</td>';
            $fila .= '<td>' . $registro['NombreCompleto'] . '</td>';
            $fila .= '<td>' . $registro['SALIDA'] . '</td>';
            $fila .= '<td>' . $Devolucion = !empty($registro['DEVOLUCION']) ? $registro['DEVOLUCION'] : 'Pendiente: Sin Entregar' .  '</td>';

            $fila .= '<td>' . '<a class="boton boton-outline-warning" href="#" onclick="editarPrestamo(' . $comilla .$idp.$comilla . ')"><i class="bx bx-edit"></i>Editar</a>' . '</td>';
            $fila .= '<td>' . '<a class="boton boton-outline-danger" href="#" 
                                onclick="modalPrestamos(' 
                                .$comilla . $registro['ClaveUsu'] .$comilla.
                                ','.$comilla.$registro['ISBN'].$comilla.
                                ','. $comilla.$registro['SALIDA'].$comilla.
                                ','.$comilla.$registro['NombreCompleto'].$comilla.
                                ','. $comilla.$registro['TITULO'].$comilla.
                                ')"><i class="bx bx-trash"></i>Eliminar</a>'
                . '</td>';
            $tabla_body .= $fila . '</tr>';
        }
    }
    $tabla_body .= '</tbody>';


    ######fin tabla#######

    /* options del form USUARIOS*/
    $options_usuario = '';
    foreach ($data_usuario['registros'] as $usuario) {
        if (!empty($usuario['Id']) && !empty($usuario['Nombre'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $options_usuario .= '<option value="' . $usuario['Id'] . '">'
                . $usuario['Nombre'] . ' ' . $usuario['Paterno'] . ' ' . $usuario['Materno'] . '</option>';
        }
    }
    /* FIN options del form */

    /* options del form LIBROS  */
    $options_libro = '';
    foreach ($data_libro['libros'] as $libro) {
        if (!empty($libro['ISBN']) && !empty($libro['TITULO'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $options_libro .= '<option value="' . $libro['ISBN'] . '">'
                . $libro['TITULO'] . '</option>';
        }
    }
    /* FIN options del form */

    /* pone la vista del modulo en la pagina padre  */
    $html = str_replace('{contenido}', get_vista_html($vista), $html);
    /* el contenido de la tabla */
    $html = str_replace('{TBODY}', $tabla_body, $html);
    /* muestra la alerta */
    $html = str_replace('{ALERT}', $alert, $html);
    /* opcion del select del fomulario */
    $html = str_replace('{options_usuario}',  $options_usuario, $html);
    $html = str_replace('{options_libro}',  $options_libro, $html);
    /* pone el nombre del modulo en la pagina */
    $html = str_replace('{TABLA_NAME}',  'PRESTAMOS', $html);
    /* insertar estilos y escripts propios del modulo */
    $html = str_replace('<!--MODULO_JS-->',  '<script src="../../frontend/js/js_Prestamos.js"></script>', $html);


    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);

    print $html;
}
