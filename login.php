<?php

    if( !empty($_POST) ){
        $email = $_POST["email"];
        $password = $_POST["password"];

        $conn = new PDO('mysql:host=localhost;dbname=IMDterest', 'root', '');
        $statement = $conn->prepare("SELECT * FROM users WHERE email = :email ;");
        $statement->bindValue(":email", $email);
        $res = $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);


        foreach( $results as $row ){
            if(password_verify($password, $row['password'])){
                header('Location: login.php');
            }
            else
            {
                session_start();
                $_SESSION['email'] = $email;
                header('Location: index.php');
            }
        }
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
</body>
</html>