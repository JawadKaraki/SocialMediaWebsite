<?php

if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        $user = $_POST['name'];
        $image = $_POST['image'];
        $work = $_POST['profession'];
        $about = $_POST['about'];
        
        $query ="UPDATE users
        SET name = '$user',
        img = '$image',
        about = '$about',
        work = '$work'
        WHERE id = ".$_SESSION['id'].";  
        ";
        mysqli_query($conn,$query);
        header("location: profile.php?who=".$_SESSION['id']."");
        
}


?>