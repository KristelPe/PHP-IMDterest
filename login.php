<?php

    error_reporting(E_ALL & ~E_NOTICE);

    spl_autoload_register(function ($class) {
        include_once("classes/" . $class . ".class.php");
    });

    try {
        $error = "";
        if (!empty($_POST)) {
            $email = htmlspecialchars($_POST["email"]);
            $password = htmlspecialchars($_POST["password"]);

            $user = new User();
            $user->setLoginEmail($email);
            $user->setPassword($password);

            if ($user->Login()) {
                //Start session with email as sessionvariable
                $user->Login();
            } else {
                $error = "Looks like something went wrong";
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/background.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
    <div class="form login">
    <h1>Log in</h1>
    <form action="" method="post">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($_POST["email"])?>">

        <label for="password">Password</label>
        <input id="password" name="password" type="password" value="<?php echo htmlspecialchars($_POST["password"])?>">
        <button type="submit">LOGIN</button>
    </form>
    <p>Haven't got an account <a href="registration.php">register here</a></p>
        <p class="error"><?php echo htmlspecialchars($error)?></p>
    </div>
</body>
</html>