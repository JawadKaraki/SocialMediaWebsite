
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
                data: {friendid : who },
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
                data: {friendid : who },
                success: function(result){
                }
            });
            addButton = false; 
        }
    });
}