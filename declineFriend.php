<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');

//Check if the user clicked the add friend button or just found the exact URL
if(isset($_POST['declineFriendBtn'])) {

    $requestSenderID = $_POST['targetUserID'];
    if(declineFriendRequest($conn, $requestSenderID)) {
        echo "SUCCESS. Friend Request Declined.";
        header( "refresh:3; url=friendRequests.php" );//Redirect. Probably change this to javascript alert and redirect
    } else {
        echo "Failed to decline friend request";
    }

} else {
    echo "You can't just go to random URLs, bruh";
}