<?php 
    ob_start();
?>

<div class="page-admin-full">

    <a class="btn-official fix-position" href="/?page=admin&act=formDomain">
        <i class="bi bi-plus-lg"></i>
        &nbsp;
        Ajouter un domaine
    </a>

    <?php 
    if ($msgDomainError) {?>
    <div class="alert <?= $class ?>" role="alert">
        <?= $msgDomainError ?>
    </div>
    <?php }
    ?>

    <div class="container-fluid">
        <?php 
        if (!$listDomains) {
            
        } else {  ?>
        <div class="row">
            <?php 
            foreach ($listDomains as $domain) { ?>
            <div class="col-xxl-2 col-xl-3 col-lg-4 col-md-6 col-sm-6 p-1">
                <div class="activity">
                    <?php include(ROOT . "/Views/comon/domain.php")?>
                    <div class="p-1">
                        <div class="row">
                            <div class="col-4 text-center">
                                <form action="/?page=admin&act=formDomainUpd" method="POST">
                                    <input type="hidden" name="id" value="<?=$domain['id']?>">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-4 text-center option">
                                <form action="/?page=admin&act=setActiveDomain" method="POST">
                                    <input type="hidden" name="id" value="<?=$domain['id'] ?>">
                                    <?php 
                                if ($domain["is_active"] == true) { ?>

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
                                <form action="/?page=admin&act=deleteDomain" method="POST">
                                    <input type="hidden" name="id" value="<?=$domain['id'] ?>">
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
    
    $title = "Liste des domaines d'intervention de l'association michel archange zéro chômage";
    require(ROOT . "/Views/template-admin.php");
?>
