<?php
// Here we are using sessions to propagate the login
// http://us3.php.net/manual/en/intro.session.php

// HTTPS redirect
//if ($_SERVER['HTTPS'] !== 'on') {
//    $redirectURL = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//    header("Location: $redirectURL");
//    exit;
//}

// http://us3.php.net/manual/en/function.session-start.php
if(!session_start()) {
    // If the session couldn't start, present an error
    header("Location: error.php");
    exit;
}


// Check to see if the user has already logged in
$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin']; // was "loggedin"

if ($loggedIn) {
    header("Location: page1.php");
    exit;
}

$action = empty($_POST['action']) ? '' : $_POST['action'];

if ($action == 'do_create')
    createUser();
else
    login_form();

function createUser() {
    $username = empty($_POST['username']) ? '' : $_POST['username'];
    $password = empty($_POST['password']) ? '' : $_POST['password'];
    $confirmPass = empty($_POST['confirmPass']) ? '' : $_POST['confirmPass'];

//    echo $username . "<br>";
//    echo $password . "<br>";
//    echo $confirmPass . "<br>";

    if (strcmp($password, $confirmPass) ==0) {
        require_once './db.conf';
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($conn -> connect_error) {
            $error = "Error";
        }

        $username = $conn -> real_escape_string($username); //security
        $password = $conn -> real_escape_string($password);
        $password = sha1($password);

        $query = "insert into users (username, password, addDate, changeDate) values ('$username', '$password', now(), now())";

        if($conn -> query($query) === TRUE) {
            $error = "New User Created Successfully";
            require "login_form.php";
            exit;
        }
        else {
            $error = "Insert error: " . $conn -> error;
            require "createuser_form.php";
            exit;
        }

        // end input form with "required" to require it
        // in html, .setCustomValidity("Password don't match") will show a tip
        // do not use it for positive outcomes
    }
    else {
        $error = "Error: Passwords do not match!";
        require "createuser_form.php";
        exit;
    }
}

function login_form() {
    $username = "";
    $error = "";
    require "login_form.php";
    exit;
}
