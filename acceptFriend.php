<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');

//Check if the user clicked the add friend button or just found the exact URL
if(isset($_POST['acceptFriendBtn'])) {

    $requestSenderID = $_POST['friendID'];
    if(acceptFriendRequest($conn, $requestSenderID)) {
        echo "SUCCESS. Friend Added.";
        header( "refresh:3; url=friendRequests.php" );//Redirect. Probably change this to javascript alert and redirect
    } else {
        echo "Failed to accept friend request";
    }

} else {
    echo "You can't just go to random URLs, bruh";
}