<?php 
require_once('model.php');

if (isset($_POST)) {
    $user = new AuthModel();
    $AUTH = $user->auth($_POST);
if ($AUTH['status'] == 'SUCCESS') {
    session_start();
    $user = $AUTH['registro'];
    print $_SESSION['user_logueado'] = $user[0]['user'];
    header("Location: /dwp_2023_pf_bmanuel/home/get/");
}else{
    header("Location: /dwp_2023_pf_bmanuel/index.php");
}
}else{
    header("Location: /dwp_2023_pf_bmanuel/index.php");
}
