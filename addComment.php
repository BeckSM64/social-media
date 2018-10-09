<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');


//Get inputs submitted in post form
$postID = $_POST['postID'];
$commentText = $_POST['commentText'];

//Check success of adding comment
if(addPostComment($conn, $postID, $commentText)) {
    //echo "SUCCESS. Comment Added";
} else {
    //echo "Failure";
}