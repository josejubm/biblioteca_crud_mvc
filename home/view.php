<?php
$diccionario = array(
    'subtitulo' => array(
        VIEW_SET_EDITORIAL =>    'ADD EDITORIAL',
        VIEW_GET_EDITORIAL =>    'SHOW EDITORIAL',
        VIEW_DELETE_EDITORIAL => 'DELETE EDITORIAL',
        VIEW_EDIT_EDITORIAL =>   'UPDATE EDITORIAL'
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
    $file = '../frontend/html/home/home_' . $form . '.html';
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

    $html = str_replace('{contenido}', get_vista_html($vista), $html);
    $html = str_replace('{TABLA_NAME}', 'INICIO', $html);
    $html = str_replace('<!--MODULO_JS-->',  '<script src="../../frontend/js/js_Libros.js"></script>', $html);


    $html = render_dinamic_data($html, $diccionario['form_actions']);
    $html = render_dinamic_data($html, $diccionario['links_menu']);

    print $html;
}
