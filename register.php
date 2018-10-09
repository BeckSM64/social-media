<?php include('includes/header.php'); include('global/global.php'); 

if(isset($_POST['registerSubmit'])) {

    //Get form input data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    //Check if username already exists (May change to Ajax appraoch)
    $sql = "SELECT username FROM users WHERE username = ?";
    $query = $conn->prepare($sql);//Prepare the query to avoid bad stuff

    //Execute query and if it finds a record, username was already taken
    $query->execute(array($username));

    if($query->rowCount() > 0) {
        $usernameErr = "Username already taken. Please try a different username";//Set the error message for username being taken
    } else {
        
        //Check if passwords entered match
        if($password != $confirmPassword) {
            $passwordErr = "Passwords do not match. Please reconfirm your password";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);//Hash the password before it is inserted in database
            $sql = "INSERT INTO users (username, password, email, city, state, zip) VALUES (?, ?, ?, ?, ?, ?)";//SQL to create new user
            $query = $conn->prepare($sql);

            if($query->execute(array($username, $hashedPassword, $email, $city, $state, $zip))) {

                echo "User Successfully Created: " . $username;

                //Stuff to send confirmation email
                $to = $email;
                $subject = "Filler Site Title - Account Create Confirmation";
                $message = "Your account has been successfully created. You can now login at: ?";
                $headers = "From: accountCreate@someSite.com" . "\r\n" . "CC: becksm64@gmail.com";//CC dev
                //mail($to, $subject, $message, $headers);//Send confirmation email

            } else {
                echo "User could not be created, please try again";
            }
        }
    }
    
}

?>

<h1>Register</h1>

<!-- Registration form -->
<form id="registerForm" method="POST" action="">
    <!-- Possibly use Ajax to check if userame is taken before submit? -->
    <label for="username">Username:</label><br>
    <input type="text" name="username" maxlength="20" required><br><br>
    <span style="color: red;" class="errorMessage"><?php if(isset($usernameErr)) { echo $usernameErr; } ?></span><br><!-- Get rid of inline styles -->
    <label for="password">Password:</label><br>
    <input type="password" name="password" required><br><br>
    <label for="confirmPassword">Confirm Password:</label><br>
    <input type="password" name="confirmPassword" required><br><br>
    <span style="color: red;" class="errorMessage"><?php if(isset($passwordErr)) { echo $passwordErr; } ?></span><br>
    <label for="email">Email:</label><br>
    <input type="email" name="email" maxlength="40" required><br><br>
    <label for="city">City:</label><br>
    <input type="text" name="city" maxlength="20"><br><br>
    <label for="State">State:</label><br>
    <input type="text" name="state" maxlength="2"><br><br>
    <label for="Zip">Zip:</label><br>
    <input type="number" name="zip" maxlength="5"><br><br>
    <input type="submit" name="registerSubmit">
</form>

<?php include('includes/footer.php'); ?>