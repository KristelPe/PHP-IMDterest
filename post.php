<?php
session_start();
if(!isset($_SESSION['user'])){
    header('location: login.php');
}

$postid = $_GET['postid'];

try{
    $conn = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $select = $conn->prepare("select p.*, u.username as username, u.image as img from posts p inner join users u where u.id = p.userid");
    $res = $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
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
    <style>
        h1{
            margin-top:2em;
            color: #9da5b6;
        }

        h2{
            color: #b4b4b4;
        }
        .user{
            display: flex;
            flex-direction: row;
            line-height: 4em;
        }
        .user_img{
            height: 50px;
            width: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0.5em 1em;
        }
        .user_img img{
            width: inherit;
        }
    </style>
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
        <?php foreach ($results as $p):
        if($p['id'] == $postid): ?>
        <img src="<?php echo $p['image']?>" alt="<?php echo $p['title']?>">
        <div>
            <h1><?php echo $p['title']?></h1>
            <div class="user">
                <div class="user_img">
                    <img src="<?php echo $p['img']?>" alt="<?php echo $p['username']?>">
                </div>
                <h2><?php echo $p['username']?></h2>
            </div>
            <p><?php echo $p['description']?></p>
        </div>
        <?php endif; endforeach; ?>
    </div>
</div>
</body>
</html>