<?php
    //check if session exists
    //if not send back to login
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    print_r($_SESSION);


    if(isset($_POST['search'])) {
        $searchq = $_POST['search'];
        $searchq = preg_replace("#[^0-9a-z]#i", "", $searchq);

        $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
        $statement = $connection->prepare("SELECT * FROM posts WHERE title LIKE :keywords OR description LIKE :keywords");
        $statement->bindValue(':keywords', '%' . $searchq . '%');
        $statement->execute();
        while ($r = $statement->fetch(PDO::FETCH_ASSOC)) {
            echo "<pre>" . print_r($r, true) . "</pre>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
   <nav>
    <a href="index.php">Home</a>
    <a href="upload.php">Upload</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
    </nav>
   <div id="container">

       <form action="index.php" method="post" style="margin-left:10px; margin-bottom:20px;">
           <input type="text" name="search" id="search" placeholder="Search.." style="margin: 25px 0px 30px 10px; border-radius:5%; padding: 3px 50px 3px 3px;" />
           <input type="submit" value=">>" style="margin:-20px 0px 10px 10px;" />
       </form>

       <div class="item_layout">

           <div class="item">
               <div class="item_img">
               </div>
           </div>

           <div class="item">
               <div class="item_img">
               </div>
           </div>

           <div class="item">
               <div class="item_img">
               </div>
           </div>

           <div class="item">
               <div class="item_img">
               </div>
           </div>

           <div class="item">
               <div class="item_img">
               </div>
           </div>

           <div class="item">
               <div class="item_img">
               </div>
           </div>

       </div>
   </div>
</body>
</html>