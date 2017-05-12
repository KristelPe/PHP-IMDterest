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
        $boards = $profile->Boards();

        //POSTS
        $posts = $profile->Posts();

        $followers = $profile->CountFollowers();
        
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
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        .pop{
            max-height: 50vh;
            overflow: scroll;
            background-color: rgba(75,124,134, 0.1);
            box-shadow: inset 0 0 10px rgba(75,124,134, 0.3);
        }

        #listF{
            display: flex;
            flex-direction: row;
            padding:1em;
            margin: auto;
            flex-wrap: wrap;
        }

        #listF div{
            margin:0.75em;
            line-height: 3.5em;
            height: 60px;
            width: 250px;
        }

        #listF img{
            height: 60px;
            width: 60px;
            border-radius: 50%;
            margin-right: 1em;
        }

        #popover{
            background-color: white;
            max-width: 60vw;
            padding: 2em;
            margin: auto;
            margin-top: 20vh;
            padding-bottom: 5.5em;
        }

        #popover a{
            color: #74787d;
            text-decoration: none;
            display: flex;
            flex-direction: row;
        }

        #popover button{
            float: right;
        }

        .bg{
            background-color: rgba(58, 100, 111, 0.8);
            width: 100vw;
            height: 120vh;
            position: fixed;
            margin-top: -60vh;
        }
    </style>
</head>
<body>

<?php include_once("nav.inc.php")?>



<div id="container">

    <div id="user">
        <?php foreach ($use as $u): ?>
            <h2><?php echo htmlspecialchars($u['username'])?></h2>
            <div class="user_layout">
                <img src="<?php echo htmlspecialchars($u['image'])?>" alt="<?php echo htmlspecialchars($u['username'])?>">
                <div class="info_layout">
                    <div class="info">
                        <h3>Firstname: <span class="grayText"><?php echo htmlspecialchars($u['firstname'])?></span></h3>
                    </div>
                    <div class="info">
                        <h3>Lastname: <span class="grayText"><?php echo htmlspecialchars($u['lastname'])?></span></h3>
                    </div>
                    <div class="info">
                        <h3>Email: <span class="grayText"><?php echo htmlspecialchars($u['email'])?></span></h3>
                    </div>
                    <button id="followers"><?php echo $followers['followers'] . " followers";?></button>
                </div>
            </div>
        <?php endforeach;?>
    </div>

    <?php if($_SESSION['id'] == $userid): ?>
        <a id="update" class="<?php echo htmlspecialchars($user)?>" href="updateProfile.php">UPDATE</a>
    <?php endif; ?>

    <form id="follow" class="<?php echo htmlspecialchars($guest)?>" action="" method="post">
        <input name="follower" type="hidden" value="<?php echo htmlspecialchars($userid) ?>">
        <button class="<?php echo htmlspecialchars($state)?>" type="submit"><?php echo htmlspecialchars($state)?></button>
    </form>

    <hr>
    <div>
        <h2>Boards</h2>
        <div id="boards">
            <?php if($_SESSION['id'] == $userid): ?>
            <a href="newBoard.php" class="<?php echo htmlspecialchars($user)?>">
                <div id="add" class="board <?php echo htmlspecialchars($user)?>">
                    <h3>+</h3>
                </div>
            </a>
            <?php endif; ?>
            <?php foreach ($boards as $b):
                if ($b['state'] == "private" && $b['userid'] == $_SESSION['id']) {
                    $board_state = "public";
                } else {
                    $board_state = $b['state'];
                }
                ?>
                <div class=<?php echo htmlspecialchars($b['id']);?>>
                    <a href="board.php?id=<?php echo htmlspecialchars($b['id']);?>">
                        <div class="board <?php echo htmlspecialchars($board_state) ?>">
                            <div class="contain">
                                <img src="<?php echo htmlspecialchars($b['image']);?>" alt="random"> <!-- MOET LATER NOG VERNADERD WORDEN -->
                            </div>
                            <h3><?php echo htmlspecialchars($b['title'])?></h3>
                        </div>
                    </a>
                    <button class='removeBoards'>Remove Board</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <hr>
    <div>
        <h2>Uploads</h2>
        <div id="boards">

            <?php foreach ($posts as $p):?>
                <div id='item' class='item'>
                    <a href="post.php?postid=<?php echo htmlspecialchars($p['id']);?>">
                        <h1><?php echo htmlspecialchars($p['title'])?></h1>
                        <div class="post_img">
                            <img src="<?php echo htmlspecialchars($p['image']) ?>" alt="<?php echo htmlspecialchars($p['title']) ?>"> <!-- MOET LATER NOG VERNADERD WORDEN -->
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div id="bg" class="bg">
    <div id="popover">
        <h2>Followers</h2>
        <div class="pop">
            <div id="listF"></div>
        </div>
        <button id="close">CLOSE</button>
    </div>
</div>

<script src="jquery.min.js"></script>
<script src="js/followers.js"></script>
<script src="js/removeBoard.js"></script>
</body>
</html>