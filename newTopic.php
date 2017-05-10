<?php

    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

try{
    $error = "";
    $succes = "";
    if(!empty($_POST))
    {
        $title = htmlspecialchars($_POST['title']);
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    $succes = "File is an image - " . $check["mime"] . ". ";
                    $uploadOk = 1;
                } else {
                    $error = "File is not an image. ";
                    $uploadOk = 0;
                }
            }
            // Check file size
            if ($_FILES["image"]["size"] > 500000) {
                $error = $error . "Sorry, your file is too large. ";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $error = $error . "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $error = $error . "Sorry, your file was not uploaded. ";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        if(!empty($target_file) && !empty($title)) {
            $newT = new topic();
            $newT->setTitle($title);
            $newT->setImg($target_file);
            $newT->newT();
        }else {
            $error = "Please fill in all the fields.";
        }
    }
}
catch(Exception $e) {
    $error = $e->getMessage();
}

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Make a new Topic</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        h2{
            color: darkgrey;
        }
        label{
            color: #9da5b6;
        }
        #new div{
            display: flex;
            flex-direction: row;
            margin: 0.5em 1.5em;
        }
        #new div *{
            margin: auto 0.5em;
        }
        hr{
            margin: 1.5em;
        }
        #new{
            max-width: 600px;
            margin: 2em auto;
            padding: 1em;
        }
        #title{
            width: 500px;
        }
        #buttons{
            justify-content: flex-end;
        }
        form a{
            text-decoration: none;
            background-color: darkgrey;
            border: 0;
            padding: 1em 2.5em;
            margin: 2em 0;
            text-transform: uppercase;
            color: white;
            font-size: 0.75em;
        }

        form a:hover{
            transition: 0.5s all;
            background-color: #919191;
            color: white;
        }
        .alert{
            color: crimson;
        }
    </style>
</head>
<body>
<?php include_once("nav.inc.php")?>

<form id="new" action="" method="post" enctype="multipart/form-data">
    <?php echo "<h3 class='alert'>".$error. $succes ."</h3></br>" ?>

    <h2>Make a new topic</h2>

    <div>
        <label for="title">Name</label>
        <input id="title" type="text" name="title">
    </div>
    <hr>
    <div>
        <label for="image">Image</label>
        <input type="file" name="image" id="image">
    </div>
    <div id="buttons">
        <a href="javascript:history.go(-1)">CANCEL</a>
        <button type="submit">Make</button>
    </div>
</form>
</body>
</html>