<?php
        session_start();
        if(isset($_SESSION['admin']) || isset($_SESSION['alumno'])  || isset($_SESSION['profesor']) || isset($_SESSION['coordinador'])){
            session_unset(); 
            session_destroy();
            header("Location: ../../panel/login/");
            exit;
        }
        header("Location: ../../panel/login/");
        exit;
?>