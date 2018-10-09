<?php 

//Includes
include('global/global.php'); 
include('includes/functions.php');

//Check if the user clicked the add friend button or just found the exact URL
//if(isset($_POST['addPostBtn'])) {

//Get inputs submitted in post form
$postToID = $_POST['postToID'];
$postTitle = $_POST['postTitle'];
$postText = $_POST['postText'];

//Check success of adding post
if(addPost($conn, $postToID, $postTitle, $postText)) {
     echo "SUCCESS. Post Added";
} else {
    echo "Failure";
}
//header("refresh:3; url=friendsList.php");//Redirect. Probably change this to javascript alert and redirect

//} else {
//echo "You can't just go to random URLs, bruh";
//}