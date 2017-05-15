<?php

use spark\Comment;

session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("../classes/" . str_replace('\\', '/', $class) . ".class.php");
});


try {
    $subComment = new Comment();
    $userid = $subComment->userMail();

    $subComment->setMComment($_POST["sub_comment"]);
    $subComment->setCommentId($_POST["comment_id"]);
    $subComment->setMUserId($userid);
    $subComment->UploadSubComment();
} catch (Exception $e) {
    echo $e->getMessage();
}
