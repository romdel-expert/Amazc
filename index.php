<?php
define("ROOT", __DIR__);

/**
 * Activation de l'affichage des erreurs
 */
ini_set('display_errors', 'on');
error_reporting(E_ALL);

session_start();


if (isset($_GET["page"]) && $_GET["page"]) {
    
    $pageName = $_GET["page"];
    $fileController = ucfirst($pageName).'Controller.php';

    require(ROOT . "/Models/Database.php");
    
    if (file_exists("Controllers/" . $fileController)) {
        include("Controllers/" . $fileController);
        if (isset($_GET["act"]) && $_GET["act"]) {
            $method = $_GET["act"];
            $controller = "Controllers\\" . ucfirst($pageName) . "Controller";
            $page = new $controller();
            if (method_exists($controller, $method)) {
                $page->$method();
            } else {
                include("Controllers/ErrorController.php");
                $page = new Controllers\ErrorController();
                $page->show();
            }
        }else{
            include("Controllers/ErrorController.php");
            $page = new Controllers\ErrorController();
            $page->show();
        }
    } else {
        include("Controllers/HomeController.php");
        $page = new Controllers\HomeController();
        $page->home();
    }
} else {
    include("Controllers/ErrorController.php");
    $page = new Controllers\ErrorController();
    $page->show();
}
