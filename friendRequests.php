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

//Get list of friend requests
$friendRequests = getFriendRequests($conn);
foreach($friendRequests as $friendRequest) {

    //Set friend values to more readable variables
    $friendID = $friendRequest[0];
    $friendUsername = $friendRequest[1];
    echo $friendUsername;
?>
    <!-- Form to accept friend request based on user id. Is there a way to not mix HTML and PHP or should I just not use PHP? -->
    <form id="acceptFriendForm" method="POST" action="acceptFriend.php">
        <input type="hidden" name="friendID" value="<?php echo $friendID ?>">
        <input type="submit" name="acceptFriendBtn" value="Accept Friend Request">
    </form>

    <form id="declineFriendForm" method="POST" action="declineFriend.php">
        <input type="hidden" name="targetUserID" value="<?php echo $friendID ?>">
        <input type="submit" name="declineFriendBtn" value="Decline Friend Request">
    </form>
<?php
    echo "<br>";
}

include('includes/footer.php') ?>