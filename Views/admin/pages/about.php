<?php 
    ob_start();
?>


<div class="page-admin">

    <div class="top">

        <h1 class="mt-3">A propos</h1>
    </div>

    <form class="mt-3" action="/?page=admin&act=saveAbout" method="POST">



        <div class="mb-3">
            <label for="about" class="form-label">A propos de AMAZC</label>
            <textarea name="about" class="form-control" rows="5" id="about" required>
                <?= $dataParams["about"] ?>
            </textarea>
        </div>


        <p class="text-danger mt-3 mb-3">
            <?= $msgAboutError ?>
        </p>

        <div class="row">
            <div class="col-6 mt-4">
                <button type="submit" class="btn-official">Modifier</button>
            </div>
        </div>
    </form>
</div>


<?php
$content = ob_get_clean();

$title = "Contenu du texte à propos de l'association michel archange zero chomage";
require(ROOT . "/Views/template-admin.php");
?>
