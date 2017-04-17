<?php
    $no = $_POST['getresult'];

    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

    $statement = $connection->prepare("select * from posts limit $no,20");
    //$statement = $connection->prepare("select * from posts order by id DESC limit $no,20");
    $statement->execute();
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
                        <p id='likes'>" . $p['likes'] . "</p>
                        <p>likes</p>
                        <input type='hidden' value='" . $p['id'] . "'>
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
                           <p id='likes'>" . $p['likes'] . "</p>
                           <p>likes</p>
                           <input type='hidden' value='" . $p['id'] . "'>
                       </div>
                   </div>";
    }
}
