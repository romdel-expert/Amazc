<?php ob_start(); ?>

<div class="page-admin">

    <div class="top">
        <img src="../../../Assets/images/logo-transparent.png" alt="Logo de l'association Michel-Archange Zero Chomage">

        <h1 class="mt-3">Connexion administrateur</h1>
    </div>

    <form class="mt-3" action="/?page=acount&act=loginAdmin" method="POST">

        <div class="mb-3">
            <label for="emailLoginAdmin" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="emailLoginAdmin" value="<?= $emailLogin ?>"
                aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
            <label for="passwordLoginAdmin" class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" id="passwordLoginAdmin">
        </div>


        <div class="row mt-5">
            <div class="col-7">
                <a class="link" href="">Mot de passe oublié</a>
            </div>
            <div class="col-5">
                <a class="link" href="/?page=home&act=home">Retour sur le site</a>
            </div>
        </div>


        <p class="text-danger mt-3 mb-3">
            <?= $msgLoginError ?>
        </p>

        <button type="submit" class="btn-official mt-4">Connexion</button>
    </form>
</div>

<?php 

$content = ob_get_clean();

$title = "Formulaire de login de l'administreur";
require(ROOT . "/Views/template-admin.php");
?>
