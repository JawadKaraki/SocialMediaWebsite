<?php
//select all posts of this user
$query = "SELECT * FROM posts where userid = ".$who." ORDER BY time DESC; ";

$result = mysqli_query($conn,$query);
if($result){
    for($i = 0; $post = mysqli_fetch_assoc($result) ;$i++){
        $posts[$i] = $post;
    }
}

?>