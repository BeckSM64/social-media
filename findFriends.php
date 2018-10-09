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

//List all people you are not currently friends with
$notFriendsList = getNotFriendsList($conn);

foreach($notFriendsList as $notFriend) {
    $notFriendID = $notFriend[0];
    echo $notFriend[1];
?>
    <!-- Form to send friend request based on user id -->
    <form id="addFriendForm" method="POST" action="addFriend.php">
        <input type="hidden" name="notFriendID" value="<?php echo $notFriendID ?>">
        <input type="submit" name="addFriendBtn" value="Send Friend Request">
    </form>
<?php
    echo "<br>";
}

include('includes/footer.php'); ?>