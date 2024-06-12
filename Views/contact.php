<?php 
ob_start();
?>

<div class="content-page">
    <div class="mb-3">
        <label for="nameContact" class="form-label">Nom complet</label>
        <input type="text" name="nameContact" class="form-control" id="nameContact" aria-describedby="nameContacteHelp"
            required>
    </div>


    <div class="mb-3">
        <label for="subject" class="form-label">Sujet</label>
        <input type="text" name="subject" class="form-control" id="subject" aria-describedby="subjectHelp" required>
    </div>





    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="subject" class="form-control" id="subject" aria-describedby="subjectHelp" required>
    </div>




    <div class="mb-3">
        <label for="email" class="form-label">Téléphone</label>
        <input type="email" name="subject" class="form-control" id="subject" aria-describedby="subjectHelp" required>
    </div>


    <div class="mb-3">
        <label for="email" class="form-label">Votre message</label>
        <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea>
    </div>

    <button type="submit" class="btn-official mt-4">Envoyer</button>

</div>

<?php 
$content = ob_get_clean();
require(ROOT . "/Views/template.php");
?>
