<?php
$areFriends = 0;
//get this profile user info 
$query = "SELECT id,name,IFNULL(img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as img,about,work 
FROM users where id = ".$who." LIMIT 1; ";
$result = mysqli_query($conn,$query);
if($result){
     $userinfo = mysqli_fetch_assoc($result);
}
//check if this user is friends with the visited profile and set are friends to 1 if they are
$query = "SELECT * FROM friends where firstid = ".$_SESSION['id']." AND friendid = ".$who.";";

$result = mysqli_query($conn,$query);
if( mysqli_num_rows($result) > 0 ){
     $areFriends = 1;
}
?>