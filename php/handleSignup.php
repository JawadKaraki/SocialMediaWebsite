<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user = $_POST['username'];
        $password = $_POST['password'];
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $work = $_POST['work'];
        $about = $_POST['about'];

        $query = "SELECT * FROM users WHERE name='$user' LIMIT 1";
        $result = mysqli_query($conn,$query);

        if(mysqli_num_rows($result) > 0){
                echo '<div class="error">CHOOSE ANOTHER NAME</div>';
        }else{
                $query = "INSERT INTO users (name,password,work,about) VALUES ('".$user."','".$hashed."','".$work."','".$about."'); ";
                mysqli_query($conn,$query);
                header("location: login.php");
                die;
        }
        
}


?>