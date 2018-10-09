<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');

//Check if the user is logged in or not
if(!$_SESSION['loggedIn']) {
    header('location: login.php');//Send that user away until they come back with the proper credentials!
} else {
    include('includes/header.php');//include header
}

$friendsList = getFriendsList($conn);//Call function to get list of friends
//echo count($friendsList);

foreach($friendsList as $friend) {

    //Set friend info to variables
    $friendID = $friend[0];//set friend id to variable
    echo '<a href="./viewProfile.php?friendID=' . $friend[0] . '">' . $friend[1] . '</a><br>';//Show friend username ?>

    <a href="./message.php?friendID=<?php echo $friendID; ?>">Send Message</a>
    <form id="defriendForm" method="POST" action="defriend.php">
        <input type="hidden" name="friendID" value="<?php echo $friendID ?>">
        <input type="submit" name="defriendBtn" value="Unfriend">
    </form>
<?php
    echo "<br>";
}

include('includes/footer.php'); ?>