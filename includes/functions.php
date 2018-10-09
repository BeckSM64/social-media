<?php session_start();

/*
 * All functions currently take the database
 * connection variable as an argument.
 * This may be temporary as I have no idea
 * what I am doing or if this is even the 
 * right way to do this.
 */

 /* Get a record of a friend based on provided friend user id */
function getFriend($con, $targetUserID) {

    $sql = "SELECT * FROM users WHERE users.id = ?";
    
    $query = $con->prepare($sql);
    if($query->execute(array($targetUserID))) {
        $friend = $query->fetchAll();//Will be array but should only have one list element (one friend)
        return $friend;
    } else {
        echo "FAILED TO RETRIEVE FRIEND";
    }
}

/* Get a list of all the people that the curret user is friends with. Returns an array of friends */
function getFriendsList($con) {

    $userID = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE users.id IN 
            (SELECT user1 FROM relationship WHERE user2 = ?
            AND status = 1
            UNION
            SELECT user2 FROM relationship WHERE user1 = ?
            AND status = 1)";//Query to get all friends

    $query = $con->prepare($sql);//Prepare to avoid bad stuff
    if($query->execute(array($userID, $userID))) {

        $rowOfFriends = $query->fetchAll();//Get results
        return $rowOfFriends;
    } else {
        echo "FAILED TO RETRIEVE FRIENDS LIST";//Give error message if can't retrieve friends list for whatever reason
    }
}

/* Get a list of people the current user is not yet friends with. */
function getNotFriendsList($con) {

    $userID = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE users.id NOT IN 
            (SELECT user1 FROM relationship WHERE user2 = ?
            UNION
            SELECT user2 FROM relationship WHERE user1 = ?)
            AND users.id != ?";//Query to get all not friends

    $query = $con->prepare($sql);//Prepare to avoid bad stuff
    if($query->execute(array($userID, $userID, $userID))) {

        $rowOfNotFriends = $query->fetchAll();//Get results
        return $rowOfNotFriends;
    } else {
        echo "FAILED TO RETRIEVE NOT FRIENDS LIST";//Give error message if can't retrieve friends list for whatever reason
    }
}

/* Get users that have had a friend request sent to them by current user */
function getSentFriendRequests($con) {

    $userID = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE users.id IN
            (SELECT user1 FROM relationship WHERE user2 = ?
            AND user_action_id = ?
            AND status = 0
            UNION
            SELECT user2 FROM relationship WHERE user1 = ?
            AND user_action_id = ?
            AND status = 0)";

    $query = $con->prepare($sql);
    if($query->execute(array($userID, $userID, $userID, $userID))) {
        $sentFriendRequests = $query->fetchAll();//Get array of requests
        return $sentFriendRequests;
    } else {
        echo "FAILED TO RETRIEVE PENDING FRIEND REQUESTS";
    }
}

function getFriendRequests($con) {

    $userID = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE users.id IN
            (SELECT user1 FROM relationship WHERE user2 = ?
            AND user_action_id != ?
            AND status = 0
            UNION
            SELECT user2 FROM relationship WHERE user1 = ?
            AND user_action_id != ?
            AND status = 0)";

    $query = $con->prepare($sql);
    if($query->execute(array($userID, $userID, $userID, $userID))) {
        $friendRequests = $query->fetchAll();
        return $friendRequests;
    } else {
        echo "FAILED TO RETRIEVE FRIEND REQUESTS";
    }
}

function getBlockedFriends() {

}

/* Get relationship between logged in user and another user. Returns true if they are friends, false if not */
function getRelationship($con, $targetUserID) {

    $userID = $_SESSION['id'];
    $sql = "SELECT * FROM 
            relationship WHERE
            ? IN (user1, user2) AND 
            ? IN (user1, user2)";
    $query = $con->prepare($sql);

    //Check if a relationship between the two users exists
    if($query->execute(array($userID, $targetUserID))) {

        $relationship = $query->fetch();
        $status = $relationship[3];//Get the status of the relationship

        //If a relationship does exist, check to see if they are friends, or awaiting a response to a friend request
        if($status) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/* Send a friend request. Takes the ID of the friend being requested as an argument */
function addFriendRequest($targetUserID, $con) {

    $actionUserID = $_SESSION['id'];
    $sql = "INSERT INTO relationship 
            (user1, user2, status, user_action_id)
            VALUES (?, ?, 0, ?)";
    $query = $con->prepare($sql);

    if($query->execute(array($actionUserID, $targetUserID, $actionUserID))) {
        return true;
    } else {
        return false;
    }
}

/* Accept a friend request from another user. Return true or false depending on the success of executing the query to update the relationship */
function acceptFriendRequest($con, $requestSenderID) {

    $userID = $_SESSION['id'];
    $sql = "UPDATE relationship SET status = 1
            WHERE user_action_id = ?
            AND ? IN (user1, user2)";
    $query = $con->prepare($sql);
    if($query->execute(array($requestSenderID, $userID))) {
        return true;
    } else {
        return false;
    }
}

/* Decline friend requests by deleting relationship that has status of 0. A relationship that hasn't been approved yet */
function declineFriendRequest($con, $targetUserID) {

    $userID = $_SESSION['id'];
    $sql = "DELETE FROM relationship 
            WHERE ? IN (user1, user2)
            AND ? IN (user1, user2)
            AND user_action_id = ?
            AND status = 0";

    $query = $con->prepare($sql);
    if($query->execute(array($userID, $targetUserID, $targetUserID))) {
        return true;
    } else {
        return false;
    }
}

/* Cancel a sent friend request by deleting the record from the relationship table */
function cancelFriendRequest($con, $targetUserID) {

    $userID = $_SESSION['id'];
    $sql = "DELETE FROM relationship WHERE ?
            IN (user1, user2) AND ?
            IN (user1, user2) AND
            user_action_id = ?";

    $query = $con->prepare($sql);
    if($query->execute(array($userID, $targetUserID, $userID))) {
        return true;
    } else {
        return false;
    }
}

/* Remove friend from friends list. Deletes record from relationship table containing current and target user ids */
function defriend($con, $targetUserID) {

    $userID = $_SESSION['id'];
    $sql = "DELETE FROM relationship
            WHERE ? IN (user1, user2)
            AND ? IN (user1, user2)";

    $query = $con->prepare($sql);
    if($query->execute(array($userID, $targetUserID))) {
        return true;
    } else {
        return false;
    }
}

function block() {

}

function unBlock() {

}

/* Get all of the messages between the current user and the target user */
function getMessages($con, $targetUserID) {

    $userID = $_SESSION['id'];
    $sql = "SELECT * FROM message WHERE ?
            IN (userSent, userReceived) AND ?
            IN (userSent, userReceived)";
    
    $query = $con->prepare($sql);
    if($query->execute(array($userID, $targetUserID))) {

        $messages = $query->fetchAll();
        return $messages;
    } else {
        echo "Failed to retrieve messages with this user";
    }
}

/* Send a message to a user. Adds a record to the message table with both user ids and returns boolean depending on success */
function sendMessage($con, $targetUserID, $messageText) {

    $userID = $_SESSION['id'];
    $currentDateTime = date('Y-m-d H:i:s');//Get the current date and time

    $sql = "INSERT INTO message
            (userSent, userReceived, messageText, timestamp)
            VALUES (?, ?, ?, ?)";
    $query = $con->prepare($sql);

    if($query->execute(array($userID, $targetUserID, $messageText, $currentDateTime))) {
        return true;
    } else {
        return false;
    }
}

/* Checks if a conversation between the logged in user and another user exists. Returns true if exists, false if not */
function conversationExists($con, $targetUserID) {

    $userID = $_SESSION['id'];
    $sql = "SELECT * FROM message WHERE ? 
            IN (userSent, userReceived) AND ? 
            IN (userSent, userReceived)";

    $query = $con->prepare($sql);
    if($query->execute(array($userID, $targetUserID))) {

        //Check if more than 0 rows exist
        if($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

/* Add post to a user profile, foreign key references profile from posts table. Return true or false depending on success */
function addPost($con, $postedToID, $title, $text) {

    $userID = $_SESSION['id'];
    $currentDateTime = date('Y-m-d H:i:s');//Get the current date and time
    $sql = "INSERT INTO posts 
            (postedByID, postedToID, title, text, likesCount, commentsCount, timestamp) 
            VALUES (?, ?, ?, ?, 0, 0, ?)";
    
    $query = $con->prepare($sql);
    if($query->execute(array($userID, $postedToID, $title, $text, $currentDateTime))) {
        return true;
    } else {
        return false;
    }
}

/* Get all of the posts that have been posted on a user's profile. Returns an array of posts */
function getProfilePosts($con, $targetUserID) {

    $sql = "SELECT * FROM posts WHERE postedToID = ?";
    $query = $con->prepare($sql);

    //Check if posts can be collected
    if($query->execute(array($targetUserID))) {

        $posts = $query->fetchAll();
        if(count($posts) < 1) {
            return false;//No posts found for provided user id
        } else {
            return $posts;
        }
    } else {
        return false;//Error
    }
}

//Get all the posts in the posts table
function getAllPosts($con) {

    //Query to get all posts
    $sql = "SELECT * FROM posts";
    $query = $con->prepare($sql);

    if($query->execute()) {
        $posts = $query->fetchAll();
        return $posts;
    } else {
        return false;
    }
}

//Get all comments associated with provided post id
function getPostComments($con, $postID) {

    $sql = "SELECT * FROM comments WHERE postID = ?";
    $query = $con->prepare($sql);

    if($query->execute(array($postID))) {

        $postComments = $query->fetchAll();
        return $postComments;
    } else {
        return false;
    }
}

function addPostComment($con, $postID, $commentText) {

    $sql = "INSERT INTO comments (postID, commentText) VALUES (?, ?)";
    $query = $con->prepare($sql);

    if($query->execute(array($postID, $commentText))) {
        return true;
    } else {
        return false;
    }
}