<?php
use spark\Comment;
use spark\Post;
use spark\Profile;
use spark\Scraper;
use spark\topic;

require 'libraries/simple_html_dom.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("classes/" . str_replace('\\', '/', $class) . ".class.php");
});

$reportmessage ="";
$email = $_SESSION['user'];

//find userid associated with the email address
$profile = new Profile();
$res = $profile->userVMail($email);

$userid = htmlspecialchars($res['id']);
$image = htmlspecialchars($res['image']);
$username = htmlspecialchars($res['username']);
$postid = $_GET['postid'];

$post = new Post();
$post->setMUserId($userid);
$post->setMPostId($postid);
if (!empty($_POST["report"])) {
    try {
        $reportmessage = $post->Report();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (!empty($_POST["remove_post"])) {
    try {
        $post->removePost();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

try {
    $results = $post->showPost();
} catch (Exception $e) {
    echo $e->getMessage();
}

$commentError = "";

try {
    $comment = new Comment();
    $comment->setMPostId($postid);
    $resC = $comment->showComments();
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
                <div class="top_layout_post">
                    <div class="user_post_img">
                        <a href="profile.php?id=<?php echo htmlspecialchars($p['userid'])?>">
                            <img src="<?php echo htmlspecialchars($p['img'])?>" alt="<?php echo htmlspecialchars($p['username'])?>">
                        </a>
                    </div>
                    <div class="post_title_info">
                        <h1><?php echo htmlspecialchars($p['title'])?></h1>
                        <h2>Uploaded by: <a href="profile.php?id=<?php echo htmlspecialchars($p['userid'])?>" style="text-decoration: none;"><?php echo htmlspecialchars($p['username'])?></a></h2>
                    </div>
                </div>

                    <img src="<?php echo htmlspecialchars($p['image'])?>" alt="<?php echo htmlspecialchars($p['title'])?>" class="posted_image">

                <div class="post_layout_info">
                    <p><?php echo htmlspecialchars($p['description'])?></p>
                    <p>
                        <?php
                        $topic = new topic();
                        $topicname = $topic->GetTopicName($p['topic']);
                        echo "Topic: " . $topicname;
                        ?>
                    </p>
                    <p><?php $Post = new Post();
                        echo $Post->Datum($p['date']); ?></p>
                    <p><?php echo htmlspecialchars($p['location'])?></p>
                </div>

            <?php elseif ($p['id'] == $postid && !empty($p['link'])): ?>
                <?php
                $scraper = new Scraper();
                $scraper->SetLink($p['link']);
                $pagetitle = $scraper->ScrapeTitle();
                $image = $scraper->ScrapeImg();
                ?>
                <div class="top_layout_post">
                    <div class="user_post_img">
                        <a href="profile.php?id=<?php echo htmlspecialchars($p['userid'])?>">
                            <img src="<?php echo htmlspecialchars($p['img'])?>" alt="<?php echo htmlspecialchars($p['username'])?>">
                        </a>
                    </div>
                    <div class="post_title_info">
                        <h1><?php echo htmlspecialchars($p['title'])?></h1>
                        <h2>Uploaded by: <a href="profile.php?id=<?php echo htmlspecialchars($p['userid'])?>" style="text-decoration: none;"><?php echo htmlspecialchars($p['username'])?></a></h2>
                    </div>
                </div>
                <a style="text-decoration: none;" href="<?php echo htmlspecialchars($p['link']) ?>">
                    <h1><?php echo htmlspecialchars($pagetitle) ?></h1>
                </a>
                <div id="post_layout_info">
                    <a style="text-decoration: none;" href="<?php echo htmlspecialchars($p['link']) ?>">
                    <img src="<?php echo htmlspecialchars($image)?>" alt="<?php echo htmlspecialchars($pagetitle)?>" class="posted_image">
                    </a>
                    <div class="post_layout_info">
                        <p><?php echo htmlspecialchars($p['description'])?></p>
                        <p>
                            <?php
                            $topic = new topic();
                            $topicname = $topic->GetTopicName($p['topic']);
                            echo "Topic: " . $topicname;
                            ?>
                        </p>
                        <p><?php $Post = new Post();
                            echo $Post->Datum($p['date']); ?></p>
                        <p><?php echo htmlspecialchars($p['location'])?></p>
                    </div>
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
            <p><?php echo htmlspecialchars($reportmessage) ?></p>
        </form>

    <?php endif; ?>





    <div id="comment_layout">
        <form action="" method="post" id="submit" enctype="multipart/form-data">
            <label for="text_comment">Comment</label>
            <textarea id="text_comment" name="comment" placeholder="..."></textarea>
            <input type="hidden" value="<?php echo htmlentities($_GET["postid"]); ?>" name="post_id">
            <p><?php echo htmlspecialchars($commentError)?></p>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div id="comments_layout">
        <?php $resultsComments = $resC; foreach ($resultsComments as $c):?>
            <hr>
                    <div class="comment_user">
                        <div class="user_img">
                            <img src="<?php echo htmlspecialchars($c['img'])?>" alt="<?php echo htmlspecialchars($c['username'])?>">
                        </div>
                        <div class="user_comment">
                            <h2><?php echo htmlspecialchars($c['username'])?>:</h2>
                            <p><?php echo htmlspecialchars($c['comment'])?></p>
                        </div>
                    </div>

                    <div id="sub-comment_layout">
                    <?php
                $resultsSubComments = $comment->showSubComments($c["cid"]);
            foreach ($resultsSubComments as $Subc):?>

                        <div class="sub-comment_user">
                            <div class="sub-user_img">
                                <img src="<?php echo htmlspecialchars($Subc['image'])?>" alt="<?php echo htmlspecialchars($Subc['username'])?>">
                            </div>
                            <div class="sub-user_comment">
                                <h2><?php echo htmlspecialchars($Subc['username'])?>:</h2>
                                <p><?php echo htmlspecialchars($Subc['comment'])?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    </div>

                        <div class="sub-comment_user-form">
                            <div class="sub-user_img">
                                <img src="<?php echo htmlspecialchars($image) ?>" alt="<?php echo htmlspecialchars($username) ?>">
                            </div>
                            <form action="" method="post" id="submit" enctype="multipart/form-data" class="sub-comment_form">
                                <textarea id="text_sub_comment" name="sub_comment" placeholder="..."></textarea>
                                <input  type="hidden" value="<?php echo htmlentities($c["cid"]); ?>" name="comment_id">
                                <button type="submit">Reply</button>
                            </form>
                        </div>

        <?php endforeach; ?>

    </div>

    <script src="jquery.min.js"></script>
    <script>
        $("#submit").bind("submit", function(e) {
            $.post('ajax/createComment.php', $(this).serialize(), function(e) {
                // Zodra gepost, nieuw element toevoegen

                var comment = $("<div class='comment_user'>");
                var username = '<?php echo htmlspecialchars($username) ?>';
                var img = '<?php echo htmlspecialchars($image) ?>';
                comment.html('<div class="user_img"><img src=' + img + '></div><div class="user_comment"><h2>' + username + ':' + '</h2><p>' + $('#text_comment').val() + '</p></div>');

                $("#comments_layout").prepend(comment);


                // Veld leegmaken

                $('#text_comment').val('');
            });
            e.preventDefault();
        });

        $(".sub-comment_form").bind("submit", function(e) {
            $.post('ajax/createSubComment.php', $(this).serialize(), function(e) {
                // Zodra gepost, nieuw element toevoegen

                var subComment = $("<div class='sub-comment_user'>");
                var username = '<?php echo htmlspecialchars($username) ?>';
                var img = '<?php echo htmlspecialchars($image) ?>';
                subComment.html('<div class="sub-user_img"><img src=' + img + '></div><div class="sub-user_comment"><h2>' + username + ':' + '</h2><p>' + $('#text_sub_comment').val() + '</p></div>');

                $("#sub-comment_layout").append(subComment);


                // Veld leegmaken

                $('#text_sub_comment').val('');
            });
            e.preventDefault();
        });

    </script>
</div>
</body>
</html>