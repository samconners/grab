<?php

header("Access-Control-Allow-Origin: *");

echo "LOGGING OUT";

if(!session_start()) {
    header("Location: error.php");
    exit;
}

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    setcookie("loggedin", '', 1, "/");   
}
session_destroy();

// Redirect off
//header("Location: login.php");

exit;
?>