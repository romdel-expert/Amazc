<?php 
ob_start();
?>

<div class="content-page">
    inscription
</div>


<?php 
$content = ob_get_clean();
require(ROOT . "/Views/template.php");
?>
