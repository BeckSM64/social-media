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

$friendsList = getFriendsList($conn);//Get friends list
foreach($friendsList as $friend) {
    if(conversationExists($conn, $friend['id'])) {
        echo '<a href="message.php?friendID=' . $friend['id'] . '">' . $friend['username'] . '</a><br><br>';
    }
}