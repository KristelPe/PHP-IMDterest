<?php

    //check if session exists
    //if not send back to login
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update</title>
</head>
<body>
    <form action="" method="post">
        <label for="name">Upload avatar</label>
        <input type="file" name="avatar" id="avatar">
        <button>
            Upload
        </button>
        <br>
        <br>
        <label for="name">Change email address</label>
        <input type="text" name="email" id="email" placeholder="New email">
        <button>
            Confirm
        </button>
        <br>
        <br>
        <label for="name">Change password</label>
        <input type="text" name="password" id="password" placeholder="New password">
        <button>
            Confirm
        </button>
        <br>
        <br>
        <label for="name">Change username</label>
        <input type="text" name="username" id="username" placeholder="New username">
        <button>
            Confirm
        </button>
    </form>
</body>
</html>