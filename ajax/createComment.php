<?php

session_start();

if(!isset($_SESSION['user'])){
    header('location: login.php');
}

spl_autoload_register(function($class){
    include_once("../classes/" . $class . ".class.php" );
});


try{
    $conn = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $statement->bindvalue(":email", $_SESSION['user']);
    $res = $statement->execute();
    $userid = $statement->fetchColumn();

    $comment = new Comment();
    $comment->setMComment($_POST["comment"]);
    $comment->setMPostId($_POST["post_id"]);
    $comment->setMUserId($userid);
    $comment->Upload();

}catch(Exception $e) {
    echo $e->getMessage();
}