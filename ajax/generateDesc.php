<?php
use spark\Scraper;

require '../libraries/simple_html_dom.php';

session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
}

spl_autoload_register(function ($class) {
    include_once("../classes/" . str_replace('\\', '/', $class) . ".class.php");
});

$url = $_POST['test'];

if( get_headers($url) ) {
    $scraper = new Scraper();
    $scraper->SetLink($url);
    $desc = $scraper->ScrapeDesc();
    echo $desc;
}else{
    die(header("HTTP/1.0 404 Not Found"));

}



