<?php
session_start();

if($_SESSION['id'] == null){
    header('location:login.php');
}

$who = $_GET['who'];
include("php/connection.php");
include("php/getposts.php");
include("php/getuserinfo.php");
include("php/editProfile.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<script>
        //get php variables for javascript
        var me = <?php echo $_SESSION['id']; ?>;//get my id
        var who = <?php echo $who; ?>;//get visited profile's id
        var addButton = <?php echo $areFriends; ?>;//get if user is friends with visited profile
</script>
<script src="js/replaceImage.js"></script>
<body>
    <form class="edit" method="post">
        <i class="fa fa-times" style="margin-right:-80%;"></i>
        <input type="text" name="name" placeholder="N A M E" id="name" />
        <input type="text" name="image" placeholder="I M A G E  U R L" id="image" />
        <div class="side-info">
            <input type="text" name="profession" placeholder="P R O F E S S I O N" id="profession" />
            <input type="text" name="about" placeholder="A  B  O  U  T    M  E" id="about" />
        </div>
        <input type="submit" value="SUBMIT" id="submit">
    </form>
    <div class="navbar">
        <div class="logo">
            SOCIAL
        </div>
        <div class="logo-place">
        </div>
        <div class="search">
            <input id="search" type="text" placeholder="S   E   A   R   C   H" onKeyUp="search()">
            <div class="results">
            </div>
        </div>
        <div class="icons">
            <div class="icon-box" id="not">
                <p class="title">NOTIFICATIONS</p>
                <div class="notify">
                  <p class="not-text">YOU GOT ONE LIKE</p>
                  <p class="not-time">2 hours ago</p>
                </div>
            </div>
            <div class="icon" id="notIcon">
                <i class="fa fa-bell"></i>
            </div>
            <a href="index.php" class="icon" id="link">
                <i class="fa fa-angle-right"></i>
             </a>
        </div>
        <div class="profile"></div>
    </div>
    <div class="main">
            <div class="profile-main">

                <div class="back-text">
                        <?php echo $userinfo['name']; ?>
                </div>
                <div class="profile-photo">
                    <img class="proImg" src="<?php if($userinfo){echo $userinfo['img'];}?>" onerror="ImageReplace(this);" />
                </div>
                <div class="profile-data">
                    <div class="name">
                        <b>NAME</b><br> <?php if($userinfo){ echo $userinfo['name']; } ?>
                    </div>
                    <div class="work">
                        <b>PROFESSION</b><br>  <?php if($userinfo){ echo $userinfo['work']; } ?>
                    </div>
                    <div class="about">
                        <b>ABOUT ME</b><br> <?php if($userinfo){ echo $userinfo['about']; } ?>
                    </div>
                </div>
                <div class="edit-button">
                    <i class="fa fa-pencil"></i>
                </div>
            </div>
            <div class="posts">
                <?php
                if($posts){
                    for($i =0 ;$i < count($posts);$i++){
                            echo "
                                <div class='last-post'>
                                <div class='info'>

                                    <div class='photo'>
                                        <img src='".$userinfo['img']."' onerror='ImageReplace(this);'>
                                    </div>
                
                                    <div class='cont'>

                                        <div class='name'>"
                                        .$userinfo['name'].
                                        "</div>

                                        <div class='time'>
                                        ".$posts[$i]['time']."
                                        </div>

                                    </div>   
                                </div>

                                <div class='post'>";

                                echo $posts[$i]['text'];
                                
                                if($posts[$i]['img'] != null){
                                    echo '<div class"post-img"><br><img alt="!sorry cant load image!" src=" '.$posts[$i]['img'].'"></div> '  ;
                                }   
                                echo "</div></div>";
                        }
                    }
                ?>
            </div>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/profile.js"></script>
</body>
</html>