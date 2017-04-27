<?php
require 'libraries/simple_html_dom.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("classes/" . $class . ".class.php");
});

$email = $_SESSION['user'];

//find userid associated with the email address
$conn = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
$statement = $conn->prepare("SELECT id, username, image FROM users WHERE email = :email");
$statement->bindvalue(":email", $email);
$statement->execute();
$res = $statement->fetch();
$userid = $res['id'];
$image = $res['image'];
$username = $res['username'];
$postid = $_GET['postid'];

if (!empty($_POST["report"])) {
    try {
        $report = new Post();
        $report->setMUserId($userid);
        $report->setMPostId($postid);
        $report->Report();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (!empty($_POST["remove_post"])) {
    try {
        $removePost = $conn->prepare("DELETE FROM posts WHERE userId = $userid  and id = $postid");
        $res = $removePost->execute();
        header('location: index.php');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

try {
    $select = $conn->prepare("select p.*, u.username as username, u.image as img, u.id as userid 
                              from posts p 
                              inner join users u 
                              where u.id = p.userid");
    $res = $select->execute();
    $results = $select->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage();
}

$commentError = "";

try {
    $selectComments = $conn->prepare("select c.*, u.username as username, u.image as img from comments c inner join users u where u.id = c.userid and c.postId = $postid ORDER BY c.Id DESC ");
    $res = $selectComments->execute();
} catch (Exception $e) {
    $commentError = $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/post.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>

<?php include_once("nav.inc.php")?>

<div id="container">
    <div id="post_layout">
        <?php foreach ($results as $p): ?>

            <?php if ($p['id'] == $postid && empty($p['link'])): ?>
                <img src="<?php echo $p['image']?>" alt="<?php echo $p['title']?>">
                <div id="post_layout_info">
                    <h1><?php echo $p['title']?></h1>
                    <div class="user">
                        <div class="user_img">
                            <img src="<?php echo $p['img']?>" alt="<?php echo $p['username']?>">
                        </div>

                        <a href="profile.php?id=<?php echo $p['userid']?>">
                            <h2><?php echo $p['username']?></h2>
                        </a>
                    </div>
                    <p><?php echo $p['description']?></p>
                    <p><?php $Post = new Post();
                        echo $Post->Datum($p['date']); ?></p>
                </div>

            <?php elseif ($p['id'] == $postid && !empty($p['link'])): ?>
                <?php
                $html = file_get_html($p['link']);
                $pagetitle = $html->find('title', 0);
                $image = $html->find('img', 0);
                ?>
                <a style="text-decoration: none;" href="<?php echo $p['link'] ?>">
                    <h1><?php echo $pagetitle->plaintext ?></h1>
                    <img src='<?php echo $image->src ?>' alt='<?php echo $pagetitle->plaintext ?>'>
                </a>
                <div id="post_layout_info">
                    <h1><?php echo $p['title']?></h1>
                    <div class="user">
                        <div class="user_img">
                            <img src="<?php echo $p['img']?>" alt="<?php echo $p['username']?>">
                        </div>
                        <a href="profile.php?id=<?php echo $p['userid']?>">
                            <h2><?php echo $p['username']?></h2>
                        </a>
                    </div>
                    <p><?php echo $p['description']?></p>


                </div>

            <?php endif; ?>

        <?php endforeach; ?>

    </div>

    <?php if ($p['userid'] == $userid): ?>


        <form action="" method="post" id="remove_post">
            <input type="submit" name="remove_post" value="Remove Post">
        </form>

    <?php endif; ?>

    <?php if ($p['userid'] != $userid): ?>

        <form action="" method="post" id="report">
            <input type="submit" name="report" value="Report">
        </form>

        <p><?php echo "HIER REPORT MESSAGE"?></p>

    <?php endif; ?>

    <div id="comment_layout">
        <form action="" method="post" id="submit" enctype="multipart/form-data">
            <label for="text_comment">Comment</label>
            <textarea id="text_comment" name="comment" placeholder="..."></textarea>
            <input type="hidden" value="<?php echo htmlentities($_GET["postid"]); ?>" name="post_id">
            <p><?php echo $commentError?></p>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div id="comments_layout">
        <?php $resultsComments = $selectComments->fetchAll(PDO::FETCH_ASSOC);

        foreach ($resultsComments as $c) {
            echo "
                    <div class=\"comment_user\">
                        <div class=\"user_img\">
                            <img src=" . $c['img'] . " alt=" . $c['username'] . ">
                        </div>
                        <div class=\"user_comment\">
                        <h2>" . $c['username'] . ":". "</h2>
                        <p>" . $c['comment'] . "</p>
                        </div>
                    </div>
         
                 ";
        }
        ?>
    </div>

    <script src="jquery.min.js"></script>
    <script>
        $("#submit").bind("submit", function(e) {
            $.post('ajax/createComment.php', $(this).serialize(), function(e) {
                // Zodra gepost, nieuw element toevoegen

                var comment = $("<div class='comment_user'>");
                var username = '<?php echo $username ?>';
                var img = '<?php echo $image ?>';
                comment.html('<div class="user_img"><img src=' + img + '></div><div class="user_comment"><h2>' + username + ':' + '</h2><p>' + $('#text_comment').val() + '</p></div>');

                $("#comments_layout").prepend(comment);


                // Veld leegmaken

                $('#text_comment').val('');
            });
            e.preventDefault();
        })
    </script>
</div>
</body>
</html>