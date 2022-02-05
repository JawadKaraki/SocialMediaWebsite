<?php

include("connection.php");
//fisrt pull all users that match the search result from database
$search = $_POST['search'];
if($search){
    $query = "
        SELECT IFNULL(users.img,'https://cdn.dribbble.com/users/112330/screenshots/15505990/media/a40608176e1c04daeeb247d61f7c4d5f.png?compress=1&resize=400x300') as prof,users.name as name,users.id as id
        FROM users
        WHERE name LIKE '%".$search."%';
        ";
}else{
    die('');
}
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) > 0){
    for($i = 0; $user = mysqli_fetch_assoc($result) ;$i++){
        $users[$i] = $user; 
     }
}else{
    //if no data is found write no results
    die('<div class="result">
            <div class="result-name" style="text-align:center;width:100%;">
                <p>SORRY NO RESULTS</p>
            </div>
        </div>');
}
foreach($users as $user){
    //echo each user found
    echo '
        <div class="result" >
            <a href="profile.php?who='.$user['id'].'" class="result-photo">
                <img src="'.$user['prof'].'">
            </a>
            <div class="result-name">
                <p>'.$user['name'].'</p>
            </div>
        </div> 
    
    ';
}

?>