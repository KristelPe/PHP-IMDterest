<?php

    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $connection->prepare("SELECT * FROM users WHERE id = :id");
    $statement->bindValue(':id', $_SESSION['id']);
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    $userid = $_GET['id'];


    if ($_SESSION['id'] == $userid){
        $guest = "hidden";
        $user = "visible";
    } else {
        $guest = "visible";
        $user = "hidden";
    }

    try{
        if (!empty($_POST)) {
            $statement = $connection->prepare("INSERT INTO following (userid, followerid) VALUES (:userid, :followerid)");
            $statement->bindValue(':userid', $_GET['id']);
            $statement->bindValue(':followerid', $_SESSION['id']);
            $statement->execute();
        }
    }catch (Exception $e) {
        $error = $e->getMessage();
    }



?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php foreach ( $users as $u):?>
    <title><?php echo $u["username"]?></title>
    <?php endforeach;?>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        .hidden{
            display: none;
        }

        .visible{
            display: inherit;
        }
        #boards{
            display: flex;
            flex-direction: row;
            margin: 0.5em 1.5em;
        }

        hr{
            margin: 1.5em;
        }
        .board{
            height: 225px;
            width: 300px;
            background-color: lightgray;
            margin: 1.5em;
            padding: 1em;
        }
        .contain{
            height: 165px;
            width: 270px;
            overflow: hidden;
            margin-bottom: 1em;
        }
        .contain img{
            width: inherit;
            margin-top: -38%;
        }

        #add *{
            font-size: 5em;
            width: 40px;
            margin: auto;
            margin-top: 20%;
        }
        #boards a{
            text-decoration: none;
            color: #9397a6;
        }
        .following{
            background-color: orange;
        }
    </style>
</head>
<body>

<?php include_once("nav.inc.php")?>


<a id="update" class="<?php echo $user?>" href="updateProfile.php">UPDATE</a>

<form id="follow" class="<?php echo $guest?>" action="" method="post">
    <input name="follower" type="hidden" value="<?php echo $userid ?>">
    <button type="submit">Follow</button>
</form>

<hr>
<div>
    <h2>Boards</h2>
    <div id="boards">
        <a href="newBoard.php" class="<?php echo $user?>">
            <div id="add" class="board">
                <h3>+</h3>
            </div>
        </a>

        <!-- foreach moet hierkomen -->
        <div class="board">
            <div class="contain">
                <img src="https://s-media-cache-ak0.pinimg.com/originals/23/49/ae/2349ae980ff92275ce9bf9d7ef1539b1.gif" alt="girl">
            </div>
            <h3>SOMETHING</h3>
        </div>
    </div>
</div>

<script src="jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#follow").click(function(){
            $(this).addClass('following');
            $(this).html('FOLLOWING');
        });
</script>
</body>
</html>