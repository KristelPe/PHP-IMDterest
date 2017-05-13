<?php

if(isset($_POST['user_name']))
{
    $name=$_POST['user_name'];

    $conn = new PDO("mysql:host=localhost; dbname=IMDterest", "root", "");
    $statement = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS username FROM users WHERE username = :username");
    $statement->bindvalue(":username", $name);
    $statement->execute();
    $statement = $conn->prepare("SELECT FOUND_ROWS()");
    $statement->execute();
    $row_count =$statement->fetchColumn();

    if($row_count>0) {
        echo "<img src='./images/not-available%20.png'/>";
        echo "<p style='color:red;'> Username not available! </p>";
    }
    else
    {
        echo "<img src='./images/available.png'/>";
        echo "<p style='color:green;'> Username available! </p>";
    }
    exit();
}
?>