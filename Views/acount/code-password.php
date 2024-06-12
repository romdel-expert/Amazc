<?php 

ob_start(); 

?>


<div class="content-page">

    <div class="top">

        <h1 class="mt-3 mb-5">Code de réinitialisation</h1>
        <p style="color: rgba(0, 0, 0, .7); font-size:90%">Entrer le code que vous avez reçu dans votre boite e-mail</p>
    </div>

    <form class="mt-3" action="/?page=acount&act=checkCode" method="POST">

        <div class="mb-3">
            <label for="codePw" class="form-label">Code</label>
            <input type="text" name="code" class="form-control" id="codePw" value="<?= $codePw ?>"
                aria-describedby="codeHelp" required>
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
            <?= $msgCodePw ?>
        </p>

        <div class="row">
            <div class="col-6  mt-4">
                <a class="btn btn-warning" href="/?page=acount&act=emailPw">Retour</a>
            </div>
            <div class="col-6 mt-4">
                <button type="submit" class="btn-official">Vérifier</button>
            </div>
        </div>
    </form>
</div>



<?php 

$content = ob_get_clean(); 
$title = "Forfulaire du code de reinitialisation du mot de passe";
require(ROOT . "/Views/template.php");
?>
