<?php
use spark\Scraper;
use spark\Stack;
use spark\User;

require 'libraries/simple_html_dom.php';
    //check if session exists
    //if not send back to login
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . str_replace('\\', '/', $class) . ".class.php");
    });

    $email = $_SESSION['user'];

    //find userid associated with the email address
    $update = new User();
    $update->setSessionUser($email);
    $userid = $update->userId();


    $noP = 0;
    settype($noP, "integer");

    try {
        $searchq = "";
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
</head>
<body>

<?php include_once("nav.inc.php")?>

<div id="search_bar_style">
    <form action="index.php" method="post" id="search_bar">
        <input type="text" name="search" id="search" placeholder="Search..." />
        <button type="submit" id="search_bar_button"></button>
    </form>
</div>
<input type="hidden" id="searchq" value="<?php echo htmlspecialchars($searchq)?>">
<div id="container">
    <div id="items" class="item_layout">

        <?php $results = $res; foreach ($results as $key => $p): ?>
            <?php if(!empty(htmlspecialchars($p['link']))): {$scraper = new Scraper();$scraper->SetLink(htmlspecialchars($p['link']));$pagetitle = $scraper->ScrapeTitle();$image = $scraper->ScrapeImg();}; ?>
                <div id='item' class='item'>
                    <div class='user_post_info'>
                        <img src="<?php echo htmlspecialchars($p["userImage"])?>" alt="<?php echo htmlspecialchars($p["username"])?>" class='user_img_post'>
                        <h1><?php echo htmlspecialchars($p['title'])?></h1>
                    </div>

                    <a href='post.php?postid=<?php echo htmlspecialchars($p['id'])?>'>
                        <div class='post_img'>
                            <img src='<?php echo htmlspecialchars($image) ?>' alt='<?php echo htmlspecialchars($pagetitle)?>'>
                        </div>
                    </a>
                    <div class='like'>
                        <button id='like' class='<?php echo htmlspecialchars($stack->Liked(htmlspecialchars($p['id'])))?>' style='<?php echo $stack->Liked($p['id'])?>' name='<?php echo htmlspecialchars($p['id'])?>' style='background-image: url(<?php if(htmlspecialchars($p['likes']) <= 0 ){ echo "images/wood_1.gif";}if(htmlspecialchars($p['likes']) > 0 && htmlspecialchars($p['likes']) < 10 ){ echo "images/wood_2.gif";}if(htmlspecialchars($p['likes']) >= 10 && htmlspecialchars($p['likes']) < 49 ){ echo "images/wood_3.gif";}if(htmlspecialchars($p['likes']) >= 50 ){ echo "images/wood_4.gif";} ?>);'></button>
                        <p id='likes'><?php echo htmlspecialchars($p['likes'])?> likes</p>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(empty(htmlspecialchars($p['link']))): ?>
                <div id='item' class='item'>
                    <div class='user_post_info'>
                        <img src="<?php echo htmlspecialchars($p["userImage"])?>" alt="<?php echo htmlspecialchars($p["username"])?>" class='user_img_post'>
                        <h1><?php echo htmlspecialchars($p['title'])?></h1>
                    </div>
                    <a href='post.php?postid=<?php echo htmlspecialchars($p['id'])?>'>
                        <div class='post_img'>
                            <img src='<?php echo htmlspecialchars($p['image'])?>' alt='<?php echo htmlspecialchars($p['title'])?>'>
                        </div>
                    </a>
                    <div class='like'>
                        <button id='like' class='<?php echo $stack->Liked(htmlspecialchars($p['id']))?>' name='<?php echo htmlspecialchars($p['id'])?>' style='background-image: url(<?php if(htmlspecialchars($p['likes']) <= 0 ){ echo "images/wood_1.gif";}if(htmlspecialchars($p['likes']) > 0 && htmlspecialchars($p['likes']) < 10 ){ echo "images/wood_2.gif";}if(htmlspecialchars($p['likes']) >= 10 && htmlspecialchars($p['likes']) < 49 ){ echo "images/wood_3.gif";}if(htmlspecialchars($p['likes']) >= 50 ){ echo "images/wood_4.gif";} ?>);'></button>
                        <p id='likes'><?php echo htmlspecialchars($p['likes'])?> likes</p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach ?>

        <input type="hidden" id="result_no" value="20">
    </div>
    <button type='submit' name='more' id='more'>Load more</button>
</div>

<script src="jquery.min.js"></script>
<script src="js/loadmore.js"></script>
<script src="js/like.js"></script>

</body>
</html>
