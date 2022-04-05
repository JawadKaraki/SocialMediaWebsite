//variables:
var not = document.getElementById('not');
var notIcon = document.getElementById('notIcon');
var cat = "none";
var offset = 10;//offset of more posts

var notclicked = false;//notifications icon isclicked variable
var plusclicked = false;//add post icon isclicked variable

//functions and ajax calls:

//open notifications and hide it + change icon color
notIcon.addEventListener('click',()=>{
    if(!notclicked){
          not.style.zIndex = 10;
          not.style.height = "500px";
          not.style.paddingBottom = "30px";
          notIcon.style.transition = '0.5s';
          notIcon.style.backgroundColor = "var(--red)";
          notIcon.style.border = "0px";
          notclicked = true;
          //upadate notifications data
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
        notIcon.style.backgroundColor = "var(--dark)";
        notclicked = false;
    }
});
//change category colors
for( let i =1 ; i <= 8;i++){
    $('#category' + i).click(()=>{
        if(window.innerWidth <= 1200){middle();}
        $('.category').css({
            'background-color': 'var(--light)',
            'box-shadow': '0px 0px 30px 1px var(--dark)',
            'color': 'var(--white)'
        });

        $('#category' + i).css({
            'background-color': 'var(--red)',
            'box-shadow': '0px 0px 30px 1px var(--dark)',
            'color': 'var(--dark)'
        });

    });
}

//show add post form and hide it
$('#plus').click(()=>{
    if(!plusclicked){
        $('#plus').css({
            'transition' : '0.5s',
            'background-color': 'var(--red)',
            'transform':'rotate(45deg)',
            'border' : "0"
        })
        $('.add-post').css({
          'opacity' : "1",
          'visibility': 'visible'
          
        });
        plusclicked =  true;
    }else{
        $('.add-post').css({
            'opacity' : "0",
            'visibility': 'hidden'
        });
        $('#plus').css({
            'background-color': 'var(--dark)',
            'transform':'rotate(0deg)'
        })
        plusclicked = false;
    }
});
//fucntion to change like heart color
function changeColor(x,y){
    if($('.like').eq(x).css('color') == 'rgb(218, 221, 252)'){
            $('.like').eq(x).css('color','var(--red)');
            $('.nb-of-likes').eq(x).text( parseInt($('.nb-of-likes').eq(x).html()) + 1 );
            $.ajax({

                url: 'php/sendLike.php',
                type: 'POST',
                data: {likedid : y}
             }); 
    }else{
        $('.like').eq(x).css('color','var(--white)');
        $('.nb-of-likes').eq(x).text( parseInt($('.nb-of-likes').eq(x).html()) - 1 );
        $.ajax({
            url: 'php/deleteLike.php',
            type: 'POST',
            data: {likedid : y}
         }); 
    }


}
//get posts using ajax
function getData(category){
    offset = 10;
    cat = category;
    $.ajax({
        url: 'php/getFriendsPosts.php',
        type: 'POST',
        data: {category : category},
        success: function(result){
            $('.posts-cont').html(result);
        }
     }); 
}
//call function once at the start to get all posts
getData("none");
//search
function search(){
    var val = $('#search').val();
    $.ajax({
        url: 'php/getFriendsPosts.php',
        type: 'POST',
        data: {search : val },
        success: function(result){
            $('.posts-cont').html(result);
        }
     }); 
}
//comments section open
var comClicked = [];
function openCom(i,post){
    $.ajax({
        url: 'php/getComments.php',
        type: 'POST',
        data: {id : post},
        success: function(result){
            $('.comments-section').html(result);
        }
    }); 
    if(!comClicked[i]){
        $('.comments-section').eq(i).css({
        'height' : '400px',
        'padding-bottom' : '20px'
        });
        $('.see-comments').eq(i).css({
            'color' : 'var(--red)'
        })
        comClicked[i] = true;
    }else{
        $('.comments-section').eq(i).css({
            'height' : '0px',
            'padding-bottom' : '0px'
        });
        $('.see-comments').eq(i).css({
            'color' : 'var(--white)'
        })
        comClicked[i] = false;
    }
}
//send Comments
function sendCom(i,post){
    var val = $('.comment-input').eq(i).val();
    $('.comment-input').eq(i).val("");
    $.ajax({
        url: 'php/sendComment.php',
        type: 'POST',
        data: {id : post,text : val}
    });
    $.ajax({
        url: 'php/getComments.php',
        type: 'POST',
        data: {id : post},
        success: function(result){
            $('.comments-section').html(result);
        }
    });
}
//print online and offline friends data from the check online result down
function printData(r){
    var str;
    var onStr;
    var noOn;
    var n = '';
    //first empty the chats container
    $('.right-cont').html("");
    str = '<i class="fa fa-arrow-right" onClick="middle()"></i>';
    $('.right-cont').append(str);//print the exit button
    //if there is online users print this
    if(r.online != null){
        str+='<p class="right-header">ONLINE FRIENDS</p>';
        $('.right-cont').append(str);
        r.online.forEach(o =>{
            //check how many new massages this user have sent me
            if(r.news){
                r.news.forEach(num => {
                    if(num.id == o.id){
                        n = num.num;
                    }
                });
            }
            onStr = '<a href="chat.php?who='+ o.id +'" class="friend">';
            onStr+='<div class="friend-photo">';
            onStr+='<img src="'+ o.prof +'" onerror="ImageReplace(this);"></div>';
            onStr+='<div class="friend-name"><p>'+ o.name +'</p></div><p class="num-new-mass">' + n + '</p>';
            onStr+='<div class="online" style="background-color:var(--green)"></div></a>';
            $('.right-cont').append(onStr);
            n='';
        });
    }else{
        //if there is no online friends print this instead
        noOn = '<p class="right-header">ONLINE FRIENDS</p>';
        noOn+='<div class="friend" style="background-color:var(--red);color:var(--dark);">';
        noOn+='<div class="friend-name" style="margin-left:40px;">';
        noOn+='<p>NO ONLINE FRIENDS</p></div></div>';
        $('.right-cont').append(noOn);
    }
    //if there is offline friends print this
    if(r.offline != null){
        str = '<p class="right-header">OFFLINE FRIENDS</p>';
        $('.right-cont').append(str);//print header
        r.offline.forEach(o => {
            if(r.news){
                //check how many new massages this user have sent me
                r.news.forEach(num => {
                    if(num.id == o.id){
                        n = num.num;
                    }
                });
            }
            onStr = '<a href="chat.php?who='+ o.id +'" class="friend">';
            onStr+='<div class="friend-photo">';
            onStr+='<img src="'+ o.prof +'" onerror="ImageReplace(this);"></div>';
            onStr+='<div class="friend-name"><p>'+ o.name +'</p></div><p class="num-new-mass">' + n + '</p>';
            onStr+='<div class="online" style="background-color:var(--red)"></div></a>';
            $('.right-cont').append(onStr);
            n='';
        });
    }else{
        //no offline friends -> print this
        noOn = '<p class="right-header">OFFLINE FRIENDS</p>';
        noOn+='<div class="friend" style="background-color:var(--red);color:var(--dark);">';
        noOn+='<div class="friend-name" style="margin-left:40px;">';
        noOn+='<p>NO OFFLINE FRIENDS</p></div></div>';
        $('.right-cont').append(noOn);
    }
    //if there is other chats that i am not friends with 
    if(r.chats != null){
        str = '<p class="right-header">CHATS</p>';
        $('.right-cont').append(str);
        r.chats.forEach(o => {
            if(r.news){
                //check how many new massages this user have sent me
                r.news.forEach(num => {
                    if(num.id == o.id){
                        n = num.num;
                    }
                });
            }
            onStr = '<a href="chat.php?who='+ o.id +'" class="friend">';
            onStr+='<div class="friend-photo">';
            onStr+='<img src="'+ o.prof +'" onerror="ImageReplace(this);"></div>';
            onStr+='<div class="friend-name"><p>'+ o.name +'</p></div><p class="num-new-mass">' + n + '</p>';
            onStr+='</a><div style="height:100px"></div>';
            $('.right-cont').append(onStr);
            n = '';
        });
    }else{
        //print this instead
        noOn = '<p class="right-header">CHATS</p>';
        noOn+='<div class="friend" style="background-color:var(--red);color:var(--dark);">';
        noOn+='<div class="friend-name" style="margin-left:40px;">';
        noOn+='<p>NO CHATS</p></div></div><div style="height:100px"></div>';
        $('.right-cont').append(noOn);
    }
    
}
//check who is online when page first opens and print them
$.ajax({
    url: 'php/checkOnline.php',
    type: 'POST',
    success: function(result){
        printData(result);
    }
});
//check who is online every 3 seconds and update printed data
setInterval(()=>{
    $.ajax({
        url: 'php/checkOnline.php',
        type: 'POST',
        success: function(result){
            printData(result);
        }
    });
},3000);
//show categories menu
function leftShow(){

    $('.left-cont').css({
        'left':'0'
    });

}
//hide chat menu or categories menu
function middle(){
    if(window.innerWidth <= 1200 && window.innerWidth > 900 ){
        $('.right-cont').css({
            'right':'-50vw'
        });
    }
    if(window.innerWidth <= 900){
        $('.left-cont').css({
            'left':'-100vw'
        });
        $('.right-cont').css({
            'right':'-100vw'
        });
    }
  
}
//show chats menu
function rightShow(){
    if(window.innerWidth <= 1200 && window.innerWidth > 900 ){
        $('.right-cont').css({
            'right':'50vw'
        });
    }
    if(window.innerWidth <= 900 ){
        $('.right-cont').css({
            'right':'100vw'
        });
    }
}
//show more posts when this function is called
function more(){
    var val = $('#search').val();
    var category = cat;
    $.ajax({
        url: 'php/getMorePosts.php',
        type: 'POST',
        data: {category : category,search:val,offset:offset},
        success: function(result){
            if(result)
            {
                $('.more').css({'display':'none'});
                $('.posts-cont').append(result);
            }
        }
     }); 
     offset += 10;//add ten for posts offset for the next 10 posts
}