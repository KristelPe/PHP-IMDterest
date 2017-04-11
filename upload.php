<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    spl_autoload_register(function($class){
        include_once("classes/" . $class . ".class.php" );
    });

    try{
        if(!empty ($_POST)){
            $title = $_POST["title"];
            $afbeelding = $_POST["afbeelding"];
            $description = $_POST["description"];

            $post = new Post();
            $post->setMTitle($title);
            $post->setMAfbeelding($afbeelding);
            $post->setMDescription($description);
            $post->Upload();
        }
    }
    catch(Exception $e) {
        $error = $e->getMessage();
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

<form action="" method="post" id="submit">
    <h1>Upload</h1>
    <p>Post your inspiration here!</p>
    <label for="title">title</label>
    <input type="text" id="title" placeholder="Your title here">
    <label for="afbeelding">afbeelding</label>
    <input type="file" id="afbeelding">
    <label for="description">description</label>
    <textarea id="description" placeholder="What is it about?"></textarea>
    <button type="submit">Submit</button>
</form>

</div>

</body>
</html>