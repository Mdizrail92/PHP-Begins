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
    <link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="plugins/bootstrap-4.6.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <title>Document</title>

</head>

<body>
    <div class="container edit form__group">
        <a href="logout.php">Logout</a>
        <h1>Hello World From <?php echo $user_data['username']; ?></h1>
        <br>
        <a href="gallery.php">Go to gallery</a>
        <br>
        <?php
        $sql = "SELECT * FROM `gallery`";
        $result =  mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
            $images[$row['id']] = $row; //the $images array will store the images id from image_tb as an index, so you can call it directly like $images[x]
        }
        $random_img = array_rand($images); // this will give you a random image
        ?>

        <div class="spacer" style="height: 100px;"></div>
        <!-- comment section -->
        <img src="images/<?php print_r($images[$random_img][1]); ?>">
        <div class="spacer" style="height: 10px;"></div>
        <p><?php print_r($images[$random_img][2]); ?></p>
        <div class="spacer" style="height: 10px;"></div>
        <p><?php print_r($images[$random_img][3]); ?></p>
        <div class="spacer" style="height: 30px;"></div>
        <?php
        echo "<form method='POST' action='" . setComments($conn) . "'>
        <input type='hidden' name='uid' value='" . $user_data['id'] . "'>
        <input type='hidden' name='date' value='" . date('Y-m-d H:i:s') . "'>
        <textarea class='form__field' rows='4' cols='50' name='message'></textarea>    <br>  
        <button type='submit' name='commentSubmit'>Comment</button>
    </form>";

        getComments($conn);
        ?>
        <!-- comment section ends -->

    </div>

    <div class="spacer" style="height: 50px;"></div>
    <footer class="social-icons">
        <div class="container text-center">

            <ul>

                <li> <a href=" "><i style="color: rgb(163, 163, 163);" class="fab fa-github"></i></a> </li>
                <li> <a href=" "><i style="color: rgb(15, 112, 177);" class="fab fa-facebook"></i></a></li>
                <li> <a href=" "> <i style="color:#ff8744bd" class="fab fa-instagram"></i></a></li>

                <li> <a href=" "> <i style="color: rgb(211, 159, 15);" class="fab fa-snapchat-ghost"></i></a></li>
                <li> <a href=" "> <i style="color: rgb(59, 146, 228);" class="fab fa-twitter"></i></a></li>

            </ul>
            <hr>
            <div class="spacer" style="height: 5px;"></div>

            <p style="color: rgb(255, 255, 255); ">Israil &copy; 2021 All rights reserved</p>
        </div>
    </footer>
</body>

</html>