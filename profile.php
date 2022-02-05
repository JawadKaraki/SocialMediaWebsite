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
            LOGO
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
                    <img class="proImg" src="<?php if($userinfo){echo $userinfo['img'];}?>" onerror="this.src='https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300'" />
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
                                        <img src='".$userinfo['img']."'>
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
    <script>
        //variables
        var me = <?php echo $_SESSION['id']; ?>;//get my id
        var who = <?php echo $who; ?>;//get visited profile's id
        var addButton = <?php echo $areFriends; ?>;//get if user is friends with visited profile
        var not = document.getElementById('not');
        var notIcon = document.getElementById('notIcon');
        var notclicked = false;

        //search users ajax call
        function search(){
        var val = $('#search').val();
            $.ajax({
                url: 'php/searchUsers.php',
                type: 'POST',
                data: {search : val },
                success: function(result){
                    $('.results').html(result);
                }
            }); 
        }

        //show notifications when notification icon is clicked
        notIcon.addEventListener('click',()=>{
            if(!notclicked){
                not.style.height = "400px";
                not.style.paddingBottom = "100px";
                notclicked = true;
                //call ajax to get latest notifications
                $.ajax({
                    url: 'php/getnotifications.php',
                    type: 'POST',
                    success: function(result){
                        $('#not').html(result);
                    }
                });
            }else{
                not.style.height = "0px";
                not.style.paddingBottom = "0px";
                notclicked = false;
            }
        });
        //check if visited profile is my profile or other user
        if(me == who){
            $('.edit-button').click(()=>{
                $('.edit').css({'display' : 'flex'});
            });
            $('.edit i').click(()=>{
                $('.edit').css({'display' : 'none'});
            });
        }else{
            //change edit button to add friend button(not my profile)
            if(addButton){
                    //edit button becomes (we are friends) button
                    $('.edit-button').html("<i class='fa fa-user-friends'></i>");
                    $('.edit-button').css({'transform' : 'rotate(360deg)'});
                    $('.edit-button').css({'background-color' : 'var(--red)'});
            }else{
                    //edit button becomes add friend button
                    $('.edit-button').html("<i class='fa fa-user-plus'></i>");
                    $('.edit-button').css({'transform' : 'rotate(0deg)'});
                    $('.edit-button').css({'background-color' : 'var(--white)'});

            }
            //toggle between add friend or unfriend
            $('.edit-button').click(()=>{
                //if not friends(addbutton = 0 or false) -> add friend button with animations
                if(!addButton){
                    $('.edit-button').html("<i class='fa fa-user-friends'></i>");
                    $('.edit-button').css({'transform' : 'rotate(360deg)'});
                    $('.edit-button').css({'background-color' : 'var(--red)'});
                    $.ajax({
                        url: 'php/addFriend.php',
                        type: 'POST',
                        data: {friendid : <?php echo $who; ?> },
                        success: function(result){
                        }
                    }); 
                    addButton = true;
                }else{//if friends (addbutton = 1 or true) -> unfriend button with animations
                    $('.edit-button').html("<i class='fa fa-user-plus'></i>");
                    $('.edit-button').css({'transform' : 'rotate(0deg)'});
                    $('.edit-button').css({'background-color' : 'var(--white)'});
                    $.ajax({
                        url: 'php/unFriend.php',
                        type: 'POST',
                        data: {friendid : <?php echo $who; ?> },
                        success: function(result){
                        }
                    });
                    addButton = false; 
                }
            });
        }

   </script>
</body>
</html>