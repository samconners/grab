<?php

if(!session_start()) {
    // If the session couldn't start, present an error
    header("Location: error.php");
    exit;
}

$action = empty($_POST['action']) ? '' : $_POST['action'];
$owner = empty($_POST['owner']) ? '' : $_POST['owner'];
$collectionName = empty($_POST['collectionName']) ? '' : $_POST['collectionName'];
$collectionType = empty($_POST['collectionType']) ? '' : $_POST['collectionType'];
$list_mine = "";

if ($collectionType == "LIST_MINE") {
    $owner = $_COOKIE['loggedin'];
    $collectionType = "";
    $list_mine = "true";
}
else if ($collectionType == "ALL") {
    $collectionType = "";
}

require_once '../db.conf';
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn -> connect_error) {
    $error = "Error";
}

$owner = $conn -> real_escape_string($owner);
$collectionName = $conn -> real_escape_string($collectionName);
$collectionType = $conn -> real_escape_string($collectionType);

if ($action == 'get_collection_set') 
    $query = "select DISTINCT collectionName, owner, collectionType from collections";
else if ($action == 'get_collection')
    $query = "select * from collections";

if ($owner || $collectionType || $collectionName)
    $query .= " where ";

if ($owner) {
    $query .= "owner = '" . $owner . "' ";
    if ($collectionType || $collectionName)
        $query .= " and ";
}

if ($collectionType) {
    if ($collectionType == "OTHER_TYPE") {
        $query .= "collectionType NOT IN ('movies', 'books', 'music', 'games')";
        if ($collectionName)
            $query .= " and ";
    }
    else {
        $query .= "collectionType = '" . $collectionType . "' ";
        if ($collectionName)
            $query .= " and ";
    }
}

if ($collectionName)
    $query .= "collectionName = '" . $collectionName . "'";

$result = $conn->query($query);


if ($result->num_rows > 0) {
    // output data of each row
    if ($action == 'get_collection_set') 
        while($row = $result->fetch_assoc()) {
            $htmlEnc = htmlentities($row[collectionName], ENT_QUOTES); //HTML-safe Encoding
            echo "<a class='wikiBox' data-owner='" . $row[owner] . "' data-collType='" . $row[collectionType] . "' data-collName='" . $htmlEnc . "' class='pickColl closeLink' href='#'><p class='cozy'>\"" . $row[collectionName] . "\"</p><p class='cozy'>By: " . $row[owner] . "</p><p class='cozy'>(Type: " . $row[collectionType] . ")</p></a><a class='x' href='#'>x</a>";
        }
    else if ($action == 'get_collection')
        while($row = $result->fetch_assoc()) {
            $output = "<div class='wikiBox'><p>" . $row[itemName] . "</p>";
            if ($row[itemImage]) {
                $output .= "<img src='" . $row[itemImage] . "' class='imgg'>";
            }
            $output .= "<p>" . $row[itemDescription] . "</p><a target='_blank' href='" . $row[itemLink] . "'>" . $row[itemLink] . "</a></div>";
            echo $output;
        }
} 
else
    echo "<p id='resultText'>0 results</p>";

$conn->close();

?>