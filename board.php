<?php
use spark\Profile;
use spark\Scraper;

require 'libraries/simple_html_dom.php';
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . str_replace('\\', '/', $class) . ".class.php");
    });

    try {
        $userId = $_GET['id'];
        $board = new Profile();
        $board->setUserId($userId);
        $res = $board->BoardPosts();
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php include_once("nav.inc.php")?>
    <div id="items" class="item_layout">

        <?php $results = $res;

        foreach ($results as $key => $p) {
            if (!empty($p['link'])) {
                $scraper = new Scraper();
                $scraper->SetLink($p['link']);
                $pagetitle = $scraper->ScrapeTitle();
                $image = $scraper->ScrapeImg();

                echo "<div id='item' class='item'>
                        <h1>" . $p['title'] . "</h1>
                       <a href='" . $p['link'] . "'>" .
                    $pagetitle
                    . "</a>
                           <a href='post.php?postid=" . $p['id'] . "'>
                               <div class='post_img'>
                               <img src='
                                    " .
                    $image
                    . "'
                                    alt='
                                    " .
                    $pagetitle
                    . "'
                               >
                           </div>
                       </a>                       
                       </div>";
            } elseif (empty($p['link'])) {
                echo "<div id='item' class='item'>
                           <h1>" . $p['title'] . "</h1>
                           <a href='post.php?postid=" . $p['id'] . "'>
                               <div class='post_img'>
                                   <img src='" . $p['image'] . "' alt='" . $p['title'] . "'>
                               </div>
                           </a>
                       </div>";
            }
        }
        ?>
    </div>
</body>
</html>

