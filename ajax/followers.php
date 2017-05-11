<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("../classes/" . $class . ".class.php");
});

$profile = new Profile();
$followers = $profile->Followers();

foreach ($followers as $f){
    echo    "<div>
                <a href='profile.php?id=".$f['id']."'>
                    <img class='img' src='". $f['image']."' alt='".$f['id']."'>
                    <p>".$f['username']."</p>
                </a>
            </div>";
}

