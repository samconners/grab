<?php

header("Access-Control-Allow-Origin: *");

// HTTPS redirect
//if ($_SERVER['HTTPS'] !== 'on') {
//    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//    header("Location: $redirectURL");
//    exit;
//}

if(!session_start()) {
    header("Location: error.php");
    exit;
}

$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

$action = empty($_POST['action']) ? '' : $_POST['action'];

if ($action == 'do_login')
    handle_login(); 
else
    login_form();

function handle_login() {
    $realusername = empty($_POST['username']) ? '' : $_POST['username'];
    $password = empty($_POST['password']) ? '' : $_POST['password'];

    require_once './db.conf';

    // Connect to the database
    $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($mysqli->connect_error) {
        $error = 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
        require "login_form.php";
        exit;
    }

    $username = $mysqli->real_escape_string($realusername);
    $password = $mysqli->real_escape_string($password);
    $password = sha1($password); 
    $query = "SELECT id FROM users WHERE userName = '$username' AND password = '$password'";
    $mysqliResult = $mysqli->query($query);

    if ($mysqliResult) {
        $match = $mysqliResult->num_rows;
        $mysqliResult->close();
        $mysqli->close();
        if ($match == 1) {
            // 86400 = 1 day
            ini_set(’session.gc_maxlifetime’, 86400); 
            if (ini_get("session.use_cookies")) {
                setcookie("loggedin", $realusername, time() + 86400, "/");
            }
            
            // Redirect off, refresh instead
            // header("Location: page1.php");
            echo "<script>window.top.location.reload();</script>";
            
            exit;
        }
        else {
            $error = 'Error: Incorrect username or password';
            require "login_form.php";
            exit;
        }
    }
    else {
        $error = 'Login Error: Please contact the system administrator.';
        require "login_form.php";
        exit;
    }
}

function login_form() {
    $username = "";
    $error = "";
    require "login_form.php";
    exit;
}



?>