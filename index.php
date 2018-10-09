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

<div id="AllPosts"><?php
    //Display all posts in random order
    $posts = getAllPosts($conn);
    shuffle($posts);
    if($posts) {
        foreach($posts as $post) {
            $authors = getFriend($conn, $post[1]);
            foreach($authors as $author) {
                echo '<strong>Posted by: ' . $author[1] . '</strong><br>';
            }
            echo $post[3] . '<br>';
            echo $post[4] . '<br><br>';
        }
    } else {
        echo "THERE ARE NO POSTS";
    } ?>
</div>

<?php

//Include footer
include('includes/footer.php'); 

?>