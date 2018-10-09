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
$sentRequests = getSentFriendRequests($conn);

foreach($sentRequests as $sentRequest) {
    $targetUserID = $sentRequest[0];
    echo $sentRequest[1];

?>
    <form id="cancelRequestForm" method="POST" action="cancelRequest.php">
        <input type="hidden" name="targetUserID" value="<?php echo $targetUserID; ?>">
        <input type="submit" name="cancelRequestBtn" value="Cancel Friend Request">
    </form>
<?php
    echo "<br>";
}

include('includes/footer.php'); ?>