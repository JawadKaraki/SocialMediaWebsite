<?php
header('Content-Type: application/json');
session_start();
//connect to database
include("connection.php");

//get all online friends
$query = "
SELECT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,users.id as id,users.name as name ,users.img as img
FROM users,friends,online
WHERE users.id = friends.friendid AND friends.firstid = ".$_SESSION['id']." AND users.id = online.userid AND TIMEDIFF(CURRENT_TIMESTAMP,online.time) < '00:00:10'
;"
;

$result = mysqli_query($conn,$query);
if($result){
    for($i = 0; $friend = mysqli_fetch_assoc($result) ;$i++){
        $online[$i] = $friend; 
     }
}
//get all offline friends
$query = "
SELECT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,users.id as id,users.name as name ,users.img as img
FROM users,friends
WHERE users.id = friends.friendid AND friends.firstid = ".$_SESSION['id']." AND 
users.id NOT IN (SELECT userid from online WHERE TIMEDIFF(CURRENT_TIMESTAMP,online.time) < '00:00:10');"
;

$result = mysqli_query($conn,$query);
if($result){
    for($i = 0; $friend = mysqli_fetch_assoc($result) ;$i++){
        $offline[$i] = $friend; 
     }
}
//get users who sent me massagse but i am not friends with
$query = "
SELECT DISTINCT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,users.id as id,users.name as name ,users.img as img
FROM users,massages
WHERE ((users.id = massages.secondid AND massages.firstid = ".$_SESSION['id'].")  OR  (massages.secondid = ".$_SESSION['id']." AND massages.firstid = users.id)) AND (users.id NOT IN 
(SELECT friends.friendid from friends WHERE friends.firstid = ".$_SESSION['id']."))
;"
;

$result = mysqli_query($conn,$query);
if($result){
    for($i = 0; $chat = mysqli_fetch_assoc($result) ;$i++){
        $chats[$i] = $chat; 
     }
}
//get the number of new massages sent from each user
$query = "
SELECT COUNT(massages.id) as num,massages.sentFrom as id
FROM massages
WHERE massages.sentTo = ".$_SESSION['id']." AND massages.seen = 0
GROUP BY massages.sentFrom
;"
;

$result = mysqli_query($conn,$query);
if($result){
    for($i = 0; $new = mysqli_fetch_assoc($result) ;$i++){
        $news[$i] = $new; 
     }
}
//transform data to array to process in javascript
$array = array(
    'online' => $online,
    'offline' => $offline,
    'chats' => $chats,
    'news' => $news
);
//transform data to json
$json = json_encode($array);
//send json data
echo $json;

?>