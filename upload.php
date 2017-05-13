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
    $update = new User();
    $update->setSessionUser($email);
    $userid = $update->userId();

    $profile = new Profile();
    $profile->setUserId($_SESSION['id']);
    $boards = $profile->Boards();

    if (!empty($_POST["title"]) && !empty($_POST["description"]) && !empty($_POST["board"])) {
        if (!empty($_POST["link"]) && empty($_FILES["fileToUpload"]["name"])) {
            error_reporting(0);
            if (get_headers($_POST["link"])) {
                $link = htmlspecialchars($_POST["link"]);
                $title = htmlspecialchars($_POST["title"]);
                $description = htmlspecialchars($_POST["description"]);
                $afbeelding = "";
                $location = htmlspecialchars($_POST["location"]);
                $board = htmlspecialchars($_POST["board"]);

                $post = new Post();
                $post->setMTitle($title);
                $post->setMAfbeelding($afbeelding);
                $post->setMLink($link);
                $post->setMDescription($description);
                $post->setMUserId($userid);
                $post->setMLocation($location);
                $post->setMBoard($board);
                $post->Upload();
                header('location: index.php');
            }else{
                $urlError = "Please enter a valid URL";
            }
            error_reporting(1);
        } elseif (!empty($_FILES["fileToUpload"]["name"]) && empty($_POST["link"])) {
            $title = htmlspecialchars($_POST["title"]);
            $description = htmlspecialchars($_POST["description"]);
            $link = "";
            $location = htmlspecialchars($_POST["location"]);
            $board = htmlspecialchars($_POST["board"]);

            if (!empty($_FILES["fileToUpload"]["name"])) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                    // Check if image file is a actual image or fake image
                    if (isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if ($check !== false) {
                            $uploadSuccess_isImage = "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            $uploadError_isNotImage = "File is not an image.";
                            $uploadOk = 0;
                        }
                    }
                    // Check file size
                    if ($_FILES["fileToUpload"]["size"] > 500000) {
                        $uploadError_size = "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif"
                    ) {
                        $uploadError_type = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        $uploadError_ok = "Sorry, your file was not uploaded.";
                        // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {$target_dir . basename($_FILES["fileToUpload"]["name"]);
                            $uploadSuccess = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                            $afbeelding = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                        } else {
                            $uploadError = "Sorry, there was an error uploading your file.";
                        }
                    }
            }

            if (!empty($afbeelding)) {
                $post = new Post();
                $post->setMTitle($title);
                $post->setMAfbeelding($afbeelding);
                $post->setMLink($link);
                $post->setMDescription($description);
                $post->setMUserId($userid);
                $post->setMLocation($location);
                $post->setMBoard($board);
                $post->Upload();
                header('location: index.php');
            }
        } else {
            $imageError = "PLEASE UPLOAD AN IMAGE OR A WEBSITE";
        }
    } else {
        $fieldError = "PLEASE FILL IN ALL FIELDS WITH (*)";
    }


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/upload.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <title>upload</title>
</head>
<body>

<?php include_once("nav.inc.php")?>

<div id="container">

    <?php if (!empty($boards)) :  ?>

    <form action="" method="post" id="submit" enctype="multipart/form-data">

        <?php if (isset($imageError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $imageError; ?></p>
        <?php endif; ?>
        <?php if (isset($fieldError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $fieldError; ?></p>
        <?php endif; ?>
        <?php if (isset($uploadError_size)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $uploadError_size; ?></p>
        <?php endif; ?>
        <?php if (isset($uploadError2)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $uploadError2; ?></p>
        <?php endif; ?>
        <?php if (isset($uploadError_isNotImage)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $uploadError_isNotImage; ?></p>
        <?php endif; ?>
        <?php if (isset($uploadError_type)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $uploadError_type; ?></p>
        <?php endif; ?>
        <?php if (isset($uploadSuccess)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $uploadSuccess; ?></p>
        <?php endif; ?>
        <?php if (isset($uploadError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $uploadError; ?></p>
        <?php endif; ?>
        <?php if (isset($urlError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $urlError; ?></p>
        <?php endif; ?>

        <h1>Upload</h1>
        <p>Post your inspiration here!</p>
        <label for="title">Title*</label>
        <input type="text" id="title" name="title" placeholder="Your title here">
        <hr>
        <label for="afbeelding">Upload image or website link*</label>
        <input type="file" name="fileToUpload" id="afbeelding" class="image_submit">
        <p style="font-size: 12px;"> Please upload a valid profile picture (Max file size: 500KB, png, jpg, jpeg)</p>
        <p>Or </p>
        <input type="text" id="link" name="link" placeholder="https://www.yourwebsite.com/">
        <button type="button" id="generatebtn" style="margin-left: 0px;">Generate Description</button>
        <label for="location">My location</label>
        <input id="location" name="location" readonly>
        <button type="button" id="generateLocation" style="margin-left: 0px;">Get my location</button>
        <hr>
        <label for="description">Description*</label>
        <textarea id="description" name="description" placeholder="What is it about?"></textarea>

        <p>Select a board*</p>
        <?php foreach ($boards as $b): ?>
            <div id="boards">
                <div class="board <?php echo $board_state ?>">
                    <div class="contain">
                        <input id="board" name="board" value="<?php echo htmlspecialchars($b['id'])?>" type="radio">
                        <img src="<?php echo htmlspecialchars($b['image'])?>" alt="random"> <!-- MOET LATER NOG VERNADERD WORDEN -->
                    </div>
                    <h3><?php echo htmlspecialchars($b['title'])?></h3>
                </div>
            </div>

        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>

    <?php else:?>
        <h1 style="color:black; text-align: center; margin-top: 7%;">Looks like you haven't made any boards yet!</h1>
        <div id="boards">
        <a href="newBoard.php"  class="<?php echo htmlspecialchars($user)?>">
            <div id="add"  class="board <?php echo htmlspecialchars($user)?>">
                <h3>+</h3>
            </div>
        </a>
        </div>
    <?php endif; ?>

</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script>

        $( "#generatebtn" ).click(function() {
            var link = $('#link').val();

            $.ajax({
                type: "POST",
                url: 'ajax/generateDesc.php',
                data: { test: link },
                success: function(response){
                    $("#description").val (response);
                },
                error: function(){
                    $("#description").val ("This webpage does not exist!");
                }
            });
        });
</script>
<script src="js/location.js"></script>
</body>
</html>