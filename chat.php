<?php
session_start();
include("php/connection.php");
if(!$_SESSION['id']){
    header('location:login.php');
}

$query = "SELECT name,IFNULL(img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as img
FROM users where id = ".$_SESSION['id']." LIMIT 1; ";

$result = mysqli_query($conn,$query);
if($result){
     $userinfo = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="show-chats">
        <i class="fa fa-users"></i>
    </div>
    <div class="nav">
        <div class="me">
            <div class="my-name">
                <?php echo $userinfo['name']; ?>
            </div>
            <div class="my-prof">
                <img src="<?php echo $userinfo['img']; ?>" alt="">
            </div>
        </div>
        <a class="icons" href="index.php">
            <div class="icon" id="home">
                    <em class="fa fa-home" ></em>
            </div>
        </a>
    </div>
    <div class="chat-place">
        <div class="header">
            <div class="his-prof">
                <img src="ANY" alt="">
            </div>
            <div class="his-name">
                SELECT SOMEONE
            </div>
            
        </div>
        <div class="chats" id="chats">
        </div>
        <form method="post" id="form">
            <input type="text" name="massage" id="mass-inp"  placeholder="M    A    S    S    A    G    E"  onChange="sendMassage(<?php echo $_GET['who']; ?>);" />
            <i class="fa fa-paper-plane" id="send" name="send" onClick="sendMassage(<?php echo $_GET['who']; ?>);"></i>
        </form>
    </div>
    <div class="right-cont">
    </div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="js/chat.js"></script>
   <script>
       //set input target to who
       sendData(<?php echo $_GET['who']; ?>);
   </script>
</body>
</html>