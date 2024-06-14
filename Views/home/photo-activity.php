<div class="row-photo mt-5">


    <?php 
    if ($listActivities) { 
        $quantity = 6;
        if (count ($listActivities) < 6) {
            $quantity = count ($listActivities);
        }
        ?>


    <div class="d-flex">

        <?php for ($i=0; $i < $quantity; $i++) { 
            $activity = $listActivities[$i]?>
        <div class="">


            <?php include(ROOT . "/Views/comon/photo.php")?>
        </div>
        <?php } ?>
    </div>
    <?php }
    ?>

</div>
