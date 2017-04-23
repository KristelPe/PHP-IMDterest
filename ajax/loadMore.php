<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    $no = $_POST['getresult'];

    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

    $stmnt = $connection->prepare("select count(*) from following where followerid = :followerid");
    $stmnt->bindValue(':followerid', $_SESSION['id']);
    $stmnt->execute();
    $status =  $stmnt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($status)) {
        $statement = $connection->prepare("select p.* from posts p inner join following f on f.userid = p.userid where followerid = :followerid limit $no,20");
        $statement->bindValue(':followerid', $_SESSION['id']);
        $statement->execute();
    } else {
        $statement = $connection->prepare("select * from posts limit $no,20");
        $statement->execute();
        //$statement = $connection->prepare("select * from posts order by id DESC limit $no,20");
    }
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach( $results as $key => $p ) {
    if (!empty($p['link'])) {
        $html = file_get_html($p['link']);
        $pagetitle = $html->find('title', 0);
        $image = $html->find('img', 0);

        echo "<div id='item' class='item'>
                    <h1>" . $p['title'] . "</h1>
                   <a href='" . $p['link'] . "'>" .
            $pagetitle->plaintext
            . "</a>
                       <a href='post.php?postid=" . $p['id'] . "'>
                           <div class='post_img'>
                           <img src='
                                " .
            $image->src
            . "'
                                alt='
                                " .
            $pagetitle->plaintext
            . "'
                           >
                       </div>
                   </a>
                   <div class='like'>
                       <button id='like' class='unliked'></button>
                       <p id='likes'></p>
                       <p>likes</p>
                       <input name='id' type='hidden' value='" . $p['id'] . "'>
                   </div>
                   
                   </div>";
    } elseif (empty($p['link'])) {
        echo "<div id='item' class='item'>
                       <h1>" . $p['title'] . "</h1>
                       <a href='post.php?postid=" . $p['id'] . "'>
                           <div class='post_img'>
                               <img src='" . $p['image'] . "' alt='" . $p['title'] . "'>
                           </div>
                       </a>
                       <div class='like'>
                           <button id='like' class='unliked'></button>
                           <p id='likes'></p>
                           <p>likes</p>
                           <input name='id' type='hidden' value='" . $p['id'] . "'>
                       </div>
                   </div>";
    }
}
