<?php

function check_login($conn)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "select * from users where user_id = '$id' limit 1";

        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // redirect to Login
    header("Location: login.php");
    die();
}

function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

// comment section
function setComments($conn)
{
    if (isset($_POST['commentSubmit'])) {
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '$message')";
        $result =  mysqli_query($conn, $sql);
    }
}

function getComments($conn)
{
    $sql = "SELECT * FROM comments";
    $result =  mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='comment mt-4 text-justify'>";
        echo $row['uid'] . "<br>";
        echo $row['date'] . "<br>";
        echo $row['message'];
        echo "</div>";
    }
}
// comment section ends


// delete gallery images
function deleteGallery($conn)
{
    if (isset($_GET['deleteImage'])) {
        $id = $_GET['id'];
        $sql = "select image from gallery where id='$id'";
        $image = mysqli_query($conn, $sql);
        $result = "delete from gallery where id='$id'";
        $delete =  mysqli_query($conn, $result);
    }
}
