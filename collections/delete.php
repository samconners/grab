<?php
    // Every time we want to access $_SESSION, we have to call session_start()
    
    if(!session_start()) {
        header("Location: error.php");
        exit;
    }
    
    $loggedIn = empty($_COOKIE['loggedin']) ? false : $_COOKIE['loggedin'];
    if (!$loggedIn) {
        echo "You are unauthorized to view this page. Please log in.";
        exit;
    }

    require_once '../db.conf';
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn -> connect_error) {
        $error = "Error";
    }

    $owner = $_COOKIE['loggedin'];
    $collectionName = empty($_POST['collectionName']) ? exit() : $_POST['collectionName'];
    $collectionType = empty($_POST['collectionType']) ? exit() : $_POST['collectionType'];

    $owner = $conn -> real_escape_string($owner);
    $collectionName = $conn -> real_escape_string($collectionName);
    $collectionType = $conn -> real_escape_string($collectionType);

    $query = "DELETE FROM collections WHERE owner = '" . $owner . "' AND collectionName = '" . $collectionName . "' AND collectionType = '" . $collectionType . "'";

    //echo $query;

    $result = $conn->query($query);
    $conn->close();
?>