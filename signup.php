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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="plugins/bootstrap-4.6.0-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">

    <title>Sign Up</title>

</head>

<body>

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
    <div class="container text-center">
        <div class="login">

            <h1>SIGN UP</h1>
            <p>Please enter your Id and Password</p>
            <div class="form__group field">

                <form method="POST">
                    <input type="text" class="form__field" placeholder="Name" name="name">
                    <input type="email" class="form__field" placeholder="Email" name="email" required>
                    <input type="tel" class="form__field" placeholder="Phone no." name="phone">
                    <input type="text" class="form__field" placeholder="username" name="user_name">
                    <input type="password" class="form__field" placeholder="password" name="password">
                    <div>
                        <input type="submit" value="Sign Up">
                    </div> <br>
                    <br>
                    <p>Already have an account</p>
                    <a href="login.php">Login</a>
                    <br><br>
                    <div class="spacer" style="height: 30px;"></div>
                    <a href="index.php">Home</a>
                </form>
            </div>
        </div>
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>