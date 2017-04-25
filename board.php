<?php
    require 'libraries/simple_html_dom.php';
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }


    $conn = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $conn->prepare("select * from posts where board = :board limit 0,20");
    $statement->bindValue(':board', $_GET['id']);
    $statement->execute();
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

        <?php $results = $statement->fetchAll(PDO::FETCH_ASSOC);

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
                       <button id='like' class='unliked'></button>
                       <p id='likes'></p>
                       <p>likes</p>
                       <input name='id' type='hidden' value='" . $p['id'] . "'>
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
                           <button id='like' class='unliked'></button>
                           <p id='likes'></p>
                           <p>likes</p>
                           <input name='id' type='hidden' value='" . $p['id'] . "'>
                       </div>
                   </div>";
            }
        }
        ?>
        <input type="hidden" id="result_no" value="20">
    </div>
    <button type='submit' name='more' id='more'>Load more</button>

</body>
</html>

