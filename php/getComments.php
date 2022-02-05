<?php
session_start();
//connect to database
include("connection.php");
//get value from ajax of liked post
$id = $_POST['id'];
$count = 0;//count how many comments
//get comments on post  
$query = "SELECT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,users.name as name,comments.text as text  FROM comments,users
WHERE postid = ".$id." AND comments.userid = users.id ;";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) > 0){
        //fetch each row and echo data to ajax
        for($y = 0; $comment = mysqli_fetch_assoc($result) ;$y++){
                echo 
                        '<div class="com-user">
                                <div class="user-photo">
                                        <img src="'.$comment['prof'].'">
                                </div>
                                <div class="com-text">
                                        <b>'.$comment['name'].'</b><br>'.$comment['text'].'
                                </div>
                        </div>';
                $count++;
        }
}
//check if no notifications (count == 0) type this instead
if($count == 0){
        echo 
        '<div class="com-user">
                <div class="com-text" style="text-align:center;width:100%;">
                        NO COMMENTS ON THIS POST
                </div>
        </div>';
    }

?>