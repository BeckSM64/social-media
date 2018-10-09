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

//Get the friendID from the url variable. Change to username when less stoned
if(isset($_GET['friendID'])) {

    $userID = $_SESSION['id'];
    $friendID = $_GET['friendID'];

    //If user is self, redirect to that user's profile page
    if($userID == $friendID) {
        header('location: myProfile.php');
    } else {
        if(!getRelationship($conn, $friendID)) {
            echo "You are not friends with this user and therefore cannot view their page";
        } else {

            //Get all of this friend's information to display as their profile
            $friendInfo = getFriend($conn, $friendID);
            foreach($friendInfo as $info) {

                //Friend info
                $friendUsername = $info[1];
                $friendEmail = $info[3];
                $friendCity = $info[4];
                $friendState = $info[5];
                $friendZip = $info[6];
            }
        }
    }
}

?>

<!-- Default user profile information displayed, for now -->
<h1><?php echo $friendUsername; ?></h1>
<h2><?php echo $friendEmail; ?></h2>
<h2><?php echo $friendCity; ?></h2>
<h2><?php echo $friendState; ?></h2>
<h2><?php echo $friendZip; ?></h2>

<div id="profilePosts"><?php
    //Display all posts on this profile
    $posts = getProfilePosts($conn, $friendID);
    if($posts) {
        foreach($posts as $post) {

            $authors = getFriend($conn, $post[1]);
            foreach($authors as $author) {
                echo '<strong>Posted by: ' . $author['username'] . '</strong><br>';
            }

            echo $post['title'] . '<br>';
            echo $post['text'] . '<br><br>';
            
            $postComments = getPostComments($conn, $post['id']);
            if($postComments) {
                foreach($postComments as $postComment) {
                    echo '<strong>Comment: ' . $postComment['commentText'] . '</strong><br>';//Show comments for this post
                }            
                ?>
                <form id="addPostCommentForm" method="POST">
                    <input type="hidden" name="postID" value="<?php echo $post['id']; ?>">
                    <textarea type="text" name="commentText" maxlength="1000" rows="2" required></textarea>
                    <br>
                    <input type="button" id="addPostCommentBtn" name="addPostCommentBtn" value="Add Comment">
                </form>
                <br>
            <?php
            }
        }
    } else {
        echo "THERE ARE NO POSTS";
    } ?>
</div>

<!-- Form to add a post to user profile page -->
<h1>Add Post:</h1>
<form id="addPostForm" method="POST">
    <input type="hidden" name="postToID" value="<?php echo $friendID; ?>">
    <input type="text" name="postTitle" maxlength="100" required>
    <br><br>
    <textarea name="postText" maxlength="1000" rows="4" required></textarea>
    <br><br>
    <input type="button" id="addPostBtn" name="addPostBtn" value="Add Post">
</form>

<?php include('includes/footer.php'); ?>