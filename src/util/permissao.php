<?php
    if ($_SESSION['nivelAcesso'] == 2) {
        header("Location: 403.php");
    } else if ($_SESSION['nivelAcesso'] == 1) {
        header("Location: cliente\homeCli.php");
    }
?>