<?php
use spark\Post;

spl_autoload_register(function ($class) {
        include_once("../classes/" . str_replace('\\', '/', $class) . ".class.php");
    });

    session_start();
    $postId = $_POST['postId'];
    settype($postId, "integer");

    $count = $_POST['count'];
    $userId = $_SESSION['id'];

    $post = new Post();
    $post->setMPostId($postId);
    $post->setMUserId($userId);

    if ($count == 'plus') {
       $post->Like();
    } elseif ($count == 'minus') {
       $post->Unlike();
    }

    $res = $post->CountLikes();

    foreach ($res as $p){
        echo $p['likes'];
    }
