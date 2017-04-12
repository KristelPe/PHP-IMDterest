<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    spl_autoload_register(function($class){
        include_once("classes/" . $class . ".class.php" );
    });

    $upload_message = "";

    $email = $_SESSION['user'];

    //find userid associated with the email address
    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $connection->prepare("SELECT id FROM users WHERE email = :email");
    $statement->bindvalue(":email", $email);
    $res = $statement->execute();
    $userid = $statement->fetchColumn();


    if(!empty($_POST)){
        try{
                $title = $_POST["title"];
                $description = $_POST["description"];
                $afbeelding = $_POST["afbeelding"];

                if (move_uploaded_file($_FILES["afbeelding"]["tmp_name"], $afbeelding)) {
                    $upload_message = "The file ". basename($_FILES["afbeelding"]["name"]). " has been uploaded.";
                } else {
                    $upload_message = "Sorry, there was an error uploading your file.";
                }

                $post = new Post();
                $post->setMTitle($title);
                $post->setMAfbeelding($afbeelding);
                $post->setMDescription($description);
                $post->setMUserId($userid);
                $post->Upload();
        }
        catch(Exception $e) {
            $error = $e->getMessage();
            die($error);
        }
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
<nav>
    <a href="index.php">Home</a>
    <a href="upload.php">Upload</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</nav>

<div id="container">

<form action="" method="post" id="submit" enctype="multipart/form-data">
    <h1>Upload</h1>
    <p>Post your inspiration here!</p>
    <label for="title">title</label>
    <input type="text" id="title" name="title" placeholder="Your title here">
    <label for="afbeelding">afbeelding</label>
    <input type="file" id="afbeelding" name="afbeelding">
    <label for="description">description</label>
    <textarea id="description" name="description" placeholder="What is it about?"></textarea>
    <p><?php echo $upload_message ?></p>
    <button type="submit">Submit</button>
</form>

</div>

</body>
</html>