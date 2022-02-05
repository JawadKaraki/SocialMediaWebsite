<?php
session_start();
//connect to database
include("connection.php");

$id = $_POST['id'];
//get indo of chat target 
$query = "SELECT name,IFNULL(img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as img 
FROM users where id = ".$id." LIMIT 1; ";

$result = mysqli_query($conn,$query);
if($result){
     $userinfo = mysqli_fetch_assoc($result);
}
//echo his data to ajax
echo '<div class="his-prof">
        <img src="'.$userinfo['img'].'" alt="">
      </div>
      <div class="his-name">
        '.$userinfo['name'].'
      </div>'
?>