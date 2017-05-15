<?php
use spark\Profile;

header('Content-Type: application/json');
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}
spl_autoload_register(function ($class) {
    include_once("../classes/" . str_replace('\\', '/', $class) . ".class.php");
});
if(!empty($_POST)){
    $board = new profile();
    $boardId = $_POST['id'];
    $check = $board->removeBoard($boardId);

    if($check){
        $feedback = [
            "code"=>200,
            "id"=> $_POST['id']
        ];
    }else{
        $feedback=[
            "code"=>500,
            "id"=>0
        ];
    }
    echo json_encode($feedback);
}