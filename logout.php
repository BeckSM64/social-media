<?php session_start();

//Unset session variables
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['city']);
unset($_SESSION['state']);
unset($_SESSION['zip']);
unset($_SESSION['loggedIn']);

//Redirect back to login page
header('location: login.php');