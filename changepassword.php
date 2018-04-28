<?php

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

if ($action == 'do_change')
    changePassword();
else
    login_form();

function changePassword() {
    $username = $owner = $_COOKIE['loggedin'];
    $oldPassword = empty($_POST['oldPassword']) ? '' : $_POST['oldPassword'];
    $newPassword = empty($_POST['newPassword']) ? '' : $_POST['newPassword'];
    $confirmPass = empty($_POST['confirmPass']) ? '' : $_POST['confirmPass'];

    // echo $username . "<br>";
    // echo $oldPassword . "<br>";
    // echo $newPassword . "<br>";
    // echo $confirmPass . "<br>";

    if (strcmp($newPassword, $confirmPass) == 0) {
        require_once './db.conf';
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($conn -> connect_error) {
            $error = "Error";
        }

        $username = $conn -> real_escape_string($username); //security
        $oldPassword = $conn -> real_escape_string($oldPassword);
        $oldPassword = sha1($oldPassword);
        $newPassword = $conn -> real_escape_string($newPassword);
        $newPassword = sha1($newPassword);


        $query = "UPDATE users SET password='$newPassword', changeDate=now() WHERE username='$username' AND password='$oldPassword'";

        if($conn -> query($query) === TRUE) {
            $error = "Password Updated Successfully";
            exit;
        }
        else {
            $error = "Insert error: " . $conn -> error;
            require "changepassword_form.php";
            exit;
        }

        // end input form with "required" to require it
        // in html, .setCustomValidity("Password don't match") will show a tip
        // do not use it for positive outcomes
    }
    else {
        $error = "Error: Passwords do not match!";
        require "changepassword_form.php";
        exit;
    }
}

function login_form() {
    $username = "";
    $error = "";
    require "login_form.php";
    exit;
}
