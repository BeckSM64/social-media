<?php 

//Includes
include('global/global.php');
include('includes/functions.php');

//Check if the user is logged in or not
if(!$_SESSION['loggedIn']) {
    header('location: login.php');//Send that user away until they come back with the proper credentials!
}

//Header include
include('includes/header.php'); 

?>

<!-- These Session variables should always be set if you get to this page. But to be safe, should probably add isset() -->
<h1><?php echo $_SESSION['username']; ?></h1>
<h2><?php echo $_SESSION['email']; ?></h2>
<h2><?php echo $_SESSION['city']; ?></h2>
<h2><?php echo $_SESSION['state']; ?></h2>
<h2><?php echo $_SESSION['zip']; ?></h2>

<?php

//Display all posts on this profile
$posts = getProfilePosts($conn, $_SESSION['id']);
if($posts) {
    foreach($posts as $post) {
        echo $post[3] . '<br>';
        echo $post[4] . '<br><br>';
    }
} else {
    echo "THERE ARE NO POSTS";
}

?>

<!-- Form to add a post to user profile page -->
<h1>Add Post:</h1>
<form id="addPostForm" method="POST">
    <!-- value is just the logged in user ID because this is the myProfile page. 
    SO only the logged in user will be posting here -->
    <input type="hidden" name="postToID" value="<?php echo $_SESSION['id']; ?>">
    <input type="text" name="postTitle" maxlength="100" required>
    <br><br>
    <textarea name="postText" maxlength="1000" rows="4" required></textarea>
    <br><br>
    <input type="button" id="addPostBtn" name="addPostBtn" value="Add Post">
</form>

<?php include('includes/footer.php'); ?>