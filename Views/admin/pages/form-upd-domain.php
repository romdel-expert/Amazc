<?php 
    ob_start();
?>


<div class="page-admin">

    <div class="top">

        <h1 class="mt-3">Modification de domaine d'intervention</h1>
    </div>

    <form class="mt-3" action="/?page=admin&act=updateDomain" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="id" value="<?= $domain["id"]?>">
        <div class="mb-3">
            <label for="titleD" class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" id="titleD" value="<?= $domain["title"] ?>"
                aria-describedby="titleHelp" required>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <img src="<?= $domain["image"]["link"]?>" alt="<?= $domain["title"]?>">
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="file_event_d" class="form-label">Ajouter une photo</label>
                    <input type="file" name="file_event" class="form-control"
                        accept=".jpg, .png, .jpeg, .JPG, .JPEG, .PNG" id="file_event_d"
                        aria-describedby="file_eventHelp">
                </div>
            </div>
        </div>


        <div class="mb-3">
            <label for="descriptionD" class="form-label">Décrire le domaine d'intervention</label>
            <textarea name="description" class="form-control" rows="5" id="descriptionD" required>
                <?= $domain["description"] ?>
            </textarea>
        </div>


        <p class="text-danger mt-3 mb-3">
            <?= $msgDomainError ?>
        </p>

        <div class="row">
            <div class="col-6 mt-4">
                <a class="btn btn-warning" href="/?page=admin&act=domains">
                    <i class="bi bi-chevron-compact-left"></i>
                    &nbsp;
                    Domaines
                </a>
            </div>
            <div class="col-6 mt-4">
                <button type="submit" class="btn-official">Enregistrer</button>
            </div>
        </div>
    </form>
</div>


<?php
$content = ob_get_clean();

$title = "Formulaire d'enregistrerment de mise à jour de domaine d'intervention de l'association michel archange zero chomage";
require(ROOT . "/Views/template-admin.php");
?>
