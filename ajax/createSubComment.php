<?php

session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("../classes/" . $class . ".class.php");
});


try {
    $conn = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $statement->bindvalue(":email", $_SESSION['user']);
    $res = $statement->execute();
    $userid = $statement->fetchColumn();

    $subComment = new Comment();
    $subComment->setMComment($_POST["comment"]);
    $subComment->setCommentId();
    $subComment->setMUserId($userid);
    $subComment->UploadComment();
} catch (Exception $e) {
    echo $e->getMessage();
}
