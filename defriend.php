<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');

//Check if the user clicked the add friend button or just found the exact URL
if(isset($_POST['defriendBtn'])) {

    $friendID = $_POST['friendID'];
    if(defriend($conn, $friendID)) {
        echo "SUCCESS. Friend Deleted.";
        header("refresh:3; url=friendsList.php");//Redirect. Probably change this to javascript alert and redirect
    } else {
        echo "Failed to delete friend";
    }

} else {
    echo "You can't just go to random URLs, bruh";
}