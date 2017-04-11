<?php

    error_reporting(E_ALL & ~E_NOTICE);

    //check if session exists
    //if not send back to login
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }

    //get email address of current user/session
    $email = $_SESSION['user'];

    //find username associated with the email address
    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $connection->prepare("SELECT username FROM users WHERE email = :email");
    $statement->bindvalue(":email", $email);
    $res = $statement->execute();
    $username = $statement->fetchColumn();

    //find password associated with the email address
    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
    $statement = $connection->prepare("SELECT password FROM users WHERE email = :email");
    $statement->bindvalue(":email", $email);
    $res = $statement->execute();
    $password = $statement->fetchColumn();

    //Replace old username by new username

    //Replace old password by new password

    //Replace old email by new email
    try{
        if(!empty ($_POST['username']) && ($_POST['username']) != $username){
            $newUsername = $_POST['username'];
            $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
            $statement = $connection->prepare("UPDATE users SET username = REPLACE(username, '$username', '$newUsername') WHERE INSTR(username, '$username') > 0;");
            $res = $statement->execute();
            $usernameSuccess = "Your username has been changed to " . "<b>" . $newUsername . "</b>";
        }else{
            $usernameError = "Please fill in a valid username!";
        }

        if(!empty ($_POST['password'])){
            $newPassword = $_POST['password'];
            $options = [
                'cost' => 12,
            ];
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT, $options);
            $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
            $statement = $connection->prepare("UPDATE users SET password = REPLACE(password, '$password', '$newPassword') WHERE INSTR(password, '$password') > 0;");
            $res = $statement->execute();
            $passwordSuccess = "Your password has been changed!";
        }else{
            $passwordError = "Please fill in a valid password!";
        }

        if(!empty ($_POST['email']) && ($_POST['email']) != $email){
            $newEmail = $_POST['email'];
            $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');
            $statement = $connection->prepare("UPDATE users SET email = REPLACE(email, '$email', '$newEmail') WHERE INSTR(email, '$email') > 0;");
            $res = $statement->execute();
            $emailSuccess = "Your email has been changed to " . "<b>" . $newEmail . "</b>";
            //update session variable to new email address
            $_SESSION['user'] = $newEmail;
        }else{
            $emailError = "Please fill in a valid email address!";
        }

        if (!empty ($_FILES["fileToUpload"]["name"])) {
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
                    $statement = $connection->prepare("UPDATE users SET image = '$target_file' WHERE email = :email");
                    $statement->bindvalue(":email", $email);
                    $res = $statement->execute();
                } else {
                    $uploadError = "Sorry, there was an error uploading your file.";
                }
            }
        }


    }
    catch(PDOException $e) {
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
</head>
<body>
   <nav>
    <a href="index.php">Home</a>
       <a href="upload.php">Upload</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
    </nav>
   <div id="container">
    <form id="update" action="" method="post" enctype="multipart/form-data">
        <h1>Profile</h1>
        <label for="name">Upload avatar</label>

        <input type="file" name="fileToUpload" id="fileToUpload" class="image_submit">
        <p> Please upload a valid profile picture (Max file size: 500KB, png, jpg, jpeg)</p>
        <p><?php if(isset($uploadError_size)){echo $uploadError_size;}?></p>
        <p><?php if(isset($uploadError2)){echo $uploadError2;} ?></p>
        <p><?php if(isset($uploadError_isNotImage)){echo $uploadError_isNotImage;} ?></p>
        <p><?php if(isset($uploadError_type)){echo $uploadError_type;} ?></p>
        <p><?php if(isset($uploadSuccess)){echo $uploadSuccess; echo "<img style='width:50px; height:50px;' src='$target_file'";} ?></p>
        <p><?php if(isset($uploadError)){echo $uploadError;} ?></p>
        <input type="submit" value="Upload Image" name="submit">

        <hr>

        <div id="profile_form_left">

        <label for="name">Change email address</label>
        <input type="text" name="email" id="email" placeholder="<?php echo $email?>">
        <p><?php if(isset($emailError)){echo $emailError;}else if(isset($emailSuccess)){echo $emailSuccess;} ?></p>

        </div>

        <hr id="middle_hr">

        <div id="profile_form_right">

        <label for="name">Change username</label>
        <input type="text" name="username" id="username" placeholder="<?php echo $username?>">
        <p><?php if(isset($usernameError)){echo $usernameError;}else if(isset($usernameSuccess)){echo $usernameSuccess;} ?></p>

        </div>

        <hr>

        <div id="profile_form_password">

        <label for="name">Change password</label>
        <input type="text" name="password" id="password" placeholder="New password">
        <p><?php if(isset($passwordError)){echo $passwordError;}else if(isset($passwordSuccess)){echo $passwordSuccess;} ?></p>

        </div>

        <button>
            Confirm
        </button>

    </form>
   </div>
</body>
</html>