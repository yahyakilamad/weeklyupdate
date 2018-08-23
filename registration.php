<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yahya
 */
/* Registration process, inserts user info into the database
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page

$_SESSION['email_address'] = $_POST['email_address']
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
      
// Check to see if email address already exidt or not
$result = $mysqli->query("SELECT * FROM users WHERE email_address='$email_address'") or die($mysqli->error());

// If email address already exist then the row returns more than 0We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'Error! Email already exists! Please try again';
    header("location: errorMessage.php");
    
}
else { // If email does not exist the carry on with else

    
    $sql = "INSERT INTO users (first_name, last_name, email, password, hash) " 
            . "VALUES ('$first_name','$last_name','$email','$password', '$hash')";

    // Add new user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['active'] = 0; //0 until user activates their email
        $_SESSION['logged_in'] = true; // when the user has logged in
        $_SESSION['message'] =
                
                 "Thank you for registering. A confirmation email has been sent to $email, please verify
                 your account by clicking on the link in the email!";

        $to      = $email;
        $subject = 'Account Verification ';
        $message_body = '
        Hello '.$first_name.',

        Thank you for registering with us!

        Please click the link below to activate your account:

        http://localhost/login-system/verify.php?email='.$email.'&hash='.$hash;  

        mail( $to, $subject, $message_body );

        header("location: profilePage.php"); 

    }

    else {
        $_SESSION['message'] = 'Error! Registration failed! Please try again';
        header("location: errorMessage.php");
    }

}