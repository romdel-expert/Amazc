<?php 
    ob_start(); 
?>



<div class="page">


    <h1 class="mb-5">Nos domaines d'intervention</h1>



    <?php 
    if ($listDomains) {?>
    <div class="row">
        <?php foreach ($listDomains as $domain) {
        if ($domain["is_active"]) {?>
        <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6">
            <div class="activity">
                <?php include(ROOT . "/Views/comon/domain.php"); ?>
            </div>
        </div>

        <?php } }?>
    </div>
    <?php } else {
    include(ROOT . "/Views/home/carousel.php");
    }

    ?>
</div>

<?php 
    $content = ob_get_clean(); 
    $title = "Domaines d'intervention de association michel archange zéro chômage";
    require(ROOT . "/Views/template.php");
?>
