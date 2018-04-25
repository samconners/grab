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
//$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];

//if ($loggedIn) {
//    header("Location: page1.php");
//    exit;
//}


$action = empty($_POST['action']) ? '' : $_POST['action'];

if ($action == 'save') {
    saveCollection();
}

function saveCollection() {
    $owner = $_COOKIE['loggedin'];
    $collectionName = empty($_POST['collectionName']) ? '' : $_POST['collectionName'];
    $collectionType = empty($_POST['collectionType']) ? '' : $_POST['collectionType'];
    $itemName = empty($_POST['itemName']) ? '' : $_POST['itemName'];
    $itemDescription = empty($_POST['itemDescription']) ? '' : $_POST['itemDescription'];
    $itemLink = empty($_POST['itemLink']) ? '' : $_POST['itemLink'];
    $itemImage = empty($_POST['itemImage']) ? '' : $_POST['itemImage'];

    require_once '../db.conf';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn -> connect_error) {
        $error = "Error";
    }

    $owner = $conn -> real_escape_string($owner);
    $collectionName = $conn -> real_escape_string($collectionName);
    $collectionType = $conn -> real_escape_string($collectionType);
    $itemName = $conn -> real_escape_string($itemName);
    $itemDescription = $conn -> real_escape_string($itemDescription);
    $itemLink = $conn -> real_escape_string($itemLink);
    $itemImage = $conn -> real_escape_string($itemImage);

    $query = "insert into collections (owner, collectionName, collectionType, itemName, itemDescription, itemLink, itemImage) values ('$owner', '$collectionName', '$collectionType', '$itemName', '$itemDescription', '$itemLink', '$itemImage')";

    if($conn -> query($query) === TRUE) {
        $error = "Successfully saved collection";
        exit;
    }
    else {
        $error = "Insert error: " . $conn -> error;
        exit;
    }

}

?>