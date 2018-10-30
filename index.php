<?php

// written by GTusername1

session_start();
if (empty($_SESSION['username']) ){
    header("Location: login.php");
    die();
}else{
    header("Location: main_menu.php");
    die();
}
?>