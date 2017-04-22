<?php

    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    if (!empty($_POST)) {
        $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
        $statement = $connection->prepare("INSERT INTO boards (userid, title, state) VALUES (:userid, :title, :state)");
        $statement->bindValue(':userid', $_SESSION['id']);
        $statement->bindValue(':title', $_POST['title']);
        $statement->bindValue(':state', $_POST['case']);
        $statement->execute();
        header('location: profile.php?id=' . $_SESSION['id']);
    }

?><!doctype html>
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
        h2{
            color: darkgrey;
        }
        label{
            color: #9da5b6;
        }
        #new div{
            display: flex;
            flex-direction: row;
            margin: 0.5em 1.5em;
        }
        #new div *{
            margin: auto 0.5em;
        }
        hr{
            margin: 1.5em;
        }
        #new{
            max-width: 600px;
            margin: 2em auto;
            padding: 1em;
        }
        #name{
            width: 500px;
        }
        #buttons{
            justify-content: flex-end;
        }
        form a{
            text-decoration: none;
            background-color: darkgrey;
            border: 0;
            padding: 1em 2.5em;
            margin: 2em 0;
            text-transform: uppercase;
            color: white;
            font-size: 0.75em;
        }

        form a:hover{
            transition: 0.5s all;
            background-color: #919191;
            color: white;
        }
    </style>
</head>
<body>
<?php include_once("nav.inc.php")?>

<form id="new" action="" method="post">
    <h2>Make a board</h2>

    <div>
        <label for="name">Name</label>
        <input id="name" type="text" name="title">
    </div>
    <hr>
    <div>
        <input type="radio" name="case" value="public" checked>
        <label for="public">Public</label>
    </div>
    <div>
        <input type="radio" name="case" value="private">
        <label for="private">Private</label>
    </div>
    <div id="buttons">
        <a href="javascript:history.go(-1)">CANCEL</a>
        <button type="submit">Make</button>
    </div>
</form>
</body>
</html>