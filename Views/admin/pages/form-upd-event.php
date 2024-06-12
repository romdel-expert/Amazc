<?php 
    ob_start();
?>


<div class="page-admin">

    <div class="top">

        <h1 class="mt-3">Modification d'activité</h1>
    </div>

    <form class="mt-3" action="/?page=admin&act=updateEvent" enctype="multipart/form-data" method="POST">
        <input type="hidden" name="id" value="<?= $activity["id"]?>">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" id="title" value="<?= $activity["title"] ?>"
                aria-describedby="titleHelp" required>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <img src="<?= $activity["image"]["link"]?>" alt="<?= $activity["title"]?>">
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="file_event" class="form-label">Ajouter une photo</label>
                    <input type="file" name="file_event" class="form-control"
                        accept=".jpg, .png, .jpeg, .JPG, .JPEG, .PNG" id="file_event" aria-describedby="file_eventHelp">
                </div>
            </div>
        </div>


        <div class="mb-3">
            <label for="description" class="form-label">Décrire l'événement</label>
            <textarea name="description" class="form-control" rows="5" id="description" required>
                <?= $activity["description"] ?>
            </textarea>
        </div>


        <p class="text-danger mt-3 mb-3">
            <?= $msgEventError ?>
        </p>

        <div class="row">
            <div class="col-6 mt-4">
                <a class="btn btn-warning" href="/?page=admin&act=events">
                    <i class="bi bi-chevron-compact-left"></i>
                    &nbsp;
                    Evénements
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

$title = "Formulaire d'enregistrerment d'un nouvel événement asisté par association michel archange zero chomage";
require(ROOT . "/Views/template-admin.php");
?>
