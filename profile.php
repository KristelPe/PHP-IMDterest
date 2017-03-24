<?php

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

    //Replace old username by new username
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
</head>
<body>
    <form action="" method="post">
        <label for="name">Upload avatar</label>
        <input type="file" name="avatar" id="avatar">
        <button>
            Upload
        </button>
        <br>
        <br>
        <label for="name">Change email address</label>
        <input type="text" name="email" id="email" placeholder="New email">
        <button>
            Confirm
        </button>
        <br>
        <br>
        <label for="name">Change password</label>
        <input type="text" name="password" id="password" placeholder="New password">
        <button>
            Confirm
        </button>
        <br>
        <br>
        <p><?php echo "Your current username is " . "<b>" . $username . "</b>" ?></p>
        <p><?php if(isset($usernameError)){echo $usernameError;}else if(isset($usernameSuccess)){echo $usernameSuccess;} ?></p>
        <label for="name">Change username</label>
        <input type="text" name="username" id="username" placeholder="New username">
        <button>
            Confirm
        </button>
    </form>
</body>
</html>