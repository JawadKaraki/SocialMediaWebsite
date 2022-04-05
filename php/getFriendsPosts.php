<?php
session_start();
//connect to database
include("connection.php");
//get category
$category = $_POST['category'];
//get search
$search = $_POST['search'];
if($search){
    $query = "
        SELECT users.img as prof,posts.userid as userid , posts.postid as postid,users.name as name,posts.text as text ,posts.time as time,posts.img as img
        FROM users,posts,friends
        WHERE friends.firstid = ".$_SESSION['id']." AND friends.friendid = posts.userid  AND users.id = friends.friendid AND (posts.text LIKE '%".$search."%' OR name LIKE '%".$search."%')
        ORDER BY time DESC LIMIT 10
        ;
        ";
}else{
    if($category == "none"){
        $query = "
        SELECT users.img as prof,posts.userid as userid , posts.postid as postid,users.name as name,posts.text as text ,posts.time as time,posts.img as img
        FROM users,posts,friends
        WHERE friends.firstid = ".$_SESSION['id']." AND friends.friendid = posts.userid  AND users.id = friends.friendid
        ORDER BY time DESC LIMIT 10
        ;
        ";
    }else{
        $query = "
        SELECT users.img as prof,posts.userid as userid , posts.postid as postid,users.name as name,posts.text as text ,posts.time as time,posts.img as img
        FROM users,posts,friends
        WHERE friends.firstid = ".$_SESSION['id']." AND friends.friendid = posts.userid  AND users.id = friends.friendid AND posts.category = '$category'
        ORDER BY time DESC LIMIT 10
        ;
        ";  
    }
}
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) > 0){
    for($i = 0; $post = mysqli_fetch_assoc($result) ;$i++){
        $posts[$i] = $post; 
     }
}else{
    die('<div class="mobile-sections">
    <div class="left">
        <div class="icon" id = "left-icon" onClick="leftShow()"> 
            <i class="fa fa-list-alt"></i>
        </div>   
    </div>
    <div class="right">
        <div class="icon" id = "right-icon" onClick="rightShow()">
            <i class="fa fa-users"></i>
        </div>
    </div>
</div>
<div class="posts-header">
POSTS
</div><p class="no-posts-error">SORRY NO POSTS</p>');
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
echo '
<div class="mobile-sections">
        <div class="left">
            <div class="icon" id = "left-icon" onClick="leftShow()"> 
                <i class="fa fa-list-alt"></i>
            </div>   
        </div>
        <div class="right">
            <div class="icon" id = "right-icon" onClick="rightShow()">
                <i class="fa fa-users"></i>
            </div>
        </div>
</div>
<div class="posts-header">
POSTS
</div>
';

$i = 0;
        foreach ($posts as $post) {
            echo '
            <div class="post">
                        <div class="user">
                            <a href="profile.php?who='.$post['userid'].'" class="photo">
                                <img alt="" src="'.$post['prof'].'" onerror="ImageReplace(this);">
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
                            echo '" class="like" onClick="changeColor('.$i.','.$post['postid'].');"><i class="fa fa-heart"></i></div>
                        </div>
                        <div class="post-area">
                        ';
                            echo $post['text'];
                            if($post['img'] != null){
                            echo '<img alt="!sorry cant load image!" src=" '.$post['img'].'"> '  ;
                            }
                        echo ' </div>
                        <div class="comments">
                            <input class="comment-input" type="text" placeholder="A D D    A    C O M M E N T" onChange="sendCom('.$i.','.$post['postid'].');">
                            <div class="see-comments" onClick="openCom('.$i.','.$post['postid'].')">
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