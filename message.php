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
if(!isset($_GET['friendID'])) {
    header('location: friendsList.php');//Redirect back to friends list if page is accessed directly
}

?>
<div id="conversationMessages"><?php
    $friendID = $_GET['friendID'];
    //List all current messages with user
    $messages = getMessages($conn, $friendID);//Get all messages with desired user

    foreach($messages as $message) {

        //ID of the current logged in user
        $currentUserID = $_SESSION['id'];

        //Set message fields to variables
        $userSentID = $message[1];
        $userReceivedID = $message[2];
        $messageText = $message[3];
        $messageTime = $message[4];
        
        //Display all messages between the two users and show which message came from which user. Will add time stamp soon
        if($userSentID == $currentUserID) {
            echo 'Sent: ' . $messageText . '<br>';
        } else {
            echo 'Received: ' . $messageText . '<br>';
        }
    } ?>
</div>

<!-- Form to send messages to other user. Will eventually use AJAX so there are no page loads. 
Then, it will be scrapped completely in favor of a Socket solution because this solution is bullshit-->
<form id="sendMessageForm">
    <input type="hidden" name="friendID" value="<?php echo $_GET['friendID']; ?>">
    <textarea rows="2" type="text" id ="messageText" name="messageText" placeholder="Type message here..." autofocus required></textarea>
    <br>
    <input type="button" id="sendMessageBtn" name="sendMessageBtn" value="Send">
</form>

<?php

include('includes/footer.php'); ?>