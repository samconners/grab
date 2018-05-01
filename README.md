# GRAb

A tool to create collections of items. [Site is hosted here](http://ec2-174-129-181-81.compute-1.amazonaws.com).

## Team Members

Sean Conners

Samantha Conners (not in class)

## Schema

### Users

| Field | Type | Null | Key | Default | Extra |
|:--:|:--:|:--:|:--:|:--:|:--:|
| id | int(11) | NO | PRI | NULL | auto_increment |
| username | varchar(255) | NO | UNI | NULL |   |
| password | text | NO |   | NULL |   |
| addDate | datetime | YES |   | NULL |   |
| changeDate | datetime | YES |   | NULL |   |

### Collections

| Field | Type | Null | Key | Default | Extra |
|:--:|:--:|:--:|:--:|:--:|:--:|
| id | int(11) | NO | PRI | NULL | auto_increment |
| owner | varchar(255) | NO | UNI | NULL |   |
| collectionName | varchar(255) | NO | UNI | NULL |   |
| collectionType | varchar(255) | NO | UNI | NULL |   |
| itemName | varchar(255) | NO | UNI | NULL |   |
| itemDescription | varchar(255) | NO | UNI | NULL |   |
| itemLink | varchar(255) | NO | UNI | NULL |   |
| itemImage | varchar(255) | NO | UNI | NULL |   |


## Entity Relationship Diagram

![ERD](GRAb.png?raw=true "ERD")

## Criteria

### Create

createuser.php > Line 55

$query = "insert into users (username, password, addDate, changeDate) values ('$username', '$password', now(), now())";

### Read

collections/getCollection.php > Line 32

$query = "select DISTINCT collectionName, owner, collectionType from collections";

### Update

collections/changepassword.php > Line 49

$query = "UPDATE users SET password='$newPassword', changeDate=now() WHERE username='$username' AND password='$oldPassword'";

### Delete

collections/delete.php > Line 29

$query = "DELETE FROM collections WHERE owner = '" . $owner . "' AND collectionName = '" . $collectionName . "' AND collectionType = '" . $collectionType . "'";

## Video

https://www.youtube.com/watch?v=VGuoiSQ9-xY
