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

    <?php
    $photoid = $_GET['gid'];


    ?>
</head>

<body>
    <div class="container">
        <a href="logout.php">Logout</a>
        <h1>Hello World From <?php echo $user_data['username']; ?></h1>
        <br>
        <a href="gallery.php">Go to gallery</a>
        <br>
        <?php
        $sql = "SELECT * FROM `gallery` WHERE `id`='$photoid'";
        $result =  mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($result);

        ?>

        <div class="spacer" style="height: 100px;"></div>
        <!-- comment section -->
        <img src="images/<?php echo $row['images']; ?>">
        <div class="spacer" style="height: 10px;"></div>
        <p><?php print_r($row['date_time']); ?></p>
        <div class="spacer" style="height: 10px;"></div>
        <p><?php print_r($row['description']); ?></p>
        <div class="spacer" style="height: 30px;"></div>
        <?php
        echo "<form method='POST' action='" . setCommentsPost($conn) . "'>
        <input type='hidden' name='uid' value='" . $user_data['id'] . "'>
        <input type='hidden' name='gid' value='" . $photoid . "'>
        <input type='hidden' name='date' value='" . date('Y-m-d H:i:s') . "'>
        <textarea rows='4' cols='50' name='message'></textarea>    <br>  
        <button type='submit' name='commentSubmit'>Comment</button>
    </form>";

        getCommentsPost($conn, $photoid);
        ?>
        <!-- comment section ends -->

    </div>


</body>

</html>