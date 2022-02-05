<?php
session_start();
//connect to database
include("connection.php");

//remove from friends table
$query = "DELETE FROM friends WHERE firstid=".$_SESSION['id']." AND friendid=".$_POST['friendid']." ; ";
mysqli_query($conn,$query);

?>