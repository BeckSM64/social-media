<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');

//Check if the user is logged in or not
if(!$_SESSION['loggedIn']) {
    header('location: login.php');//Send that user away until they come back with the proper credentials!
} else {
    include('includes/header.php');
}

//Check if the message button was pressed
//if(isset($_POST['sendMessageBtn'])) {

$friendID = $_POST['friendID'];//Get submitted friend id
$messageText = $_POST['messageText'];//Get the message

//List all current messages with user
if(sendMessage($conn, $friendID, $messageText)) {
    //header('location: message.php?friendID=' . $friendID);//Redirect back to conversation
} else {
    echo "Message failed to send";
    //header('refresh:3; url=message.php?friendID=' . $friendID);//Redirect back to conversation
}
//} else {
    //header('location: friendsList.php');//Redirect back to friends list if page is accessed directly
//}

include('includes/footer.php'); ?>