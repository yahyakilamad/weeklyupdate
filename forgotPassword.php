<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yahya
 */
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    {
        $_SESSION['message'] = "User with that email address doesn't exist!";
        header("location: errorMessage.php");
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];

        // Session message to display on success.php
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
            . " for a confirmation link to complete your password reset!</p>";

        // Send registration confirmation link (reset.php)
        $to      = $email;
        $subject = 'Password Reset Link ';
        $message_body = '
        Hello '.$first_name.',

        You have requested password reset!

        Please click this link to reset your password:

        http://localhost/webApplicationDev/.idea/db/verifyUser.php?email='.$email.'&hash='.$hash;

        mail($to, $subject, $message_body);

        header("location: successMessage.php");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Your Password</title>
    <?php include 'css.html'; ?>
</head>

<body>

<div class="form">

    <h1>Reset Your Password</h1>

    <form action="forgotPassword.php" method="post">
        <div class="field-wrap">
            <label>
                Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name="email"/>
        </div>
        <button class="button button-block"/>Reset</button>
    </form>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="index.js"></script>
</body>

</html>
