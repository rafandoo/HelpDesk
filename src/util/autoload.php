<?php
    spl_autoload_register(function ($nomeClasse) {
    if (file_exists("classes".DIRECTORY_SEPARATOR.$nomeClasse.".class.php"))
        require_once("classes".DIRECTORY_SEPARATOR.$nomeClasse.".class.php");
    });
?>
