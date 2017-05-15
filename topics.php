<?php

use spark\topic;session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . str_replace('\\', '/', $class) . ".class.php");
    });

    try {

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    try {
        $topic = new topic();

        $email = $_SESSION['user'];

        $topic->setEmail($email);
        $userid = $topic->SearchUser();
        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $topic->setSearch($search);
            $all = $topic->Search();
        } else{
            $all = $topic->Topics();
            if (!empty($_POST)) {
                $count = $_POST['count'];
                if ($count == 5) {
                    if(!empty($_POST['topics'])){
                        foreach($_POST['topics'] as $selected){
                            $topic->setTopicId($selected);
                            $topic->SaveTopic();
                        }
                    }
                } else {
                    $message = "Choose " . $count . " more";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        }
    } catch (Exception $e) {
        echo $e->getMessage();
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
    <?php include_once("nav.inc.php")?>
    <div id="container">
        <form id="topics" action="" method="post">
            <p class="float">1/1</p>
            <div class="center">
                <h1 id="title">Like 5 topics</h1>
                <h2 id="sub">And we'll build a custom home feed for you</h2>
                <div id="searchDiv">
                    <form action="index.php" method="post" id="search_bar">
                        <input type="text" name="search" id="search" placeholder="Search..." />
                        <button type="submit" id="search_bar_button">Search</button>
                    </form>
                </div>
                <div class="topics">
                <?php foreach ($all as $t):?>
                        <div class="topic" style="background-image: url(<?php echo $t['img']?>)">
                            <input id="topic" class="checkbox" name="topics[]" value="<?php echo htmlspecialchars($t['id'])?>" type="checkbox">
                            <p id="<?php echo htmlspecialchars($t['id'])?>" ><?php echo htmlspecialchars($t['title'])?></p>
                        </div>
                <?php endforeach;?>
                    <a class="link" href="newTopic.php">
                        <div class="topic new">
                            <p>+</p>
                        </div>
                    </a>
                </div>
                <input id="count" name="count" value="0" type="text" style="visibility: hidden"/>
                <button id="submit" type="submit">SUBMIT</button>
            </div>
        </form>
    </div>
</body>
</html>

<script src="jquery.min.js"></script>
<script src="js/topics.js"></script>