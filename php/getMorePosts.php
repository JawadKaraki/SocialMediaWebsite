<?php
session_start();
//connect to database
include("connection.php");
//get category
$category = $_POST['category'];
$offset = $_POST['offset'];
$search = $_POST['search'];
//if the user is searching search for this
if($search){
    $query = "
        SELECT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,posts.userid as userid , posts.postid as postid,users.name as name,posts.text as text ,posts.time as time,posts.img as img
        FROM users,posts,friends
        WHERE friends.firstid = ".$_SESSION['id']." AND friends.friendid = posts.userid  AND users.id = friends.friendid AND (posts.text LIKE '%".$search."%' OR name LIKE '%".$search."%')
        ORDER BY time DESC LIMIT $offset,10
        ;
        ";
}else{
    //if the user hasnt chose a category and isnt searching then show this
    if($category == "none"){
        $query = "
        SELECT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,posts.userid as userid , posts.postid as postid,users.name as name,posts.text as text ,posts.time as time,posts.img as img
        FROM users,posts,friends
        WHERE friends.firstid = ".$_SESSION['id']." AND friends.friendid = posts.userid  AND users.id = friends.friendid
        ORDER BY time DESC LIMIT $offset,10
        ;
        ";
    }else{
        //if the user chose a category search for all posts in this catagory
        $query = "
        SELECT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,posts.userid as userid , posts.postid as postid,users.name as name,posts.text as text ,posts.time as time,posts.img as img
        FROM users,posts,friends
        WHERE friends.firstid = ".$_SESSION['id']." AND friends.friendid = posts.userid  AND users.id = friends.friendid AND posts.category = '$category'
        ORDER BY time DESC LIMIT $offset,10
        ;
        ";  
    }
}

$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) > 0){
    for($i = 0; $post = mysqli_fetch_assoc($result) ;$i++){
        $posts[$i] = $post; 
     }
}
//get likes on post
for($i =0 ; $i < count($posts) ;$i++){
    
    $query = "SELECT COUNT(*) as likes FROM likes
    WHERE likedid = ".$posts[$i]['postid']."; ";
    $result = mysqli_query($conn,$query);
    if($result){
         $like = mysqli_fetch_assoc($result);
    }
   $likes[$i] = $like['likes']; 
}
//check if i liked this post
for($i =0 ; $i < count($posts) ;$i++){
    
    $query = "SELECT * FROM likes
    WHERE likedid = ".$posts[$i]['postid']." AND likerid=".$_SESSION['id']."
    ; ";
    $result = mysqli_query($conn,$query);
    if( mysqli_num_rows($result) == 0 ){
       $isliked[$i] = 0;
    }else{
        $isliked[$i] = 1;
    }
}
//echo data to ajax
$i = 0;
        foreach ($posts as $post) {
            echo '
            <div class="post">
                        <div class="user">
                            <a href="profile.php?who='.$post['userid'].'" class="photo">
                                <img alt="" src="'.$post['prof'].'">
                            </a>
                            <div class="text">
                                <div class="name">'.$post['name'].'</div>
                                <div class="time">'.$post['time'].'</div>
                            </div>
                            <p class="nb-of-likes" >'.$likes[$i].'</p>
                            <div style="color:';
                            if($isliked[$i]){
                                echo "var(--red)";
                            }else{
                                echo "var(--white)";
                            }
                            echo '" class="like" onClick="changeColor('.$i + $offset.','.$post['postid'].');"><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="post-area">
                        ';
                            echo $post['text'];
                            if($post['img'] != null){
                            echo '<img alt="!sorry cant load image!" src=" '.$post['img'].'"> '  ;
                            }
                        echo ' </div>
                        <div class="comments">
                            <input class="comment-input" type="text" placeholder="A D D    A    C O M M E N T" onChange="sendCom('.$i + $offset.','.$post['postid'].');">
                            <div class="see-comments" onClick="openCom('.$i + $offset.','.$post['postid'].')">
                                <em class="fa fa-comments"></em>
                            </div>
                        </div>
                    </div>
                    <div class="comments-section">
                        <div class="comments-cont">
                            
                        </div>
                    </div>
                ';
                $i++;
        }
        echo "<p id='more' class='more' onClick='more();'>MORE</p>";
?>