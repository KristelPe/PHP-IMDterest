<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    spl_autoload_register(function($class){
        include_once("classes/" . $class . ".class.php" );
    });

    $email = $_SESSION['user'];

    //find userid associated with the email address
    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $connection->prepare("SELECT id FROM users WHERE email = :email");
    $statement->bindvalue(":email", $email);
    $res = $statement->execute();
    $userid = $statement->fetchColumn();


    if(!empty($_POST["title"]) && !empty($_POST["description"])){

        if(!empty($_POST["link"]) && empty($_FILES["fileToUpload"]["name"])){
            $link = $_POST["link"];
            $title = $_POST["title"];
            $description = $_POST["description"];
            $afbeelding = "";

            $post = new Post();
            $post->setMTitle($title);
            $post->setMAfbeelding($afbeelding);
            $post->setMLink($link);
            $post->setMDescription($description);
            $post->setMUserId($userid);
            $post->Upload();
        }

        else if(!empty($_FILES["fileToUpload"]["name"]) && empty($_POST["link"])) {
                $title = $_POST["title"];
                $description = $_POST["description"];
                $link = "";

                if (!empty ($_FILES["fileToUpload"]["name"])) {
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    // Check if image file is a actual image or fake image
                    if (isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if ($check !== false) {
                            $uploadSuccess_isImage = "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            $uploadError_isNotImage = "File is not an image.";
                            $uploadOk = 0;
                        }
                    }
                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000) {
                        $uploadError_size = "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif"
                    ) {
                        $uploadError_type = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        $uploadError_ok = "Sorry, your file was not uploaded.";
                        // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            $uploadSuccess = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                            $afbeelding = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        } else {
                            $uploadError = "Sorry, there was an error uploading your file.";
                        }
                    }
                }

                if(!empty($afbeelding)) {
                    $post = new Post();
                    $post->setMTitle($title);
                    $post->setMAfbeelding($afbeelding);
                    $post->setMLink($link);
                    $post->setMDescription($description);
                    $post->setMUserId($userid);
                    $post->Upload();
                }
        }else{
            $imageError = "PLEASE UPLOAD AN IMAGE OR A WEBSITE!";
        }
    }else{
        $fieldError = "PLEASE FILL IN ALL FIELDS!";
    }


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <title>upload</title>
</head>
<body>
<div id="navigatie">
    <img src="images/spark_logo.svg" alt="spark_logo">
    <nav>
        <a href="index.php">Home</a>
        <a href="upload.php">Upload</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </nav>
</div>

<div id="container">

    <form action="" method="post" id="submit" enctype="multipart/form-data">
        <h1>Upload</h1>
        <p>Post your inspiration here!</p>
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="Your title here">
        <hr>
        <label for="afbeelding">Upload image or website link</label>
        <input type="file" name="fileToUpload" id="afbeelding" class="image_submit">
        <p style="font-size: 12px;"> Please upload a valid profile picture (Max file size: 500KB, png, jpg, jpeg)</p>
        <p>Or </p>
        <input type="text" id="link" name="link" placeholder="https://www.yourwebsite.com/">

        <hr>
        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="What is it about?"></textarea>
        <button type="submit">Submit</button>
        <p><?php if(isset($imageError)){echo $imageError;} ?></p>
        <p><?php if(isset($fieldError)){echo $fieldError;} ?></p>
        <p><?php if(isset($uploadError_size)){echo $uploadError_size;}?></p>
        <p><?php if(isset($uploadError2)){echo $uploadError2;} ?></p>
        <p><?php if(isset($uploadError_isNotImage)){echo $uploadError_isNotImage;} ?></p>
        <p><?php if(isset($uploadError_type)){echo $uploadError_type;} ?></p>
        <p><?php if(isset($uploadSuccess)){echo $uploadSuccess; echo "<img style='width:50px; height:50px;' src='$target_file'";} ?></p>
        <p><?php if(isset($uploadError)){echo $uploadError;} ?></p>
    </form>

</div>

</body>
</html>