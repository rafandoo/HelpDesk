<?php
/* Checking if the user is logged in. If not, it redirects to the login page. */
    session_start();
    if(!isset($_SESSION['usuario'])){
        header('Location: login.php');
    }
?>
