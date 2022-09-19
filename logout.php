<?php
    require_once "connection.php";
    session_start();
    if(session_destroy())
    {
        header("Location: sign-in.php");
    }
?>