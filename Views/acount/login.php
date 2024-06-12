<div class="top">

    <h1 class="mt-3 mb-5">Connexion</h1>
</div>

<form class="mt-3" action="/?page=acount&act=login" method="POST">

    <div class="mb-3">
        <label for="emailLogin" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="emailLogin" value="<?= $emailLogin ?>"
            aria-describedby="emailHelp">
    </div>

    <div class="mb-3">
        <label for="pwLogin" class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" id="pwLogin">
    </div>

    <div class="row mt-5">
        <div class="col-7">
            <a class="link" href="/?page=acount&act=emailPw">Mot de passe oublié</a>
        </div>
        <div class="col-5">
            <a class="link" href="/?page=membership&act=formCreate">Inscription</a>
        </div>
    </div>

    <p class="text-danger mt-3 mb-3">
        <?= $msgLoginError ?>
    </p>
    <button type="submit" class="btn-official mt-4">Connecter</button>
</form>
