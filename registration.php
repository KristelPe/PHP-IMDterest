<?php
    //connectie maken met database
    spl_autoload_register(function($class){
        include_once("classes/" . $class . ".class.php" );
    });

    //check of er gepost is?

    try{
        if(!empty ($_POST)){
            $email = $_POST["email"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $options = [
                'cost' => 12,
            ];

            $password = password_hash($password, PASSWORD_DEFAULT, $options);

            $user = new User();
            $user->setMEmail($email);
            $user->setMFirstname($firstname);
            $user->setMLastname($lastname);
            $user->setMUsername($username);
            $user->setMPassword($password);
            $user->Register();


        }
    }
    catch(Exception $e) {
        echo $e->getMessage();
        echo "Your form is not complete";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP-IMDterest</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
   <div class="form registration">
   <h1>Sign up</h1>
    <form action="" method="post">
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname">
        
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname">
        
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        
        <label for="username">Username</label>
        <input type="text" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button type="submit" id="submit">Register</button>
    </form>
    <p>Already got an account <a href="login.php">login here</a></p>
    </div>
</body>
</html>