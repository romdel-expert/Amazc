<?php 
    ob_start();
?>

<form action="/?page=membership&act=update" method="POST" class="content-page">

    <?php include(ROOT ."/Views/acount/form-update.php")?>
</form>


<?php 
    $content = ob_get_clean();
    require(ROOT . "/Views/template.php"); 
?>
