<?php

function check_login($conn)
{
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];

        $query = "select * from users where id = '$id' limit 1";

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

// set comment for posts
function setCommentsPost($conn)
{
    if (isset($_POST['commentSubmit'])) {
        $uid = $_POST['uid'];
        $gid = $_POST['gid'];
        $date = $_POST['date'];

        $message = $_POST['message'];

        $sql = "INSERT INTO comments (uid, gid, date, message) VALUES ('$uid', '$gid', '$date', '$message')";
        $result =  mysqli_query($conn, $sql);
    }
}


function getComments($conn)
{

    $sql = "SELECT * FROM comments";
    $result =  mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='comment mt-4 text-justify'><p>";
        $sql = "SELECT  `username` FROM `users` WHERE `id`='$row[uid]'";
        $username = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        echo $username['username'] . "<br>";

        echo $row['date'] . "<br>";
        echo nl2br($row['message']);
        if ($_SESSION['id'] == $row['uid']) {
            echo "</p>
        <form method='POST' action='editcomment.php'>
        <input type='hidden' name='cid' value='" . $row['cid'] . "'>
        <input type='hidden' name='uid' value='" . $row['uid'] . "'>
        <input type='hidden' name='date' value='" . $row['date'] . "'>
        <input type='hidden' name='message' value='" . $row['message'] . "'>
        <button>Edit</button>
        </form>
    </div>";
        }
    }
}



// get comments for posts
function getCommentsPost($conn, $photoid)
{

    $sql = "SELECT * FROM `comments` WHERE `gid`='$photoid'";
    $result =  mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='comment mt-4 text-justify'><p>";
        $sql = "SELECT  `username` FROM `users` WHERE `id`='$row[uid]'";
        $username = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        echo $username['username'] . "<br>";

        echo $row['date'] . "<br>";
        echo nl2br($row['message']);
        if ($_SESSION['id'] == $row['uid']) {
            echo "</p>
        <form method='POST' action='editcomment.php'>
        <input type='hidden' name='cid' value='" . $row['cid'] . "'>
        <input type='hidden' name='uid' value='" . $row['uid'] . "'>
        <input type='hidden' name='date' value='" . $row['date'] . "'>
        <input type='hidden' name='message' value='" . $row['message'] . "'>
        <button>Edit</button>
        </form>
    </div>";
        }
    }
}

function editComments($conn)
{
    if (isset($_POST['commentSubmit'])) {
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $sql = "UPDATE comments SET message='$message' WHERE cid='$cid'";
        $result =  mysqli_query($conn, $sql);
        header("Location: index.php");
    } else if (isset($_POST['commentDelete'])) {
        $cid = $_POST['cid'];
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        $sql = "Delete from comments WHERE cid='$cid'";
        $result =  mysqli_query($conn, $sql);
        header("Location: index.php");
    }
}




// comment section ends


// delete gallery images


function editGallery($conn)
{
    if (isset($_POST['descriptionSubmit'])) {
        $id = $_POST['id'];

        $description = $_POST['description'];
        $sql = "UPDATE gallery SET description='$description' WHERE id='$id'";


        $result =  mysqli_query($conn, $sql);
        header("Location: gallery.php");
    } else if (isset($_POST['deleteImage'])) {
        $id = $_POST['id'];
        $sql = "select image from gallery where id='$id'";
        $image = mysqli_query($conn, $sql);
        $result = "delete from gallery where id='$id'";
        $delete =  mysqli_query($conn, $result);
        header("Location: gallery.php");
    }
}
