<?php 

ob_start(); 

?>


<div class="content-page">

    <div class="top">

        <h1 class="mt-3 mb-5">Récupération du mot de passe</h1>
    </div>

    <form class="mt-3" action="/?page=acount&act=createCode" method="POST">

        <div class="mb-3">
            <label for="emailPw" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="emailPw" value="<?= $emailPw ?>"
                aria-describedby="emailHelp" required>
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
            <?= $msgEmailPw ?>
        </p>
        <button type="submit" class="btn-official mt-4">Envoyer</button>
    </form>
</div>



<?php 

$content = ob_get_clean(); 
$title = "Forfulaire e-mail pour le code de reinitialisation du mot de passe";
require(ROOT . "/Views/template.php");
?>
