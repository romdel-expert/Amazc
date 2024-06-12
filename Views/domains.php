<?php 

    ob_start(); ?>

<div>
    <img src="../../Assets/images/test.jpeg" alt="" style="width: 100%;">
</div>

<?php 
$content = ob_get_clean(); 

require(ROOT . "/Views/template.php");
?>
