<?php

    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

    try{
        //PROFILE
        $userid = $_GET['id'];

        $profile = new Profile();
        $profile->setUserId($userid);
        $use = $profile->Profile();

        if ($_SESSION['id'] == $userid) {
            $guest = "hidden";
            $user = "visible";
        } else {
            $guest = "visible";
            $user = "hidden";
        }

        //FOLLOW
        $state = $profile->Follow();

        //BOARDS
        $board = new Profile();
        $board->setUserId($userid);
        $boards = $board->Boards();

        //POSTS
        $posts = new Profile();
        $posts->setUserId($userid);
        $posts = $posts->Posts();

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
    <?php foreach ($use as $u):?>
    <title><?php echo $u["username"]?></title>
    <?php endforeach;?>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>

<?php include_once("nav.inc.php")?>

<div id="container">

    <div id="user">
        <?php foreach ($use as $u): ?>
            <h2><?php echo $u['username']?></h2>
            <div class="user_layout">
                <img src="<?php echo $u['image']?>" alt="<?php echo $u['username']?>">
                <div class="info_layout">
                    <div class="info">
                        <h3>Firstname: <span class="grayText"><?php echo $u['firstname']?></span></h3>
                    </div>
                    <div class="info">
                        <h3>Lastname: <span class="grayText"><?php echo $u['lastname']?></span></h3>
                    </div>
                    <div class="info">
                        <h3>Email: <span class="grayText"><?php echo $u['email']?></span></h3>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>

    <a id="update" class="<?php echo $user?>" href="updateProfile.php">UPDATE</a>

    <form id="follow" class="<?php echo $guest?>" action="" method="post">
        <input name="follower" type="hidden" value="<?php echo $userid ?>">
        <button class="<?php echo $state?>" type="submit"><?php echo $state?></button>
    </form>

    <hr>
    <div>
        <h2>Boards</h2>
        <div id="boards">
            <a href="newBoard.php" class="<?php echo $user?>">
                <div id="add" class="board <?php echo $user?>">
                    <h3>+</h3>
                </div>
            </a>

            <?php foreach ($boards as $b):
                if ($b['state'] == "private" && $b['userid'] == $_SESSION['id']) {
                    $board_state = "public";
                } else {
                    $board_state = $b['state'];
                }
                ?>
                <a href="board.php?id=<?php echo $b['id'];?>">
                    <div class="board <?php echo $board_state ?>">
                        <div class="contain">
                            <img src="http://lorempixel.com/400/300" alt="random"> <!-- MOET LATER NOG VERNADERD WORDEN -->
                        </div>
                        <h3><?php echo $b['title']?></h3>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <hr>
    <div>
        <h2>Uploads</h2>
        <div id="boards">

            <?php foreach ($posts as $p):?>
                <div id='item' class='item'>
                    <a href="post.php?postid=<?php echo $p['id'];?>">
                        <h1><?php echo $p['title']?></h1>
                        <div class="post_img">
                            <img src="<?php echo $p['image'] ?>" alt="<?php echo $p['title'] ?>"> <!-- MOET LATER NOG VERNADERD WORDEN -->
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>