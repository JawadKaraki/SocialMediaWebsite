<?php
session_start();
//connect to database
include("connection.php");
//get likes notifications of this user
$query = "
SELECT u.name as name,l.time as time,p.text as text
FROM users as u,posts as p 
INNER JOIN likes as l ON p.postid = l.likedid
WHERE u.id = l.likerid AND p.userid = ".$_SESSION['id']." AND l.likerid != ".$_SESSION['id']."
;";

$result = mysqli_query($conn,$query);
if($result){
    for($i = 0; $not = mysqli_fetch_assoc($result) ;$i++){
        $notifications[$i] = $not; 
     }
}

$count = 0;//count how many notifications

//echo data to ajax
echo '<p class="title">NOTIFICATIONS</p>';
foreach ($notifications as $not) {
    $count++;
        echo '
        <div class="notify">
        <p class="not-text">YOU GOT ONE LIKE FROM '.$not['name'].' ON YOUR POST "'.$not['text'].'" </p>
        <p class="not-time">'.$not['time'].'</p>
        </div>';
}

//check if no notifications (count == 0) type this instead
if($count == 0){
    echo '
        <div class="notify">
        <p class="not-text">NO NEW NOTIFICATIONS</p>
        <p class="not-time">CHECK AGAIN LATER</p>
        </div>';
}

?>