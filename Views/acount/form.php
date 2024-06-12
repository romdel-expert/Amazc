<div class="mb-3">
    <label for="f_name" class="form-label">Prénom</label>
    <input type="text" name="f_name" class="form-control" id="f_name" value="<?=$fName ?>" aria-describedby="fnameHelp"
        required>
</div>

<div class="mb-3">
    <label for="l_name" class="form-label">Nom</label>
    <input type="text" name="l_name" class="form-control" id="l_name" value="<?=$lName ?>" aria-describedby="lnameHelp"
        required>
</div>

<div class="mb-3">
    <label for="genre" class="form-label">Genre</label>
    <select name="genre" class="form-control" id="genre" aria-describedby="genreHelp" required>

        <?php
            if ($genre == "Monsieur") { ?>
        <option value="Monsieur" selected>Monsieur</option>
        <option value="Madame">Madame</option>
        <?php }elseif ($genre == "Madame") { ?>
        <option value="Monsieur">Monsieur</option>
        <option value="Madame" selected>Madame</option>
        <?php }else{ ?>
        <option value="" disabled selected>Choisir votre genre</option>
        <option value="Monsieur">Monsieur</option>
        <option value="Madame">Madame</option>
        <?php }
        ?>
    </select>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" id="email" value="<?=$email ?>" aria-describedby="emailHelp"
        required>
</div>

<div class="mb-3">
    <label for="phone" class="form-label">Téléphone mobile</label>
    <input type="tel" name="phone" class="form-control" id="phone" value="<?=$phone ?>" aria-describedby="phoneHelp"
        required>
</div>

<script>
var input1 = document.getElementById('address1');
var autocomplete = new google.maps.places.Autocomplete(input1);
</script>

<div class="mb-3">
    <label for="address1" class="form-label">Adresse</label>
    <input type="text" name="address" class="form-control" id="address1" value="<?=$address ?>"
        aria-describedby="addressHelp" required>
</div>


<div class="mb-3">
    <label for="password1" class="form-label">Entrer un mot de passe</label>
    <input type="password" name="password1" class="form-control" id="password1" aria-describedby="password1Help"
        required>
</div>

<div class="mb-3">
    <label for="password2" class="form-label">Confirmer le mot de passe</label>
    <input type="password" name="password2" class="form-control" id="password2" aria-describedby="password2Help"
        required>
</div>

<div class="row mt-5">
    <div class="col-7">
        <a class="link" href="/?page=acount&act=emailPw">Mot de passe oublié</a>
    </div>
    <div class="col-5">
        <a class="link" href="/?page=acount&act=acount">Connexion</a>
    </div>
</div>

<p class="text-danger mt-3 mb-3">
    <?= $msgSubscribeError ?>
</p>
<button type="submit" class="btn-official mt-4">Enregistrer</button>
