<?php 
    ob_start();
?>

<div class="page-admin-full">

    <a class="btn-official fix-position" href="/?page=admin&act=formEvent">
        <i class="bi bi-plus-lg"></i>
        &nbsp;
        Ajouter un évenement
    </a>

    <?php 
    if ($msgEventError) {?>
    <div class="alert <?= $class ?>" role="alert">
        <?= $msgEventError ?>
    </div>
    <?php }
    ?>

    <div class="container-fluid">
        <?php 
        if (!$listActivities) {
            
        } else {  ?>
        <div class="row">
            <?php 
            foreach ($listActivities as $activity) { ?>
            <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 p-1">
                <div class="activity">
                    <?php include(ROOT . "/Views/comon/activity.php")?>
                    <div class="p-1">
                        <div class="row">
                            <div class="col-4 text-center">
                                <form action="/?page=admin&act=formActivityUpd" method="POST">
                                    <input type="hidden" name="id" value="<?=$activity['id']?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-4 text-center option">
                                <form action="/?page=admin&act=setActive" method="POST">
                                    <input type="hidden" name="id" value="<?=$activity['id'] ?>">
                                    <?php 
                                if ($activity["is_active"] == true) { ?>

                                    <button type="submit" class="text-primary btn-swip">
                                        <i class="bi bi-toggle2-on"></i>
                                    </button>
                                    <?php  } else {?>
                                    <button type="submit" class="text-dark btn-swip">
                                        <i class="bi bi-toggle2-off"></i>
                                    </button>
                                    <?php  }

                                ?>
                                </form>

                            </div>
                            <div class="col-4 text-center">
                                <form action="/?page=admin&act=deleteActivity" method="POST">
                                    <input type="hidden" name="id" value="<?=$activity['id'] ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
            ?>
        </div>
        <?php  } ?>
    </div>
</div>

<?php
    $content = ob_get_clean();
    
    $title = "Liste des événements réalisés par l'association michel archange zero chomage";
    require(ROOT . "/Views/template-admin.php");
?>
