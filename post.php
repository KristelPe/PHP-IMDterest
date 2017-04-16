<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location: login.php');
}

$postid = $_GET['postid'];

try{
    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');


}catch(Exception $e) {
    echo $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/post.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
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
    <div id="post_layout">
        <img src="<?php echo $p[$postid]['image']?>" alt="<?php echo $p['title']?>">
        <div>
            <h1><?php echo $p[$postid]['title']?></h1>
            <h2>Publisher</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis volutpat, nisl tristique gravida euismod, elit ipsum pulvinar urna, a congue quam sapien at mi. Suspendisse tortor arcu, cursus sed nisi ut, commodo consequat felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent eget iaculis neque, a semper diam. Donec turpis purus, elementum dignissim odio vitae, pharetra vulputate felis. Suspendisse potenti. Phasellus pellentesque hendrerit malesuada. Proin interdum in tortor ut laoreet. Morbi at rutrum justo. Donec arcu lacus, facilisis suscipit mi non, vulputate vehicula nunc. Phasellus ullamcorper, ex commodo tristique consectetur, mi tortor porta ex, sed sodales purus ex sit amet nisi. Pellentesque id ligula consectetur, vestibulum nunc non, sagittis ex. Vivamus aliquet vulputate libero, eget euismod libero sodales a.

            </p>
        </div>
    </div>
</div>
</body>
</html>