<?php session_start();//start the session

include('global/global.php');//Include database connection and other stuff
include('includes/header.php');//Is there a better way to do this?
$err = null;

//Check if the login form was submitted and do the typical login shit
if(isset($_POST['loginSubmit'])) {

    //Credentials
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";//Query to get the correct user
    $query = $conn->prepare($sql);//Prepare to avoid sql injections and other stuff

    if($query->execute(array($username))) {

        //Loop through the results (Should only be one result for the user)
        while ($row = $query->fetch()) {

            $hashed_password = $row[2];//Get the users password from result
            //Verify that the password entered matches the password in the database
            if(password_verify($password, $hashed_password)) {

                //Store user info in session
                $_SESSION['id'] = $row[0];
                $_SESSION['username'] = $row[1];
                $_SESSION['email'] = $row[3];
                $_SESSION['city'] = $row[4];
                $_SESSION['state'] = $row[5];
                $_SESSION['zip'] = $row[6];
                $_SESSION['loggedIn'] = true;
                //$_SESSION['priv'] = $row[?];//Add privledges later
                header('location: index.php');//Redirect to site/profile/whatever I eventually decide this site is
            } else {

                $err = "Either your username or password is invalid. Please try again";
            }
        }
    } else {

        echo "error";//Not a good error message
    }
}

?>

<?php echo $err;//Error message for invalid login attempt ?>
<form id="loginForm" method="POST" action="">
    <label for="username">Username:</label><br>
    <input type="text" placeholder="username" name="username"><br><br>
    <label for="password">Password:</label><br>
    <input type="password" placeholder="password" name="password"><br><br>
    <input type="submit" value="login" name="loginSubmit">
</form>

<?php include('includes/footer.php'); ?>