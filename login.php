<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yahya
 */
/* User login process, checks if user exists and password is correct */

// SQL injections
$emailaddress = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE emailaddress='$emailaddress'");

if ( $result->num_rows == 0 ){ 
    $_SESSION['message'] = "Error! User with that email does not exist!";
    header("location: errorMessage.php");
}
else { 
    $user = $result->fetch_assoc();

    if ( password_verify($_POST['password'], $user['password']) ) {
        
        $_SESSION['emailaddress'] = $user['emailaddress'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['active'] = $user['active'];
        

        $_SESSION['logged_in'] = true;

        header("location: profilePage.php");
    }
    else {
        $_SESSION['message'] = "You have entered a incorrect password. Please try again!";
        header("location: errorMessage.php");
    }
}

