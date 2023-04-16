<?php
$diccionario = array(
    'subtitulo' => array(
        VIEW_SET_AUTOR =>    'Crear un nuevo autor',
        VIEW_GET_AUTOR =>    'Todos Los Autores',
        VIEW_DELETE_AUTOR => 'Eliminar un autor',
        VIEW_EDIT_AUTOR =>   'Modificar autor'
    ),
    'links_menu' => array(
        'VIEW_SET_AUTOR' =>      MODULO . VIEW_SET_AUTOR . '/',
        'VIEW_GET_AUTOR' =>      MODULO . VIEW_GET_AUTOR . '/',
        'VIEW_EDIT_AUTOR' =>     MODULO . VIEW_EDIT_AUTOR . '/',
        'VIEW_DELETE_AUTOR' =>   MODULO . VIEW_DELETE_AUTOR . '/'
    ),
    'form_actions' => array(
        'SET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . SET_AUTOR . '/',
        'GET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . GET_AUTOR . '/',
        'DELETE' => '/dwp_2023_pf_bmanuel/' . MODULO . DELETE_AUTOR . '/',
        'EDIT' =>   '/dwp_2023_pf_bmanuel/' . MODULO . EDIT_AUTOR . '/'
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
    $file = '../frontend/html/autores/autor_' . $form . '.html';
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

function retornar_vista($vista, $data = array())
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
    $tabla_body = '<tbody>';
    $contador_lista = 1;
    foreach ($data['registros'] as $registro) {
        if (!empty($registro['Nombre']) && !empty($registro['Paterno'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $fila = '<tr id="' . $registro['Id'] . '">';
            $fila .= '<td>' . $contador_lista++ . '</td>';
            $fila .= '<td>' . $registro['Nombre'] . '</td>';
            $fila .= '<td>' . $registro['Paterno'] . '</td>';
            $fila .= '<td>' . $materno = !empty($registro['Materno']) ? $registro['Materno'] : '-' . '</td>';
            $fila .= '<td>' . '<a class="boton boton-outline-warning" href="#" onclick="editarAutor(' . $registro['Id'] . ')"><i class="bx bx-edit"></i>Editar</a>' . '</td>';
            $fila .= '<td>' . '<button class="boton boton-outline-danger" name="EliminarAutor" type="submit" value="' . $registro['Id'] . '"><i class="bx bx-trash"></i>Eliminar</button>' . '</td>';
            $tabla_body .= $fila . '</tr>';
        }
    }
    print $contador_lista-1;
    $tabla_body .= '</tbody>';


    ######fin tabla#######

    $html = str_replace('{contenido}', get_vista_html($vista), $html);
    $html = str_replace('{TBODY}', $tabla_body, $html);
    $html = str_replace('{ALERT}', $alert, $html);
    $html = str_replace('{total_autor}', $contador_lista, $html);

    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);

    print $html;
}
