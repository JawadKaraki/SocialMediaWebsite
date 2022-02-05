<?php
session_start();
//connect to database
include("connection.php");
//get value from ajax of liked post
$id = $_POST['id'];
$text = $_POST['text'];

//send comment of (this) user on (this) post to table
if(!empty($id) && !empty($text)){
        $query = "INSERT INTO comments (userid,postid,text) VALUES (".$_SESSION['id'].",'$id','$text'); ";
        mysqli_query($conn,$query);
        echo "success";
}
?>