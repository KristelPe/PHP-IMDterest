<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("../classes/" . $class . ".class.php");
});


try {
    $subComment = new Comment();
    $userid = $subComment->userMail();

    $comment = new Comment();
    $comment->setMComment($_POST["comment"]);
    $comment->setMPostId($_POST["post_id"]);
    $comment->setMUserId($userid);
    $comment->UploadComment();
} catch (Exception $e) {
    echo $e->getMessage();
}
