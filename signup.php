<?php
session_start();

include("connection.php");
include("functions.php");

$showError = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //something was posted
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['user_name'];
    $password = $_POST['password'];


    if (!empty($username) && !empty($password) && !is_numeric($username)) {

        // Check whether this username exists
        $existSql = "SELECT * FROM `users` WHERE username = '$username'";
        $result = mysqli_query($conn, $existSql);
        $numExistRows = mysqli_num_rows($result);
        if ($numExistRows > 0) {
            // $exists = true;
            $showError = "Username Already Exists";
        } else {
            //save to database
            $user_id = random_num(20);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = "insert into users (name, email, phone, user_id, username, password) values ('$name','$email', '$phone', '$user_id', '$username', '$password')";

            mysqli_query($conn, $query);
            header("Location: login.php");
            die;
        }
    } else {
        $showError = "Please Enter Valid Information";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Sign Up</title>
</head>

<body>
    <h1>Sign Up</h1>

    <?php
    if ($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div> ';
    }

    ?>


    <form method="POST">
        <input type="text" placeholder="Name" name="name">
        <input type="email" placeholder="Email" name="email" required>
        <input type="tel" placeholder="Phone no." name="phone">
        <input type="text" placeholder="username" name="user_name">
        <input type="password" placeholder="password" name="password">
        <input type="submit" value="Sign Up">

        <a href="login.php">Login</a>
    </form>



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>