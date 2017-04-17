<?php
    require 'libraries/simple_html_dom.php';
    //check if session exists
    //if not send back to login
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    try{
        $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

        if(isset($_POST['search'])) {
            $searchq = $_POST['search'];
            $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

            $statement = $connection->prepare("SELECT * FROM posts WHERE title LIKE :keywords OR description LIKE :keywords limit 0,20");
            $statement->bindValue(':keywords', '%' . $searchq . '%');
            $statement->execute();
            /*while ($r = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<pre>" . print_r($r, true) . "</pre>";
            }*/
        } else {
            $statement = $connection->prepare("select * from posts order by id DESC limit 0,20");
            $statement->execute();
        }

    }catch(Exception $e) {
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
        .post_img{
            width: 230px;
            border-radius: 5px;
            max-height: 200px;
            overflow: hidden;
        }
        img{
            width: 230px;
        }
        .like{
            display: flex;
            flex-direction: row;
            margin-top: 1em;
        }
        p{
            margin-top: 0.5em;
            color: #9da5b6;
        }
        .like{
            line-height: 1em;
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
        .liked{
            background-image: url("http://www.clker.com/cliparts/o/4/f/P/U/b/red-heart-hi.png");
        }
        .unliked{
            background-image: url("http://www.clker.com/cliparts/d/v/C/j/y/1/grey-heart-hi.png");
        }
        .item{
            max-height: 500px;
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

<div id="search_bar_style">
    <form action="index.php" method="post" id="search_bar">
        <input type="text" name="search" id="search" placeholder="Search..." />
        <button type="submit" id="search_bar_button"></button>
    </form>
</div>

<div id="container">

    <div id="items" class="item_layout">

        <?php $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach( $results as $key => $p ){
            if(!empty($p['link'])){
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
                        <p id='likes'>" . $p['likes'] . "</p>
                        <p>likes</p>
                        <input type='hidden' value='" . $p['id'] . "'>
                   </div>
                   
                   </div>";
            } elseif(empty($p['link'])) {
                echo "<div id='item' class='item'>
                       <h1>" . $p['title'] . "</h1>
                       <a href='post.php?postid=" . $p['id'] . "'>
                           <div class='post_img'>
                               <img src='" . $p['image'] . "' alt='" . $p['title'] . "'>
                           </div>
                       </a>
                       <div class='like'>
                           <button id='like' class='unliked'></button>
                           <p id='likes'>" . $p['likes'] . "</p>
                           <p>likes</p>
                           <input type='hidden' value='" . $p['id'] . "'>
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#more").click(function(){
            loadmore();
        });

        $('.like').find('button').click(function(){
            var button = $(this);
            like(button);
        });
    });

    function loadmore() {
        var val = document.getElementById("result_no").value;
        $.ajax({
            type: 'post',
            url: 'ajax/loadMore.php',
            data: {     getresult:val   },
            success: function (response) {
                var content = document.getElementById("items");
                content.innerHTML = content.innerHTML+response;
                // LIMIT + 20
                document.getElementById("result_no").value = Number(val)+20;
            }
        });
    }

    function like(button){
        var likes = button.next();
        var like = button.parent();
        var id = parseInt(like.find('input').value);

        var count;
        if (button.hasClass('unliked')){
            count = '+';
        } else {
            count = '-';
        }

        $.ajax({
            type: 'post',
            url: 'ajax/like.php',
            data: { count: count, id: id  },
            success: function (response) {
                if (button.hasClass('unliked')){
                    button.removeClass('unliked').addClass('liked');
                    likes.html(response);
                } else {
                    button.removeClass('liked').addClass('unliked');
                    likes.html(response);
                }

            }
        });

    }
</script>
</body>
</html>