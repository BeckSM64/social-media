<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/message.js"></script>
    <script src="js/post.js"></script>
    <script src="js/comment.js"></script>
</head>

<header>
    <nav id="mainNav">
        <ul>
            <li><a href="index.php">Home</a></li>
            <!-- Show different nav options when user is logged in vs. logged out -->
            <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) { ?>
                <li><a href="myProfile.php">My Profile</a></li>
                <li><a href="friendsList.php">Friends List</a></li>
                <li><a href="findFriends.php">Find Friends</a></li>
                <li><a href="friendRequests.php">Friend Requests</a></li>
                <li><a href="sentRequests.php">Sent Requests</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>

<body>