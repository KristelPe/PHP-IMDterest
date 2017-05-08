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
        .post_img{
            width: 230px;
            border-radius: 5px;
            max-height: 200px;
            overflow: hidden;
        }
        img{
            width: 230px;
        }
        button{
            cursor: pointer;
        }
        .like{
            display: flex;
            flex-direction: row;
            margin-top: 1em;
            line-height: 1em;
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
                   <div class='like'>
                       <button id='like' class='" . $stack->Liked($p['id']) . "'></button>
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
                if (response == "empty"){
                    $("#more").text("There are no more posts")
                } else {
                    var content = document.getElementById("items");
                    content.innerHTML = content.innerHTML + response;
                    // LIMIT + 20
                    document.getElementById("result_no").value = Number(val) + 20;
                }
            }
        });
    }

    function like(button) {
        var postId = button.attr("name"); //DUUUUS Dees geeft ni de correcte waarde terug en k weet ni wa k hier nog zou kunnen proberen (￣□￣)
        var likes = button.next();
        var count;

        if (button.hasClass('unliked')) {
            count = 'plus';
        } else {
            count = 'minus';
        }

        $.ajax({
            type: 'post',
            url: 'ajax/like.php',
            data: {postId: postId, count: count},
            success: function (response) {
                if (button.hasClass('unliked')) {
                    button.removeClass('unliked').addClass('liked');
                    likes.text(response+' likes');
                } else {
                    button.removeClass('liked').addClass('unliked');
                    likes.text(response+' likes');
                }

            }
        });
    }

</script>
</body>
</html>
