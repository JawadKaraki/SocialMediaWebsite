
//variables
var ch = document.getElementById('chats');
var interv = 0;
var elmnt = document.getElementsByClassName("chats");

//functions
//print online and offline
function printData(r){
    var str;
    var onStr;
    var noOn;
    var n = '';
    $('.right-cont').html("");
    str = '<i class="fa fa-arrow-right" onClick="middle()"></i>';
    $('.right-cont').append(str);
    if(r.online != null){
        str = '<i class="fa fa-times" onClick="middle()"></i>';
        str+='<p class="right-header">ONLINE FRIENDS</p>';
        $('.right-cont').append(str);
        r.online.forEach(o =>{
            if(r.news){
                r.news.forEach(num => {
                    if(num.id == o.id){
                        n = num.num;
                    }
                });
            }
            onStr = '<div class="friend" onClick="sendData('+ o.id +');">';
            onStr+='<a href="profile.php?who='+ o.id +'" class="friend-photo">';
            onStr+='<img src="'+ o.prof +'" onerror="ImageReplace(this);"></a>';
            onStr+='<div class="friend-name"><p>'+ o.name +'</p></div><p class="num-new-mass">' + n + '</p>';
            onStr+='<div class="online" style="background-color:var(--green)"></div></div>';
            $('.right-cont').append(onStr);
            n='';
        });
    }else{
        noOn = '<p class="right-header">ONLINE FRIENDS</p>';
        noOn+='<div class="friend" style="background-color:var(--red);color:var(--dark);">';
        noOn+='<div class="friend-name" style="margin-left:40px;">';
        noOn+='<p>NO ONLINE FRIENDS</p></div></div>';
        $('.right-cont').append(noOn);
    }
    if(r.offline != null){
        str = '<p class="right-header">OFFLINE FRIENDS</p>';
        $('.right-cont').append(str);
        r.offline.forEach(o => {
            if(r.news){
                r.news.forEach(num => {
                    if(num.id == o.id){
                        n = num.num;
                    }
                });
            }
            onStr = '<div class="friend" onClick="sendData('+ o.id +');">';
            onStr+='<a href="profile.php?who='+ o.id +'" class="friend-photo">';
            onStr+='<img src="'+ o.prof +'" onerror="ImageReplace(this);"></a>';
            onStr+='<div class="friend-name"><p>'+ o.name +'</p></div><p class="num-new-mass">' + n + '</p>';
            onStr+='<div class="online" style="background-color:var(--red)"></div></div>';
            $('.right-cont').append(onStr);
            n='';
        });
    }else{
        noOn = '<p class="right-header">OFFLINE FRIENDS</p>';
        noOn+='<div class="friend" style="background-color:var(--red);color:var(--dark);">';
        noOn+='<div class="friend-name" style="margin-left:40px;">';
        noOn+='<p>NO OFFLINE FRIENDS</p></div></div>';
        $('.right-cont').append(noOn);
    }
    if(r.chats != null){
        str = '<p class="right-header">CHATS</p>';
        $('.right-cont').append(str);
        r.chats.forEach(o => {
            if(r.news){
                r.news.forEach(num => {
                    if(num.id == o.id){
                        n = num.num;
                    }
                });
            }
            onStr = '<div class="friend" onClick="sendData('+ o.id +');">';
            onStr+='<a href="profile.php?who='+ o.id +'" class="friend-photo">';
            onStr+='<img src="'+ o.prof +'" onerror="ImageReplace(this);"></a>';
            onStr+='<div class="friend-name"><p>'+ o.name +'</p></div><p class="num-new-mass">' + n + '</p>';
            onStr+='</div><div style="height:100px"></div>';
            $('.right-cont').append(onStr);
            n='';
        });
    }else{
        noOn = '<p class="right-header">CHATS</p>';
        noOn+='<div class="friend" style="background-color:var(--red);color:var(--dark);">';
        noOn+='<div class="friend-name" style="margin-left:40px;">';
        noOn+='<p>NO CHATS</p></div></div><div style="height:100px"></div>';
        $('.right-cont').append(noOn);
    }
    
}

//ajax calls
//ajax check online friends and call printdata to print online and offline
$.ajax({
    url: 'php/checkOnline.php',
    type: 'POST',
    success: function(result){
        printData(result);
    }
});
setInterval(()=>{
    $.ajax({
        url: 'php/checkOnline.php',
        type: 'POST',
        success: function(result){
            printData(result);
        }
    });
},3000);
//get the person to chat with through sendData(person),person is the target
function sendData(x){
    //change massage input to send massage to the right person
    var str = '<input type="text" name="massage" id="mass-inp"  placeholder="M    A    S    S    A    G    E"  onChange="sendMassage('+ x +');" />';
    str+='<i class="fa fa-paper-plane" id="send" name="send" onClick="sendMassage('+ x +');"></i>';
    $('#form').html(str);

    //hide chats menu
    middle();

    //scroll to the end of massages
    elmnt.scrollTop = 100;

    //close old interval of old chat
    if(interv){clearInterval(interv);}

    //get chat name and info
    $.ajax({
        url: 'php/getChatInfo.php',
        type: 'POST',
        data: {id : x},
        success: function(result){
            $('.chat-place .header').html(result);
    }});

    //get all old massages
    $.ajax({
        url: 'php/getAllMassages.php',
        type: 'POST',
        data: {id : x},
        success: function(result){
            $('.chats').html(result);
            //scroll to end of chats
            setTimeout(()=>{
                ch.scrollTop = ch.scrollHeight + 100;
            },100);
    }});

    //get new massages called every second
    var count = 0;//count is number of new massages
    interv = setInterval(()=>{
        $.ajax({
        url: 'php/getNewMassages.php',
        type: 'POST',
        data: {id : x},
        success: function(result){
            if(result){
                //remove 'start a conversation' if there is one
                $('.no-mass-err').css('display','none');
                if(count == 0){
                  $('.chats').append('<h1 class="new-mass">NEW MASSAGES</h1>');
                }
                count++;
                //scroll to bottom after each new massage
                setTimeout(()=>{
                    ch.scrollTop = ch.scrollHeight + 100;
                },100);
            }

            $('.chats').append(result);
        }});
   },1000);
}

//disable page refresh on massages
$(document).on('submit','#form',()=>{
    return false;
});

//send massage from input
function sendMassage(target){
    var massage = $('#mass-inp').val();
    $('#mass-inp').val("");
    $('.chats').append('<div class="my-mass">' +massage+'</div>');
    setTimeout(()=>{
        ch.scrollTop = ch.scrollHeight + 100;
    },100);
    $.ajax({
        url: 'php/sendMassage.php',
        type: 'POST',
        data: {id :target,massage:massage}
    });
}

//hide the chats menu container 
function middle(){
    if(window.innerWidth <= 1200){
        $('.show-chats').css({
            'right' : '0vw'
        });
        $('.right-cont').css({
            'right' : '-88vw'
        });
    }
}
//show chats function
function showChats(){
    if(window.innerWidth <= 1200){
        $('.show-chats').css({
            'right' : '88vw'
        });
        $('.right-cont').css({
            'right' : '0'
        });
    }
}
//run showChats when friends icon is clicked
$('.show-chats').click(()=>{
    showChats(); 
});