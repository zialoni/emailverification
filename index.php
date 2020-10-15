<?php

$con = mysqli_connect('gator4207.hostgator.com','loni_zia','s0048','loni_phpEmailConfirmation');

if(mysqli_connect_errno()){
    echo mysqli_connect_errno();
    die();
}

$sql= "select * from users";
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res)>0) {
    while($row=mysqli_fetch_assoc($res)){
       
        echo '<pre>';
        print_r($row);
    }
}
else {
    echo "No data found";
}
?>