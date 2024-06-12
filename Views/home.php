<?php 

ob_start();

include(ROOT . "/Views/home/carousel.php");

$content = ob_get_clean();
require(ROOT . "/Views/template.php");
?>
