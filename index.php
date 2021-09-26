<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($conn);

date_default_timezone_set('Asia/Kolkata');




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Document</title>

</head>

<body>
    <div class="container">
        <a href="logout.php">Logout</a>
        <h1>Hello World From <?php echo $user_data['username']; ?></h1>
        <br>
        <a href="gallery.php">Go to gallery</a>
        <br>

        <div class="spacer" style="height: 100px;"></div>
        <!-- comment section -->
        <img src="images/gal-gadotas (1).jpg" alt="">
        <div class="spacer" style="height: 30px;"></div>
        <?php
        echo "<form method='POST' action='" . setComments($conn) . "'>
        <input type='hidden' name='uid' value='" . $user_data['username'] . "'>
        <input type='hidden' name='date' value='" . date('Y-m-d H:i:s') . "'>
        <textarea name='message'></textarea>    <br>  
        <button type='submit' name='commentSubmit'>Comment</button>
    </form>";

        getComments($conn);
        ?>
        <!-- comment section ends -->

    </div>


</body>

</html>