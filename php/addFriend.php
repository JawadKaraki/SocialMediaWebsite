<?php
session_start();

include("connection.php");
//get all results where this id is friends with me
$query = "SELECT * from friends WHERE firstid = ".$_SESSION['id']." AND friendid = ".$_POST['friendid']." ; ";
$result = mysqli_query($conn,$query);
//if no result from friends table then this user is not friends
if( mysqli_num_rows($result) == 0 ){
    //add friend
    $query = "INSERT INTO friends (firstid,friendid) VALUES (".$_SESSION['id'].",".$_POST['friendid']."); ";
    mysqli_query($conn,$query);

}

?>