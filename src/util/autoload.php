<?php
    /* A function that is called when a class is called. It checks if the class exists and if it does it
    requires it. */
    spl_autoload_register(function ($nomeClasse) {
        if (file_exists("..\\class\\".$nomeClasse.".class.php")) {
            require_once("..\\class\\".$nomeClasse.".class.php");
            echo "Require: ".$nomeClasse."<br>";
        } else if (file_exists("..\\src\\class\\".$nomeClasse.".class.php")) {
            require_once("..\\src\\class\\".$nomeClasse.".class.php");
            echo "Require: ".$nomeClasse."<br>";
        } else if ("action\\".$nomeClasse.".php") {
            require_once("action\\".$nomeClasse.".php");
            echo "Require: ".$nomeClasse."<br>";
        } else {
            echo "Classe não encontrada";
        }
    });
?>
