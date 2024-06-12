<?php 
ob_start(); 
?>

<div class="container-fluid page">

    <h1>Donation</h1>

    <div class="row">


        <div class="col-md-6 mt-4">
            <div class="mt-3">
                <div class="mt-4 bg-white p-4 text-gray">

                    <h2>Nous soutenir</h2>
                    <p>
                        Vos sont précieux pour nous aider à surmonter tous les obstacles afin de venir en aide à ceux
                        qui en ont besoin
                    </p>

                    <p>
                        Pour nous permettre de vous remercierpersonnellement et gracieusement,n'oubliez pas à nous
                        laisser vosinformations de contact
                    </p>



                    <form class="bg-white p-4" action="/?page=donation&act=create" method="POST">

                        <h2 class="mb-4 mt-5">A propis de votre don</h2>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Montant*</label>
                            <input type="number" name="amount" min="10" class=" form-control" id="amount"
                                aria-describedby="numericHelp" value="<?= $amount?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nameDonation" class="form-label">Nom complet*</label>
                            <input type="text" name="nameDonation" class="form-control" id="nameDonation"
                                aria-describedby="nameDonationHelper" value="<?= $nameDonation; ?>" required>
                        </div>


                        <div class="mb-3">
                            <label for="emailDonation" class="form-label">Email*</label>
                            <input type="email" name="emailDonation" class="form-control" id="emailDonation"
                                aria-describedby="emailDonationHelp" value="<?= $emailDonation; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="phoneDonation" class="form-label">Téléphone*</label>
                            <input type="tel" name="phoneDonation" class="form-control" id="phoneDonation"
                                aria-describedby="subjectHelp" value="<?= $phoneDonation; ?>" required>
                        </div>


                        <div class="mb-3">
                            <label for="messageDonation" class="form-label">Laissez-nous quelques mots</label>
                            <textarea class="form-control" name="messageDonation" id="messageDonation" cols="30"
                                rows="10"><?= $messageDonation; ?></textarea>
                        </div>

                        <p class="text-danger mt-3 mb-3">
                            <?= $msgErrDonation; ?>
                        </p>

                        <div class="mt-4">
                            <button type="submit" class="btn-official">Effectuer un don</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-6 mt-4">
            <div class="mt-3">
                <div class="mt-4 bg-white p-4 text-gray">

                    <h2>Effectuer un virement</h2>
                    <p>
                        Vous pouvez effectuer vos dons par virement bancaire
                    </p>
                    <p>
                        <b>
                            IBAN : FR7616958000016255858302266
                            <br>
                            BIC : QNTOFRP1XXX
                        </b>
                    </p>
                    <p>
                        ASSOCIATION MICHEL ARCHANGE ZERO CHOMAGE (AMAZC)
                    </p>
                    <p>
                        2 RUE FONTAINE ST NICOLAS
                        <br>
                        95500 GONESSE - FR
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean();
require(ROOT . "/Views/template.php");
 ?>
