<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');

//Check if the user clicked the add friend button or just found the exact URL
if(isset($_POST['cancelRequestBtn'])) {

    $targetUserID = $_POST['targetUserID'];
    if(cancelFriendRequest($conn, $targetUserID)) {
        echo "SUCCESS. Friend Request Cancelled.";
    } else {
        echo "Failed to cancel friend Request";
    }
    header( "refresh:3; url=sentRequests.php" );//Redirect. Probably change this to javascript alert and redirect

} else {
    echo "You can't just go to random URLs, bruh";
}