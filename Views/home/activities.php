<div class="page mt-5">

    <h3 class="mb-5">Nos activités</h3>

    <?php 
    if ($listActivities) { 
        $quantity = 6;
        if (count ($listActivities) < 6) {
            $quantity = count ($listActivities);
        }
        ?>
    <div class="row">

        <?php for ($i=0; $i < $quantity; $i++) { 
            $activity = $listActivities[$i]?>
        <div class="col-xxl-2 col-xl-3 col-md-4  col-sm-6 mt-3">
            <div class="activity">
                <?php include(ROOT . "/Views/comon/activity.php")?>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="text-center mt-5 mb-5">
        <a class="btn-official" href="/?page=news&act=list">
            En svoir plus
            &nbsp;
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <?php }
    ?>

</div>
