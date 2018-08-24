<?php
/**
 * Created by IntelliJ IDEA.
 * User: Yahya
 * Date: 14/08/2018
 * Time: 11:26
 * Displays all error messages
 */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <?php include 'css.html'; ?
</head>
<body>
<div class="form">
    <h1>Error</h1>
    <p>
        <?php
        if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
            echo $_SESSION['message'];
        else:
            header( "location: index.php" );
        endif;
        ?>
    </p>
    <a href="index.php"><button class="button button-block"/>Home</button></a>
</div>
</body>
</html>