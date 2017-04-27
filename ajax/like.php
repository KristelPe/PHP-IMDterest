<?php
    include_once "../classes/Db.class.php";

    session_start();
    $postId = 2;                    //DUUUUUUS dees zou normaal $_POST['postId'] moeten zijn ma da werkt (Undefined index) -> kan waarde uit jquery niet ophalen dus k denk da de fout in dn jquery zit ╮(─▽─)╭
    settype($postId, "integer");

    $count = $_POST['count'];
    $userId = $_SESSION['id'];

    $pdo = Db::getInstance();

    if ($count == 'plus') {
        $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (:userid, :postid)");
        $stmt->bindValue("userid", $userId);
        $stmt->bindValue("postid", $postId);
        $stmt->execute();
    } elseif ($count == 'minus') {
        $stmt = $pdo->prepare("DELETE FROM likes WHERE post_id = :postid AND user_id = :userid");
        $stmt->bindValue("userid", $userId);
        $stmt->bindValue("postid", $postId);
        $stmt->execute();
    }

    $statement = $pdo->prepare("SELECT count(*) FROM likes WHERE post_id = :postid");
    $statement->bindValue("postid", $postId);
    $statement->execute();

    echo $statement->execute();

    // PROBLEEM 3 - nog niet kunnen testen door probleem 1  ╮(─▽─)╭
