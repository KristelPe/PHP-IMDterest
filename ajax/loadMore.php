<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("../classes/" . $class . ".class.php");
    });

    $noP = $_POST['getresult'];
    settype($noP, "integer");

    try {
        $stack = new Stack();
        if (isset($_POST['search'])) {
            $searchq = $_POST['search'];
            $stack->setSearch($searchq);
            $res = $stack->Search($noP);
        } else {
            $sessionId = $_SESSION['id'];
            $stack->setSessionId($sessionId);
            $res = $stack->Stacker($noP);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }

   $results = $res;

foreach ($results as $key => $p) {
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
                       <button id='like' class='" . $stack->Liked($p['id']) . "'></button>
                       <input name='id' type='hidden' value='" . $p['id'] . "'>
                       <p id='likes'>" . $p['likes']. " likes</p>
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
                           <button id='like' class='" . $stack->Liked($p['id']) . "'></button>
                           <input name='id' type='hidden' value='" . $p['id'] . "'>
                           <p id='likes'>" . $p['likes']. " likes</p>
                       </div>
                   </div>";

    }
}
