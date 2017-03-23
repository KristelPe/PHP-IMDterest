<?php
    //connectie maken met database
    $connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

    //check of er gepost is?

    try{
        if(!empty ($_POST)){
            $email = $_POST["email"];
            $firstname = $_POST["firstname"];
            $lastname = $_POST["lastname"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            $stmnt = $connection->prepare("insert into users (email, firstname, lastname, username, password) values (:email, :firstname, :lastname, :username, :password)");
            $stmnt->bindvalue(":email", $email);
            $stmnt->bindvalue(":firstname", $firstname);
            $stmnt->bindvalue(":lastname", $lastname);
            $stmnt->bindvalue(":username", $username);
            $stmnt->bindvalue(":password", $password);
            $res = $stmnt->execute();
            var_dump($res);

        }
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP-IMDterest</title>
</head>
<body>
    <form action="" method="post">
        <label for="fullname">Firstname</label>
        <input type="text" name="firstname" id="firstname">
        
        <label for="fullname">Lastname</label>
        <input type="text" name="lastname" id="lastname">
        
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        
        <button type="submit" id="submit">Registreren</button>
    </form>
</body>
</html>