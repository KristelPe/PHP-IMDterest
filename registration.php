<?php

    error_reporting(E_ALL & ~E_NOTICE);

    //connectie maken met database
    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

    //check of er gepost is?

    try {
        $error = "";
        if (!empty($_POST)) {
            $email = htmlspecialchars($_POST["email"]);
            $firstname = htmlspecialchars($_POST["firstname"]);
            $lastname = htmlspecialchars($_POST["lastname"]);
            $username = htmlspecialchars($_POST["username"]);
            $image = "images/default.png";
            $password = htmlspecialchars($_POST["password"]);
            $options = [
                'cost' => 12,
            ];
            $password = password_hash($password, PASSWORD_DEFAULT, $options);

            $user = new User();
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setUsername($username);
            $user->setImage($image);
            $user->Register();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP-IMDterest</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/background.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
   <div class="form registration">
   <h1>Sign up</h1>
    <form action="" method="post">
        <label for="firstname">Firstname</label>
        <input type="text" maxlength="20" name="firstname" id="firstname" value="<?php echo htmlspecialchars($_POST["firstname"])?>">
        
        <label for="lastname">Lastname</label>
        <input type="text" maxlength="20" name="lastname" id="lastname" value="<?php echo htmlspecialchars($_POST["lastname"])?>">
        
        <label for="email">Email</label>
        <input type="email" maxlength="50" name="email" id="email" value="<?php echo htmlspecialchars($_POST["email"])?>">
        
        <label for="username">Username</label>
        <input type="text" maxlength="15" name="username" id="username" value="<?php echo htmlspecialchars($_POST["username"])?>">

        <label for="password">Password</label>
        <input type="password" maxlength="32" name="password" id="password" value="<?php echo htmlspecialchars($_POST["password"])?>">
        
        <button type="submit" id="submit">Register</button>
    </form>
    <p>Already got an account <a href="login.php">login here</a></p>
       <p class="error"><?php echo htmlspecialchars($error)?></p>
    </div>
</body>
</html>