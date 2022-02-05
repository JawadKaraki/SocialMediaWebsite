<?php 

if($_SESSION['id']){
   //check if this user logged in before or this is the first time
   $query = "SELECT userid as id from online";
   $result = mysqli_query($conn,$query);
   $found = false;
   if($result){
      for($i =0 ;$id = mysqli_fetch_assoc($result) ;$i++){
         //if any id match in the online table found to true
         if( $id['id'] == $_SESSION['id'] ){
            $found = true;
         }
      }
   }
   //if this user hasnt logged in before create a new online row for this user 
   if($found == false){
      $query = "INSERT INTO online (userid) VALUES (".$_SESSION['id']."); ";
      mysqli_query($conn,$query);
   }else{
      //if this user has logged in before just update his time to the current time
      $query = "UPDATE online
      SET time = CURRENT_TIMESTAMP
      WHERE userid = ".$_SESSION['id']."; 
      ";
      mysqli_query($conn,$query);
   }
}

?>