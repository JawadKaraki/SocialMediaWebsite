<?php
session_start();
//connect to database
include("connection.php");

$id = $_POST['id'];
//get indo of chat target 
$query = "SELECT name,img
FROM users where id = ".$id." LIMIT 1; ";

$result = mysqli_query($conn,$query);
if($result){
     $userinfo = mysqli_fetch_assoc($result);
}
//echo his data to ajax
echo '<div class="his-prof">
        <img src="'.$userinfo['img'].'" onerror="ImageReplace(this);">
      </div>
      <div class="his-name">
        '.$userinfo['name'].'
      </div>'
?>