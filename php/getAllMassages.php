<?php
session_start();
//connect to database
include("connection.php");

$id = $_POST['id'];
//get old massages from backupmassages between me and this user
$query = "
SELECT * FROM `massages` WHERE (sentFrom = ".$_SESSION['id']." and sentTo = ".$id.") OR  (sentFrom = ".$id." and sentTo = ".$_SESSION['id']." AND seen = 1);
;";
//fetch result
$result = mysqli_query($conn,$query);
if($result){
    for($i = 0; $massage = mysqli_fetch_assoc($result) ;$i++){
        //if me send this show on right 
        if($massage['sentFrom'] == $_SESSION['id']){
            echo '
            <div class="my-mass">
              '.$massage['massage'].'
            </div>';
        }
        //if the other user show on left
        if($massage['sentFrom'] == $id){
            echo '
            <div class="his-mass">
              '.$massage['massage'].'
            </div>';
        }
     }
}else{
  //if no results show start a conversation text
  echo '
  <div class="no-mass-err">
     START A CONVERSATION
  </div>
  ';
}
?>