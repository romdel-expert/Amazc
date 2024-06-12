<input type="hidden" name="id" value="<?= $id; ?>">
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

<div class="mb-3">
    <label for="address" class="form-label">Adresse</label>
    <input type="text" name="address" class="form-control" id="addressUpd" value="<?=$address ?>"
        aria-describedby="addressHelp" required>
</div>

<p class="text-danger mt-3 mb-3">
    <?= $msgUpdateUserError ?>
</p>
<div class="row">
    <div class="col-6 mt-4">
        <a class="btn-warning" href="/?page=acount&act=acount">Retour au profil</a>
    </div>
    <div class="col-6 mt-4">
        <button type="submit" class="btn-official">Enregistrer</button>
    </div>
</div>
