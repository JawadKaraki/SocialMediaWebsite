<?php
//add post data to posts table
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $text = $_POST['text'];
        $category = $_POST['category'];
        $img = $_POST['image'];
        echo "hi";
        $query = "INSERT INTO posts (userid,text,img,category) VALUES ('".$_SESSION['id']."','$text','$img','$category'); ";
        mysqli_query($conn,$query);
        header("location:index.php");
}

?>