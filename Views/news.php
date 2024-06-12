<?php 
    ob_start(); 
?>



<div class="page">


    <h1 class="mb-5">Nos activités</h1>



    <?php 
    if ($listActivities) {?>
    <div class="row">
        <?php foreach ($listActivities as $activity) {
        if ($activity["is_active"]) {?>
        <div class="col-xxl-2 col-xl-3 col-md-4 col-sm-6">
            <div class="activity">
                <?php include(ROOT . "/Views/comon/activity.php"); ?>
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
    $title = "Activités de association michel archange zéro chômage";
    require(ROOT . "/Views/template.php");
?>
