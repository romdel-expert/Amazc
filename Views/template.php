<!DOCTYPE html>
<html lang="fr">

<?php include(ROOT . "/Views/partials/header.php"); ?>

<body>

    <?php include(ROOT . "/Views/partials/menu.php")?>

    <!--     
                la variable content permet de récuperer le contenu de la la page 
                Ce contenu varie d'une page à l'autre
    -->
    <div class="container-fluid" style="padding: 0;">
        <?= $content; ?>
    </div>


    <?php include(ROOT . "/Views/partials/block-menu/list-footer.php")?>


    <?php include(ROOT . "/Views/partials/script-foot.php"); ?>

</body>

</html>
