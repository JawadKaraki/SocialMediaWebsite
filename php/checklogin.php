<?php
//check if this user data username and password match any data from users table
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = $_POST['username'];
    $pass = $_POST['password'];
        //search for user with this name
        $query = " SELECT * FROM users WHERE name = '$user' LIMIT 1;";
        $result = mysqli_query($conn,$query);
        if($result){
            $row = mysqli_fetch_assoc($result);
            //check if password matches this user password
            if(password_verify($pass,$row['password'])){
                $_SESSION['id'] = $row['id'];
                header("location:index.php");//go to index if data is valid
                die;
            }else{
                echo '<div class="error">WRONG PASSWORD</div>';
            }
        }
}


?>