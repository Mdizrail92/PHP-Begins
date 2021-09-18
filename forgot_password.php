<?php
session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usernamefor = $_POST['usernamefor'];
    $query = "SELECT * FROM users WHERE username = '$usernamefor'";
    $result =  mysqli_query($conn, $query);

    if ($result  && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);


        $to_email = $row['email'];
        $subject = "Forgot Password";
        $body = $row['password'];
        $headers = "From: mdizrail92@gmail.com";
        echo $to_email . $subject . $body . $headers;
        if (mail($to_email, $subject, $body, $headers)) {
            echo "Email successfully sent to  $to_email...";
        } else {
            echo "Email sending failed...";
        }

        if (true) {

            echo '<script>alert("Password send to Your Email");</script>';
        }
    } else {
        header("Location: login.php");
        die;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body>
    <h1>Forgot Password</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])  ?>" method="POST">

        <input type="text" placeholder="Enter username" name="usernamefor">



        <input type="submit" value="Send OTP">


    </form>
    <p>In case You recalled your password</p><a href="login.php">Login</a>
</body>

</html>