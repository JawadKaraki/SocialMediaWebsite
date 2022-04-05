<?php
session_start();

if(!$_SESSION['id']){
    header('location:login.php');
}

include("php/connection.php");
include("php/addpost.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/replaceImage.js"></script>
</head>
<body>
    <div class="blur"></div>
    <div class="view-image">
    </div>
    <div class="add-post">
        ADD POST 
        <form method="post">
            <input type="text" id="post-text" name="text" placeholder="T E X T   H E R E" required />
            <input name = "image" type="text" id="post-image" placeholder = "I M A G E   U R L" />
            <select name="category" id="category">
                <option value="">none</option>
                <option value="sports">sports</option>
                <option value="animals">animals</option>
                <option value="jobs">jobs</option>
                <option value="food">food</option>
                <option value="poeple">poeple</option>
            </select>
            <input type="submit" id="post-submit" value="S U B M I T" />
        </form>
    </div>
    <div class="navbar">
        <div class="logo">
            SOCIAL
        </div>
        <div class="logo-place">
        </div>
        <div class="search">
            <input id="search" type="text" placeholder="S   E   A   R   C   H" onKeyUp="search()">
        </div>
        <div class="icons">
            
            <div class="icon" id="plus">
                <em class="fa fa-plus" ></em>
            </div>
            <div class="icon-box" id="not">
                <p class="title">NOTIFICATIONS</p>
            </div>
            <div class="icon" id="notIcon">
                <em class="fa fa-bell"></em>
            </div>
            <div class="icon-box" id="mass">
                <p class="title">MASSAGES</p>
                <div class="massage">
                  <p class="mass-text">YOU GOT ONE LIKE</p>
                  <p class="mass-time">2 hours ago</p>
                </div>
            </div>
            <a href="profile.php?who=<?php echo $_SESSION['id'] ?>" class="icon">
                <em class="fa fa-user"></em>
            </a>
        </div>
        <div class="profile"></div>
    </div>
    <div class="main">
        <div class="left-cont-place">
        </div>
        <div class="left-cont">
            <div class="categ">
                <p class="category" id="category1" onClick="getData('none')">
                    ALL POSTS
                </p>
                <p class="category" id="category3" onClick="getData('food')">
                    FOOD
                </p>
                <p class="category" id="category4" onClick="getData('animals')">
                    ANIMALS
                </p>
                <p class="category" id="category5" onClick="getData('sports')">
                    SPORTS
                </p>
                <p class="category" id="category6" onClick="getData('poeple')">
                    POEPLE
                </p>
                <p class="category" id="category7" onClick="getData('jobs')">
                    JOBS
                </p>
                <a href="php/logout.php" class="category" id="category8">
                    LOGOUT
                </a>
            </div>
        </div>
        <div class="posts-cont" id="posts-cont">
        </div>
        <div class="right-cont">
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="js/index.js"></script>
</body>
</html>