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
        <?php

        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];


        echo "<form method='POST' action='" . editComments($conn) . "'>
        <input type='hidden' name='cid' value='" . $cid . "'>
        <input type='hidden' name='uid' value='" . $uid . "'>
        <input type='hidden' name='date' value='" . $date . "'>
        <textarea rows='4' cols='50' name='message'>" . $message . "</textarea>    <br>  
        <button type='submit' name='commentSubmit'>Edit</button>
        <button type='submit' name='commentDelete'>Delete</button>
    </form>";


        ?>
    </div>


</body>

</html>