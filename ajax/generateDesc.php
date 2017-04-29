<?php
require '../libraries/simple_html_dom.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("../classes/" . $class . ".class.php");
});

//$url = $_POST['test'];
$url = "https://perfectaim.io";

$scraper = new Scraper();
$scraper->SetLink($url);
$desc = $scraper->ScrapeDesc();

