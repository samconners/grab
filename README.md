# GRAb
A tool to create collections of items.

## Team Members
Sean Conners
Samantha Conners (not in class)

## Schema


## Entity Relationship Diagram

## Criteria

### Create

createuser.php > Line 55
$query = "insert into users (username, password, addDate, changeDate) values ('$username', '$password', now(), now())";

### Read

collections/getCollection.php > Line 32
$query = "select DISTINCT collectionName, owner, collectionType from collections";

### Update

//update password

### Delete

collections/delete.php > Line 29
$query = "DELETE FROM collections WHERE owner = '" . $owner . "' AND collectionName = '" . $collectionName . "' AND collectionType = '" . $collectionType . "'";

## Link

<fill in link>

## Video

<fill in link>
