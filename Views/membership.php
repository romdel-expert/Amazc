<?php 

    if (isset($_SESSION["user"]) && $_SESSION["user"]) {
        ob_start();
        require(ROOT . "/Views/acount.php");
        $content = ob_get_clean();
        require(ROOT . "/Views/template.php");
    } else { 
        ob_start();
    ?>

<div class="content-page">

    <div class="top">
        <h1 class="mt-5 mb-5 text-center">Inscription</h1>
    </div>

    <form class="mt-3" action="/?page=membership&act=create" method="POST">
        <?php include(ROOT ."/Views/acount/form.php") ?>
    </form>
</div>

<?php 
    $content = ob_get_clean();
    require(ROOT . "/Views/template.php");
}
?>
