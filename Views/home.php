<?php 

ob_start();

include(ROOT . "/Views/home/carousel.php");

include(ROOT . "/Views/home/domains.php");

include(ROOT . "/Views/home/activities.php");

$content = ob_get_clean();
require(ROOT . "/Views/template.php");
?>
