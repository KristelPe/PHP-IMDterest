<?php
    require 'libraries/simple_html_dom.php';
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

    try {
        $userId = $_GET['id'];
        $board = new Board();
        $board->setUserId($userId);
        $res = $board->Boards();
    } catch (Exception $e) {
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
    <title>Make a board</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>

    </style>
</head>
<body>
    <?php include_once("nav.inc.php")?>
    <div id="items" class="item_layout">

        <?php $results = $res;

        foreach ($results as $key => $p) {
            if (!empty($p['link'])) {
                $html = file_get_html($p['link']);
                $pagetitle = $html->find('title', 0);
                $image = $html->find('img', 0);

                echo "<div id='item' class='item'>
                    <h1>" . $p['title'] . "</h1>
                   <a href='" . $p['link'] . "'>" .
                    $pagetitle->plaintext
                    . "</a>
                       <a href='post.php?postid=" . $p['id'] . "'>
                           <div class='post_img'>
                           <img src='
                                " .
                    $image->src
                    . "'
                                alt='
                                " .
                    $pagetitle->plaintext
                    . "'
                           >
                       </div>
                   </a>
                   <div class='like'>
                       <p id='likes'>" . $p['likes']. " likes</p>
                   </div>
                   
                   </div>";
            } elseif (empty($p['link'])) {
                echo "<div id='item' class='item'>
                       <h1>" . $p['title'] . "</h1>
                       <a href='post.php?postid=" . $p['id'] . "'>
                           <div class='post_img'>
                               <img src='" . $p['image'] . "' alt='" . $p['title'] . "'>
                           </div>
                       </a>
                       <div class='like'>
                           <p id='likes'>" . $p['likes']. " likes</p>
                       </div>
                   </div>";
            }
        }
        ?>
    </div>
</body>
</html>

