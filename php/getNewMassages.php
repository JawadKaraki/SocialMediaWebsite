<?php
session_start();
//connect to database
include("connection.php");

$id = $_POST['id'];
//get all massages that haven't been read either from me or from the target user
$query1 = "
SELECT * FROM `massages` 
WHERE (sentFrom = ".$id." and sentTo = ".$_SESSION['id']." AND seen = 0)
;";
$result1 = mysqli_query($conn,$query1);
if($result1){
    for($i = 0; $massage = mysqli_fetch_assoc($result1) ;$i++){

      //if unread massage is from the target user put left and send massage to backupmassages
      echo '
      <div class="his-mass">
        '.$massage['massage'].'
      </div>';
     }
}
$query3 ="
UPDATE massages 
SET seen = 1 
WHERE sentFrom = ".$id." AND sentTo = ".$_SESSION['id'].";";
mysqli_query($conn,$query3);

?>