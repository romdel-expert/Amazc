<div class="block-about">
    <div class="row">
        <?php 
        if ($dataParams["about"]) { ?>
        <div class="col-md-4 col-sm-6 p-2">
            <div class="activity">
                <h2>Qui sommes-nous?</h2>
                <p>
                    <?= $dataParams["about"]; ?>
                </p>
            </div>
        </div>
        <?php }

        if ($dataParams["dna"]) { ?>
        <div class="col-md-4 col-sm-6 p-2">
            <div class="activity">
                <h2>Notre ADM</h2>
                <p>
                    <?= $dataParams["dna"]; ?>
                </p>
            </div>
        </div>
        <?php }
    if ($dataParams["committee"]) { ?>

        <div class="col-md-4 col-sm-6 p-2">
            <div class="activity">
                <h2>Notre comité</h2>
                <p>
                    <?= $dataParams["committee"]; ?>
                </p>
            </div>
        </div>
        <?php }?>
    </div>
</div>
