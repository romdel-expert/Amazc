<div class="page mt-5">


    <?php 
    if ($listDomains) { 
        $quantity = 6;
        if (count ($listDomains) < 6) {
            $quantity = count ($listDomains);
        }
        ?>


    <h3 class="mb-5">Nos domaines d'intervention</h3>

    <div class="row">

        <?php for ($i=0; $i < $quantity; $i++) { 
            $domain = $listDomains[$i]?>
        <div class="col-xxl-2 col-xl-3 col-md-4  col-sm-6 mt-3">
            <div class="activity">
                <?php include(ROOT . "/Views/comon/domain.php")?>
            </div>
        </div>
        <?php } ?>
    </div>

    <div class="text-center mt-5 mb-5">
        <a class="btn-official" href="/?page=domain&act=list">
            En svoir plus
            &nbsp;
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <?php }
    ?>

</div>
