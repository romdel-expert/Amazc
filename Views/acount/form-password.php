<?php 

ob_start(); 

?>


<div class="content-page">

    <div class="top">

        <h1 class="mt-3 mb-5">Nouveau mot de passe</h1>
    </div>

    <form class="mt-3" action="/?page=acount&act=savePw" method="POST">

        <div class="mb-3">
            <label for="newPw1" class="form-label">Nouveau mot de passe</label>
            <input type="password" name="pw1" class="form-control" id="newPw1" value="<?= $pw1 ?>"
                aria-describedby="pw1Help" required>
        </div>


        <div class="mb-3">
            <label for="newPw2" class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="pw2" class="form-control" id="newPw2" value="<?= $pw2 ?>"
                aria-describedby="pw2Help" required>
        </div>


        <div class="row mt-5">
            <div class="col-7">
                <a class="link" href="/?page=acount&act=login">Connexion</a>
            </div>
            <div class="col-5">
                <a class="link" href="/?page=membership&act=formCreate">Inscription</a>
            </div>
        </div>

        <p class="text-danger mt-3 mb-3">
            <?= $msgPw ?>
        </p>

        <div class="row">
            <div class="col-6  mt-4">
                <a class="btn btn-warning" href="/?page=acount&act=codePw">Retour</a>
            </div>
            <div class="col-6 mt-4">
                <button type="submit" class="btn-official">Enregistrer</button>
            </div>
        </div>
    </form>
</div>



<?php 

$content = ob_get_clean(); 
$title = "Forfulaire du code de reinitialisation du mot de passe";
require(ROOT . "/Views/template.php");
?>
