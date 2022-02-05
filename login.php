<?php
session_start();

if($_SESSION['id'] != null){
    header('location:index.php');
}

include("php/connection.php");
include("php/checklogin.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>LOGIN</title>
</head>
<body>
    <div class="link"><a href="signup.php">S I G N U P</a></div>
    <div class="form">
        <form action="" method="post">
            <label>LOGIN HERE</label>
            <input type="text" name="username" placeholder="U  S  E  R  N  A  M  E" required>
            <input type="password" name="password" placeholder="P  A  S  S  W  O  R  D" required>
            <input type="submit" name="submit" value="S U B M I T" id="submit">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous">
    </script>
   <script>
       //hide error after 3 seconds if there is one
       setTimeout(()=>{
           $('.error').css('top','-100px');
        },2000);
   </script>
</body>
</html>