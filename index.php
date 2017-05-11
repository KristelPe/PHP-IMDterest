<?php
    require 'libraries/simple_html_dom.php';
    //check if session exists
    //if not send back to login
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

    $email = $_SESSION['user'];

    //find userid associated with the email address
    $update = new User();
    $update->setSessionUser($email);
    $userid = $update->userId();


    $noP = 0;
    settype($noP, "integer");

    try {
        $stack = new Stack();
        if (isset($_POST['search'])) {
            $searchq = $_POST['search'];
            $stack->setSearch($searchq);
            $res = $stack->Search($noP);
        } else {
            $sessionId = $_SESSION['id'];
            $stack->setSessionId($sessionId);
            $res = $stack->Stacker($noP);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }



    $i = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDterest</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/search.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        img{
            width: 230px;
        }
        button{
            cursor: pointer;
        }
        p{
            margin-top: 0.5em;
            color: #9da5b6;
            margin-right: 5px;
        }
        .like p, .user p{
            color: #b4b4b4;
            font-size: small;
        }
        .like button{
            margin: 0;
            margin-right: 1em;
            width: 30px;
            height: 30px;
            padding:0;
            background-position: center;
            background-size: 20px;
            background-repeat: no-repeat;
            background-color: white;
            border-radius: 5px;
        }
        .item{
            max-height: 500px;
        }
    </style>
</head>
<body>

<?php include_once("nav.inc.php")?>

<div id="search_bar_style">
    <form action="index.php" method="post" id="search_bar">
        <input type="text" name="search" id="search" placeholder="Search..." />
        <button type="submit" id="search_bar_button"></button>
    </form>
</div>

<div id="container">
    <div id="items" class="item_layout">

        <?php $results = $res;

        foreach ($results as $key => $p) {
            if (!empty($p['link'])) {
                $scraper = new Scraper();
                $scraper->SetLink($p['link']);
                $pagetitle = $scraper->ScrapeTitle();
                $image = $scraper->ScrapeImg();

                echo "<div id='item' class='item'>
                   <div class='user_post_info'>
                        <img src=" . $p["userImage"] . " alt=" . $p["username"] . " class='user_img_post'>
                        <h1>" . $p['title'] . "</h1>
                   </div>
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
                   <div class='like'>
                       <button id='like' class='" . $stack->Liked($p['id']) . "'></button>
                       <p id='likes'>" . $p['likes']. " likes</p>
                   </div>
                   
                   </div>";
            } elseif (empty($p['link'])) {
                echo "<div id='item' class='item'>
                       <div class='user_post_info'>
                           <img src=" . $p["userImage"] . " alt=" . $p["username"] . " class='user_img_post'>
                           <h1>" . $p['title'] . "</h1>
                       </div>
                       <a href='post.php?postid=" . $p['id'] . "'>
                           <div class='post_img'>
                               <img src='" . $p['image'] . "' alt='" . $p['title'] . "'>
                           </div>
                       </a>
                       <div class='like'>
                           <button id='like' class='" . $stack->Liked($p['id']) . "' name='" . $p['id'] . "'></button>
                           <p id='likes'>" . $p['likes']. " likes</p>
                       </div>
                   </div>";
            }
        }
        ?>
        <input type="hidden" id="result_no" value="20">
    </div>
    <button type='submit' name='more' id='more'>Load more</button>
</div>

<script src="jquery.min.js"></script>
<script src="js/loadmore.js"></script>
<script src="js/like.js"></script>

</body>
</html>
