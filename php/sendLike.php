<?php
session_start();
//connect to database
include("connection.php");
//get value from ajax of liked post
$like = $_POST['likedid'];
//check if this user already liked this post
$query = "SELECT * FROM likes WHERE likerid=".$_SESSION['id']." AND likedid=$like ; ";
$result = mysqli_query($conn,$query);

//if not send liker data to database
if( mysqli_num_rows($result) == 0 ){
    
//query likedpost and likerid to mysql
$query = "INSERT INTO likes (likerid,likedid) VALUES (".$_SESSION['id'].",'$like'); ";
mysqli_query($conn,$query);
}

?>