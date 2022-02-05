<?php
session_start();
//connect to database
include("connection.php");
//get value from ajax of liked post
$like = $_POST['likedid'];
//query likedpost and likerid to mysql
$query = "DELETE FROM likes WHERE likerid=".$_SESSION['id']." AND likedid=$like; ";
mysqli_query($conn,$query);

?>