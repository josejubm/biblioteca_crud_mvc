<?php 

if (isset( $_SESSION["user_logueado"])){
    header("Location: /localhost/dwp_2023_pf_bmanuel/home/get/");
} else {
 header("Location: login.php");
}
?>