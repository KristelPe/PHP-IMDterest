<?php

    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
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
    <style>
        body{
            text-align: center;
        }

        .topic p{
            text-align: left;
            color: white;
            text-shadow: 0px 0px 3px rgba(75,124,134, 0.7);
        }
        .topic{
            box-shadow: 0px 0px 10px rgba(75,124,134, 0.3);
        }
        .topics{
            max-height: 70vh;
            width: 100%;
            overflow: scroll;
            justify-content: space-around;
            padding: 1em 0.5em;
            box-shadow: inset 0 0 10px rgba(75,124,134, 0.3);
        }
        .center{
            margin:2em;
            display: flex;
            flex-direction: column;
        }
        .float{
            float: right;
            background-color: #3a646f;
            color: white;
            width: 2.5em;
            height: 2.5em;
            margin-top: -0.95em;
            margin-right: -0.4em;
            line-height: 2.6em;
        }
        #searchDiv{
            display: flex;
            flex-direction: row;
            margin: 1em auto 0em auto;
        }
        #search{
            width: 80%;
            height: 3.3em;
        }
        #search_bar_button{
            width: 20%;
            height: 3.3em;
            margin-top: 0;
        }
        #submit{
            margin-top: 2.5em;
        }

        .new{
            width: 175px;
            height: 175px;
            background-color: whitesmoke;
            margin: auto;
        }

        .new p{
            font-size: 4em;
            line-height: 2.15em;
            margin-left: 0.9em;
        }
        .link{
            text-decoration: none;
            width: 175px;
            height: 175px;
            margin: 0.5em;
        }
    </style>
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
                            <input id="topic" class="checkbox" name="topics[]" value="<?php echo $t['id']?>" type="checkbox">
                            <p id="<?php echo $t['id']?>" ><?php echo $t['title']?></p>
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
    <script src="jquery.min.js"></script>
    <script type="text/javascript">

        $('input.checkbox').click(function(){
            var $checker = $('input[type=checkbox]');
            if ($checker.filter(':checked').length > 5){
                this.checked = false;
                if(this.checked = true) {
                    this.checked = false;
                    $(this).next().removeClass("selected");
                }
            } else{
                if($(this).is(':checked')) {
                    $(this).next().addClass("selected");
                } else{
                    $(this).next().removeClass("selected");
                }
            }

            var diff = 5 - $checker.filter(':checked').length;
            var posts;
            if (diff == 1){
                posts = " post";
            } else {
                posts = " posts";
            }

            if(diff == 0 ){
                $('h1').text('Great!');
                $('h2').text("Let's set up your homefeed");
            } else {
                $('h1').text('Like '+ diff + " more" +  posts);
            }

            document.getElementById('count').value = $checker.filter(':checked').length;
        });
    </script>
</body>
</html>