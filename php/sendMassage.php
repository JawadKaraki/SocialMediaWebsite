<?php
session_start();
//connect to database
include("connection.php");


$id = $_POST['id'];
$massage = $_POST['massage'];

//send massage to massages table 
if(!empty($id) && !empty($massage)){
        $query = "INSERT INTO massages (sentFrom,sentTo,massage,seen) VALUES (".$_SESSION['id'].",'$id','$massage',0); ";
        mysqli_query($conn,$query);
        echo "success";
}
?>