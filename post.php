<?php
require 'libraries/simple_html_dom.php';
session_start();
if(!isset($_SESSION['user'])){
    header('location: login.php');
}

spl_autoload_register(function($class){
    include_once("classes/" . $class . ".class.php" );
});

$postid = $_GET['postid'];

if(!empty($_POST["comment"])){
    try{
        $text = $_POST["comment_text"];

        $comment = new Comment();
        $comment->setMComment($text);
        $comment->setMPostId($postid);
        $comment->setMUserId($userid);
        $comment->Upload();

    }catch(Exception $e) {
        echo $e->getMessage();
    }
}

try{
    $conn = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $select = $conn->prepare("select p.*, u.username as username, u.image as img from posts p inner join users u where u.id = p.userid");
    $res = $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
}catch(Exception $e) {
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
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/post.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        h1{
            margin-top:2em;
            color: #9da5b6;
        }

        h2{
            color: #b4b4b4;
        }
        .user{
            display: flex;
            flex-direction: row;
            line-height: 4em;
        }
        .user_img{
            height: 50px;
            width: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0.5em 1em;
        }
        .user_img img{
            width: inherit;
        }
    </style>
</head>
<body>

<?php include_once("nav.inc.php")?>

<div id="container">
    <div id="post_layout">
        <?php foreach ($results as $p): ?>

            <?php if($p['id'] == $postid && empty($p['link'])): ?>
                <img src="<?php echo $p['image']?>" alt="<?php echo $p['title']?>">
                <div id="post_layout_info">
                    <h1><?php echo $p['title']?></h1>
                    <div class="user">
                        <div class="user_img">
                            <img src="<?php echo $p['img']?>" alt="<?php echo $p['username']?>">
                        </div>
                        <h2><?php echo $p['username']?></h2>
                    </div>
                    <p><?php echo $p['description']?></p>
                </div>

            <?php elseif($p['id'] == $postid && !empty($p['link'])): ?>
                <?php
                $html = file_get_html($p['link']);
                $pagetitle = $html->find('title', 0);
                $image = $html->find('img', 0);
                ?>
                <a style="text-decoration: none;" href="<?php echo $p['link'] ?>">
                    <h1><?php echo $pagetitle->plaintext ?></h1>
                    <img src='<?php echo $image->src ?>' alt='<?php echo $pagetitle->plaintext ?>'>
                </a>
                <div id="post_layout_info">
                    <h1><?php echo $p['title']?></h1>
                    <div class="user">
                        <div class="user_img">
                            <img src="<?php echo $p['img']?>" alt="<?php echo $p['username']?>">
                        </div>
                        <h2><?php echo $p['username']?></h2>
                    </div>
                    <p><?php echo $p['description']?></p>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>

    </div>

    <div id="comment_layout">
        <form action="" method="post" id="submit" enctype="multipart/form-data">
            <label for="text_comment">Comment</label>
            <textarea id="text_comment" name="text_comment" placeholder="..."></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>
</body>
</html>