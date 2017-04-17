<?php
$count = $_POST['count'];
$id = $_POST['id'];

$connection = new PDO('mysql:host=localhost; dbname=IMDterest', 'root', '');

$statement = $connection->prepare("select likes from posts");
//$statement->bindValue(':id', $id);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);


foreach( $statement as $p ){
  while ($p['id'] == $id){
        if ($count == '+'){
            $val = $result + 1;
        } elseif ($count == '-'){
            $val = $result - 1;
        }

         $update = $connection->prepare("update posts set likes = :likes where id = :id");
         $update->bindValue(':likes', $val);
         $update->bindValue(':id', $id);

         echo $val;
  }
}




