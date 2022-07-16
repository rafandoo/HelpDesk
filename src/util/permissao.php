<?php
    /* Checking if the user is logged in and redirecting them to the correct page. */
    if ($_SESSION['nivelAcesso'] == 2) {
        header("Location: 403.php");
    } else if ($_SESSION['nivelAcesso'] == 1) {
        header("Location: cliente\homeCli.php");
    }
?>