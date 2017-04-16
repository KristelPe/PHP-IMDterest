<?php
    $no = $_POST['getresult'];

    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

    $statement = $connection->prepare("select * from posts order by id DESC limit $no,20");
    $statement->execute();

    foreach( $results as $key => $p ){
        echo "<div id='item' class='item'>
                 <h1>" . $p['title'] . "</h1>
                 <a href='post.php?postid=" . $key . "'>
                     <div class='post_img'>
                         <img src='" . $p['image'] . "' alt='" . $p['title'] . "'>
                     </div>
                 </a>
                 <div class='like'>
                     <button class='unliked'></button>
                     <p>[#likes]</p>
                 </div>
                 <p>" . $p['description'] . "</p>
              </div>";

    }