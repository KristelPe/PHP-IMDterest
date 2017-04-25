<?php
    include_once "../classes/Db.class.php";

    session_start();

    $postId = $_POST['id'];
    $count = $_POST['count'];
    $userId = $_SESSION['id'];

    $pdo = Db::getInstance();

    if ($count == true) {
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (:userid, :postid)");
        $stmt->bindValue("userid", $userId);
        $stmt->bindValue("postid", $postId);
        $stmt->execute();
    } elseif ($count == false) {
        $stmt = $pdo->prepare("DELETE FROM likes WHERE postid = :postid AND userid = :userid");
        $stmt->bindValue("userid", $userId);
        $stmt->bindValue("postid", $postId);
        $stmt->execute();
    }

    $statement = $pdo->prepare("SELECT count(*) FROM likes WHERE postid = :postid");
    $statement->bindValue("postid", $postId);
    $likes = $statement->execute();

    echo $likes;


    // PROBLEEM 3 - nog niet kunnen testen door probleem 1  ╮(─▽─)╭
