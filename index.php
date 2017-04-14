<?php
    //check if session exists
    //if not send back to login
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    try{
        $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

        if(isset($_POST['search'])) {
            $searchq = $_POST['search'];
            $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

            $statement = $connection->prepare("SELECT * FROM posts WHERE title LIKE :keywords OR description LIKE :keywords");
            $statement->bindValue(':keywords', '%' . $searchq . '%');
            $statement->execute();
            /*while ($r = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<pre>" . print_r($r, true) . "</pre>";
            }*/
        } else {
            $statement = $connection->prepare("select * from posts order by id DESC ");
            $statement->execute();
        }

    }catch(Exception $e) {
        echo $e->getMessage();
    }

    $i = 0;

    $count = 22;
    if(isset($_POST['more']))
    {
        $count = $count + 20;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IMDterest</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/search.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>

        .post_img{
            width: 230px;
            border-radius: 5px;
            max-height: 200px;
            overflow: hidden;
        }

        img{
            width: 230px;
        }

        .like{
            display: flex;
            flex-direction: row;
            margin-top: 1em;
        }

        p{
            margin-top: 0.5em;
            color: #9da5b6;
        }

        .like{
            line-height: 1em;
        }

        .like p, .user p{
            color: #b4b4b4;
            font-size: small;
        }

        .like button{
            margin: 0;
            margin-right: 1em;
            width: 30px;
            height: 30px;
            padding:0;
            background-position: center;
            background-size: 20px;
            background-repeat: no-repeat;
            background-color: white;
            border-radius: 5px;
        }

        .liked{
            background-image: url("http://www.clker.com/cliparts/o/4/f/P/U/b/red-heart-hi.png");
        }

        .unliked{
            background-image: url("http://www.clker.com/cliparts/d/v/C/j/y/1/grey-heart-hi.png");
        }

        .item{
            max-height: 500px;
        }

    </style>
</head>
<body>
   <nav>
    <a href="index.php">Home</a>
    <a href="upload.php">Upload</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
    </nav>

   <div id="search_bar_style">
       <form action="index.php" method="post" id="search_bar">
           <input type="text" name="search" id="search" placeholder="Search..." />
           <button type="submit" id="search_bar_button"></button>
       </form>
   </div>

   <div id="container">

       <div class="item_layout">

           <?php foreach ($statement as $p): if (++$i == $count) break; ?>
           <div class="item">
               <h1><?php echo $p['title']?></h1>
               <div class="post_img">
                   <img src="<?php echo $p['image']?>" alt="<?php echo $p['title']?>">

               </div>
               <div class="like">
                   <button class="unliked"></button>
                   <p>[#likes]</p>
               </div>
               <p><?php  echo $p['description']?></p>
           </div>
           <?php endforeach;?>

       </div>

       <form method="POST" action=''>
        <?php if(!isset($_POST['search'])) { echo "<button type='submit' name='more' id='more'>Load more</button>"; } ?>
       </form>
   </div>
</body>
</html>
