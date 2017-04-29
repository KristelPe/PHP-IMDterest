<?php

    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

    try {
        $conn = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
        $sql = "select * from topics";
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    $email = $_SESSION['user'];

    //find userid associated with the email address
    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $connection->prepare("SELECT id FROM users WHERE email = :email");
    $statement->bindvalue(":email", $email);
    $res = $statement->execute();
    $userid = $statement->fetchColumn();

    $topic = "";
    if (empty($_POST['topic'])) {
        $topics = "You didn't select any topics.";
    } else {
        $topic = $_POST['topic'];
        $N = count($topic);

            $topics = "You selected $N topics";
            for ($i=0; $i < $N; $i++) {
                $selectedTopic = new Post();
                $selectedTopic->setMUserId($userid);
                $selectedTopic->setTopic($topic[$i]);
                $selectedTopic->AddTopic();
        }
    }

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Topics</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
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
    <form id="topics" action="" method="post">
        <h1>Like 5 topics</h1>
        <h2>Then we'll build a custom home feed for you</h2>
        <p>step 1 of 1</p>
        <input name="search" id="search" placeholder="Search for any topics" type="search">
        <div class="topics">
        <?php foreach ($conn->query($sql) as $t):?>
                <div class="topic" style="background-image: url(<?php echo $t['img']?>)">
                    <input id="topic" class="checkbox" name="topic[]" value="<?php echo $t['id']?>" type="checkbox">
                    <p id="<?php echo $t['id']?>" ><?php echo $t['title']?></p>
                </div>
        <?php endforeach;?>
        </div>
        <button id="submit" type="submit"><?php echo $topics?></button>
    </form>
    <script src="jquery.min.js"></script>
    <script type="text/javascript">
        $('input').click(function(){
            if($(this).is(":checked")) {
                $(this).next().addClass("selected");
            } else{
                $(this).next().removeClass("selected");
            }
        });
        //$('p').css("background-color", "rgba(1,1,1, 0.5)");
    </script>
</body>
</html>