<?php
$diccionario = array(
    'subtitulo' => array(
        VIEW_SET_EDITORIAL =>    'Crear EDITORIAL',
        VIEW_GET_EDITORIAL =>    'To EDITORIAL',
        VIEW_DELETE_EDITORIAL => 'El EDITORIAL',
        VIEW_EDIT_EDITORIAL =>   ' EDITORIAL'
    ),
    'links_menu' => array(
        'VIEW_SET_EDITORIAL' =>      MODULO . VIEW_SET_EDITORIAL . '/',
        'VIEW_GET_EDITORIAL' =>      MODULO . VIEW_GET_EDITORIAL . '/',
        'VIEW_EDIT_EDITORIAL' =>     MODULO . VIEW_EDIT_EDITORIAL . '/',
        'VIEW_DELETE_EDITORIAL' =>   MODULO . VIEW_DELETE_EDITORIAL . '/'
    ),
    'form_actions' => array(
        'SET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . SET_EDITORIAL . '/',
        'GET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . GET_EDITORIAL . '/',
        'DELETE' => '/dwp_2023_pf_bmanuel/' . MODULO . DELETE_EDITORIAL . '/',
        'EDIT' =>   '/dwp_2023_pf_bmanuel/' . MODULO . EDIT_EDITORIAL . '/'
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
    $file = '../frontend/html/editorial/editorial_' . $form . '.html';
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
        if (!empty($registro['Id']) && !empty($registro['Nombre'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $fila = '<tr id="' . $registro['Id'] . '">';
            $fila .= '<td>' . $contador_lista++ . '</td>';
            $fila .= '<td>' . $registro['Id'] . '</td>';
            $fila .= '<td>' . $registro['Nombre'] . '</td>';
            $fila .= '<td>' . '<a class="boton boton-outline-warning" href="#" onclick="editarAutor(' . $registro['Id'] . ')"><i class="bx bx-edit"></i>Editar</a>' . '</td>';
            $fila .= '<td>' . '<button class="boton boton-outline-danger" name="EliminarAutor" type="submit" value="' . $registro['Id'] . '"><i class="bx bx-trash"></i>Eliminar</button>' . '</td>';
            $tabla_body .= $fila . '</tr>';
        }
    }
    $tabla_body .= '</tbody>';


    ######fin tabla#######

    $html = str_replace('{contenido}', get_vista_html($vista), $html);
    $html = str_replace('{TBODY}', $tabla_body, $html);
    $html = str_replace('{ALERT}', $alert, $html);

    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);


    print $html;
}
