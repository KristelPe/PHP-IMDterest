<?php

    spl_autoload_register(function($class){
        include_once ("classes/" . $class . ".class.php");
    });

    try{
        if( !empty($_POST) ){
            $email = $_POST["email"];
            $password = $_POST["password"];

            $userVerify = new UserVerify();

            if ($userVerify->Verify()){
                $succes = "Jeej it works";
                header('Location: ./index.php');
            } else {
                $error = "Looks like something went wrong";
                header('Location: ./login.php');
            }
        }
    }catch (Exception $e){
        $error = $e->getMessage();
    }


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <form action="" method="post">
        <label for="email">Email</label>
        <input id="email" name="email" type="email">

        <label for="password">Password</label>
        <input id="password" name="password" type="password">

        <button type="submit">LOGIN</button>
    </form>

    <p style="color: red"><?php echo $error?></p>
    <p style="color: green"><?php echo $succes?></p>

</body>
</html>