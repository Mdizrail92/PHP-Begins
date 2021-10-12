<?php
session_start();

include("connection.php");
include("functions.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //something was posted

    $username = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password) && !is_numeric($username)) {
        //read from database

        $query = "select * from users where username = '$username' limit 1";

        $result = mysqli_query($conn, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                $verify = password_verify($password, $user_data['password']);
                if ($verify == 1) {
                    $_SESSION['id'] = $user_data['id'];
                    header("Location: random-post.php");
                    die;
                }
            }
        }
        echo "Wrong Username or Password";
    } else {
        echo 'Please Enter Valid Information';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="plugins/bootstrap-4.6.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    <title>Login</title>
</head>

<body>
    <div class="container text-center">

        <div class="login">
            <h1>LOGIN</h1>
            <p>Please enter your Id and Password</p>
            <div class="form__group field">

                <form method="POST">

                    <input type="text" class="form__field" placeholder="username" name="user_name">
                    <input type="password" class="form__field" placeholder="password" name="password">
                    <input type="submit" value="Login">
            </div><br>
            <a href="signup.php">Sign UP</a><br>
            </form><br>
            <p>Forgot Password</p>
            <a href="forgot_password.php">Recover</a>
            <br><br>
            <div class="spacer" style="height: 30px;"></div>
            <a href="index.php">Home</a>

        </div>
    </div>

    <div class="spacer" style="height: 50px;"></div>
    <footer class="social-icons">
        <div class="container text-center">

            <ul>

                <li> <a href=" https://github.com/Mdizrail92"><i style="color: rgb(163, 163, 163);" class="fab fa-github"></i></a> </li>
                <li> <a href="https://www.facebook.com/profile.php?id=100007950183884 "><i style="color: rgb(15, 112, 177);" class="fab fa-facebook"></i></a></li>
                <li> <a href="https://www.instagram.com/israil_92/ "> <i style="color:#ff8744bd" class="fab fa-instagram"></i></a></li>

                <li> <a href=" "> <i style="color: rgb(211, 159, 15);" class="fab fa-snapchat-ghost"></i></a></li>
                <li> <a href="https://twitter.com/Izrail03620970 "> <i style="color: rgb(59, 146, 228);" class="fab fa-twitter"></i></a></li>

            </ul>
            <hr>
            <div class="spacer" style="height: 5px;"></div>

            <p style="color: rgb(255, 255, 255); ">Israil &copy; 2021 All rights reserved</p>
        </div>
    </footer>

</body>

</html>

<!-- 955829702988-942pb94mlt7r33bm6idac9j3koae7mam.apps.googleusercontent.com -->
<!-- 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-->