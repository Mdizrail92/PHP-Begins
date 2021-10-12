<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($conn);
date_default_timezone_set('Asia/Kolkata');

// images insertion in database
if (isset($_POST['submit'])) {

    $uploadsDir = "images/";
    $allowedFileType = array('jpg', 'png', 'jpeg');

    // Velidate if files exist
    if (!empty(array_filter($_FILES['fileUpload']['name']))) {

        // Loop through file items
        foreach ($_FILES['fileUpload']['name'] as $id => $val) {
            // Get files upload path
            $fileName        = $_FILES['fileUpload']['name'][$id];
            $tempLocation    = $_FILES['fileUpload']['tmp_name'][$id];
            $targetFilePath  = $uploadsDir . $fileName;
            $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            $uploadDate      = date('Y-m-d H:i:s');
            $uploadOk = 1;

            if (in_array($fileType, $allowedFileType)) {
                if (move_uploaded_file($tempLocation, $targetFilePath)) {
                    $sqlVal = "('" . $fileName . "', '" . $uploadDate . "')";
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "File coud not be uploaded."
                    );
                }
            } else {
                $response = array(
                    "status" => "alert-danger",
                    "message" => "Only .jpg, .jpeg and .png file formats allowed."
                );
            }
            // Add into MySQL database
            if (!empty($sqlVal)) {

                $insert = $conn->query("INSERT INTO gallery (images, date_time) VALUES $sqlVal");

                if ($insert) {
                    $response = array(
                        "status" => "alert-success",
                        "message" => "Files successfully uploaded."
                    );
                } else {
                    $response = array(
                        "status" => "alert-danger",
                        "message" => "Files coudn't be uploaded due to database error."
                    );
                }
            }
        }
    } else {
        // Error
        $response = array(
            "status" => "alert-danger",
            "message" => "Please select a file to upload."
        );
    }
}

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
    <title>Gallery</title>
</head>
<style>
    .container {
        max-width: 450px;
    }

    .imgGallery img {
        padding: 8px;
        max-width: 100px;
    }
</style>

<body>


    <div class="container mt-5">
        <a href="logout.php">Logout</a>
        <h1>Hello World From </h1>
        <br>
        <a href="index.php">Go to Home</a>
        <br>



        <?php
        if ($user_data['user_id'] == "9223372036854775807") {
        ?>
            <form action="" method="post" enctype="multipart/form-data" class="mb-3">
                <h3 class="text-center mb-5 mt-5">This is Israil's Gallery</h3>

                <div class="user-image mb-3 text-center">
                    <div class="imgGallery">
                        <!-- Image preview -->
                    </div>
                </div>

                <div class="custom-file">
                    <input type="file" name="fileUpload[]" class="custom-file-input" id="chooseFile" multiple>
                    <label class="custom-file-label" for="chooseFile">Select file</label>
                </div>


                <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                    Upload Files
                </button>
            </form>
        <?php
        }
        ?>
        <div class="spacer" style="height: 100px;"></div>
        <div id="carouselExampleIndicators" class="container carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $sql = "SELECT * FROM gallery";
                $result =  mysqli_query($conn, $sql);
                $number_of_images = mysqli_num_rows($result);
                for ($i = 0; $i < $number_of_images; $i++) {
                ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" <?php if ($i == 0) {
                                                                                                        echo 'class="active"';
                                                                                                    } ?>></li>
                <?php
                }
                ?>
            </ol>
            <div class="carousel-inner">


                <?php

                for ($i = 0; $i < $number_of_images; $i++) {
                    $row = mysqli_fetch_assoc($result);
                ?>

                    <div class="carousel-item <?php if ($i == 0) {
                                                    echo "active";
                                                } ?>">
                        <img src="images/<?php echo $row['images']; ?>" class="d-block w-100" alt="...">
                    </div>

                <?php
                }
                ?>




            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="spcacer" style="height: 100px;"></div>

    <!-- Gallery Content -->
    <div class="container-fluid">

        <h1 class="fw-light text-center text-lg-start mt-4 mb-0"> Gallery of Love</h1>

        <hr class="mt-2 mb-5">

        <div class="row text-center text-lg-start mb-4">
            <?php
            $sql = "SELECT * FROM gallery";
            $result =  mysqli_query($conn, $sql);
            $number_of_images = mysqli_num_rows($result);
            for ($i = 0; $i < $number_of_images; $i++) {
                $row = mysqli_fetch_assoc($result);

            ?>

                <div class="col-lg-3 col-md-4 col-6">

                    <a href="post.php?gid=<?php echo $row['id']; ?>" class="d-blockh-100">
                        <img src="images/<?php echo $row['images']; ?>" class="img-fluid img-thumbnail" alt="">
                    </a>
                    <br>
                    <p class="post-description"><?php echo $row['description']; ?></p>
                    <?php
                    if ($user_data['user_id'] == "9223372036854775807") {
                        echo "<form method='POST' action='editDescription.php'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <input type='hidden' name='date_time' value='" . $row['date_time'] . "'>
                    <input type='hidden' name='description' value='" . $row['description'] . "'>   <br> 
<button class='btn btn-primary' type='submit'>Edit</button>
</form>";
                    }
                    ?>
                    <br>
                </div>


            <?php
            }
            ?>



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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script>
        $(function() {

            var multiImgPreview = function(input, imgPreviewPlaceholder) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#chooseFile').on('change', function() {
                multiImgPreview(this, 'div.imgGallery');
            });
        });
    </script>


</body>

</html>