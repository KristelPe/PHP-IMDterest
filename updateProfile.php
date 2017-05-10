<?php

    error_reporting(E_ALL & ~E_NOTICE);

    //check if session exists
    //if not send back to login
    session_start();
    if (!isset($_SESSION['user'])) {
        header('location: login.php');
    }

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

    try {


        $email = $_SESSION['user'];
        $update = new User();
        $update->setSessionUser($email);
        $username = $update->prevUsername();
        $password = $update->prevPassword();

        if (!empty($_POST['username']) && ($_POST['username']) != $username) {
            $newUsername = htmlspecialchars($_POST['username']);
            $update->setUsername($newUsername);
            $res = $update->newUsername($username);
            $usernameSuccess = "Your username has been changed to " . "<b>" . $newUsername . "</b>";
        } else {
            $usernameError = "Please fill in a valid username!";
        }

        if (!empty($_POST['password']) && strlen($_POST['password']) > 6) {
                $newPassword = $_POST['password'];
                $options = [
                    'cost' => 12,
                ];
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT, $options);
                $update->setPassword($newPassword);
                $res = $update->newPassword($password);
                $passwordSuccess = "Your password has been changed!";
        } else {
            $passwordError = "Your password must be more than 6 characters long!";
        }

        if (!empty($_POST['email']) && ($_POST['email']) != $email) {
            $newEmail = htmlspecialchars($_POST['email']);
            $update->setMEmail($newEmail);
            $res = $update->newEmail($email);
            $emailSuccess = "Your email has been changed to " . "<b>" . $newEmail . "</b>";
            //update session variable to new email address
            $_SESSION['user'] = $newEmail;
        } else {
            $emailError = "Please fill in a valid email address!";
        }

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
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $uploadSuccess = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
                    $update->newImg($email, $target_file);
                } else {
                    $uploadError = "Sorry, there was an error uploading your file.";
                }
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        .error{
            background-color: #F44336;
            width: 80%;
            height: 50px;
            margin:auto;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .success{
            background-color: limegreen;
            width: 80%;
            height: 50px;
            margin:auto;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include_once("nav.inc.php")?>

   <div id="container">
    <form id="update" action="" method="post" enctype="multipart/form-data">
        <h1>Profile</h1>

        <?php if (isset($passwordError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $passwordError; ?></p>
        <?php endif; ?>

        <?php if (isset($passwordSuccess)) : ?>
            <p class="success" style="color:white; padding-top: 13px;"><?php echo $passwordSuccess; ?></p>
        <?php endif; ?>

        <?php if (isset($usernameError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $usernameError; ?></p>
        <?php endif; ?>

        <?php if (isset($usernameSuccess)) : ?>
            <p class="success" style="color:white; padding-top: 13px;"><?php echo $usernameSuccess; ?></p>
        <?php endif; ?>

        <?php if (isset($emailError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $emailError; ?></p>
        <?php endif; ?>

        <?php if (isset($emailSuccess)) : ?>
            <p class="success" style="color:white; padding-top: 13px;"><?php echo $emailSuccess; ?></p>
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
            <p class="success" style="color:white; padding-top: 13px;"><?php echo $uploadSuccess; ?></p>
            <?php echo "<img style='width:50px; height:50px;' src='$target_file'"; ?>
        <?php endif; ?>
        <?php if (isset($uploadError)) : ?>
            <p class="error" style="color:white; padding-top: 13px;"><?php echo $uploadError; ?></p>
        <?php endif; ?>

        <label for="name">Upload avatar</label>

        <input type="file" name="fileToUpload" id="fileToUpload" class="image_submit">
        <p> Please upload a valid profile picture (Max file size: 500KB, png, jpg, jpeg)</p>

        <hr>

        <div id="profile_form_left">

        <label for="name">Change email address</label>
        <input type="email" name="email" id="email" placeholder="<?php echo htmlspecialchars($email)?>">

        </div>

        <hr id="middle_hr">

        <div id="profile_form_right">

        <label for="name">Change username</label>
        <input type="text" name="username" id="username" placeholder="<?php echo htmlspecialchars($username)?>">

        </div>

        <hr>

        <div id="profile_form_password">

        <label for="name">Change password</label>
        <input type="password" name="password" id="password" placeholder="New password">

        </div>

        <button>
            Confirm
        </button>

    </form>
   </div>
</body>
</html>