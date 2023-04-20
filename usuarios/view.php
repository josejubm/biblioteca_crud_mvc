<?php
$diccionario = array(
    'subtitulo' => array(
        VIEW_SET_USUARIO =>    'Add User',
        VIEW_GET_USUARIO =>    'Show Users',
        VIEW_DELETE_USUARIO => 'Delete User',
        VIEW_EDIT_USUARIO =>   'Update User'
    ),
    'links_menu' => array(
        'VIEW_SET_USUARIO' =>      MODULO . VIEW_SET_USUARIO . '/',
        'VIEW_GET_USUARIO' =>      MODULO . VIEW_GET_USUARIO . '/',
        'VIEW_EDIT_USUARIO' =>     MODULO . VIEW_EDIT_USUARIO . '/',
        'VIEW_DELETE_USUARIO' =>   MODULO . VIEW_DELETE_USUARIO . '/'
    ),
    'form_actions' => array(
        'SET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . SET_USUARIO . '/',
        'GET' =>    '/dwp_2023_pf_bmanuel/' . MODULO . GET_USUARIO . '/',
        'DELETE' => '/dwp_2023_pf_bmanuel/' . MODULO . DELETE_USUARIO . '/',
        'EDIT' =>   '/dwp_2023_pf_bmanuel/' . MODULO . EDIT_USUARIO . '/'
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
    $file = '../frontend/html/usuarios/usuario_' . $form . '.html';
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
    
    #######tabla contenido USUARIOS###
    $comilla = "'";
    $tabla_body = '<tbody>';
    $contador_lista = 1;
    foreach ($data['registros'] as $registro) {
        if (!empty($registro['Nombre']) && !empty($registro['Paterno'])) // Se verifica que el campo Nombre no esté vacío 
        {
            $fila = '<tr id="' . $registro['Id'] . '">';
            $fila .= '<td>' . $contador_lista++ . '</td>';
            $fila .= '<td>' . $registro['Id'] . '</td>';
            $fila .= '<td class="celda_oculta">' . $registro['Nombre'] . '</td>';
            $fila .= '<td class="celda_oculta">' . $registro['Paterno'] . '</td>';
            $fila .= '<td class="celda_oculta">' . $materno = !empty($registro['Materno']) ? $registro['Materno'] : '-' . '</td>';
            $fila .= '<td>' . $registro['Nombre'] .' '. $registro['Paterno'].' ' .$materno = !empty($registro['Materno']) ? $registro['Materno'] : '-'. '</td>';
            $fila .= '<td>' . $registro['Colonia'] . '</td>';
            $fila .= '<td>' . $registro['Calle'] . '</td>';
            $fila .= '<td>' . $registro['Numero'] . '</td>';
            $fila .= '<td>' . $registro['Telefono'] . '</td>';
            $fila .= '<td>' . '<a class="boton boton-outline-warning" href="#" onclick="editarUsuario(' . $comilla. $registro['Id'] .$comilla. ')"><i class="bx bx-edit"></i>Editar</a>' . '</td>';
            $fila .= '<td>' . '<a class="boton boton-outline-danger" href="#" onclick="mostrarModal(' . $comilla.$registro['Id'] .$comilla. ','.$comilla. $registro['Nombre'] .' '.$registro['Paterno'] .$comilla. ')"><i class="bx bx-trash"></i>Eliminar</a>' 
                            . '</td>';
            $tabla_body .= $fila . '</tr>';
        }
    }
    $tabla_body .= '</tbody>';


    ######fin tabla#######

    $html = str_replace('{contenido}', get_vista_html($vista), $html);
    $html = str_replace('{TBODY}', $tabla_body, $html);
    $html = str_replace('{ALERT}', $alert, $html);
    $html = str_replace('{TABLA_NAME}', 'USUARIOS', $html);

    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);

    print $html;
}
