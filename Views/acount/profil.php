<h1>Profil adhérent</h1>

<div class="mt-3">

    <?php 
    if (
        $_SESSION["user"]["is_rules"] 
        && $_SESSION["user"]["contribution"] 
        && date_create($_SESSION["user"]["contribution"]["date_exp"]) >= date_create(date('Y-m-d H:i:s'))
    ) { ?>
    <div class="row">
        <div class="col-12 mb-3">
            <p class="p-2" style="background-color: rgb(25, 135, 84); color:#ffffff; font-size: 80%;">
                Vous êtes en règle jusqu'au
                <?= date_format(date_create($_SESSION["user"]["contribution"]["date_exp"]), 'd/m/Y à H:i:s') ?>
            </p>
        </div>
    </div>
    <?php } else { ?>
    <div class="row">
        <div class="col-sm-8 mb-3">
            <p class="danger p-2" style="background-color: rgb(217, 52, 68); color:#ffffff; font-size: 80%;">
                Vous n'êtes pas en règle
            </p>
        </div>

        <div class="col-sm-4 mb-3 mt-2">

            <a href="https://www.paypal.com/donate/?hosted_button_id=A6M9CQEMT6K4U" class="btn-official">
                <i class="bi bi-currency-euro"></i>
                &nbsp;
                Régulariser
            </a>
        </div>
    </div>
    <?php } ?>

</div>

<table class="table table-success table-striped mt-2">
    <tbody>
        <tr>
            <td>Prénom</td>
            <td>
                <?= $_SESSION["user"]["f_name"] ?>
            </td>
        </tr>


        <tr>
            <td>Nom</td>
            <td>
                <?= $_SESSION["user"]["l_name"] ?>
            </td>
        </tr>


        <tr>
            <td>Genre</td>
            <td>
                <?= $_SESSION["user"]["genre"] ?>
            </td>
        </tr>


        <tr>
            <td>E-mail</td>
            <td>
                <?= $_SESSION["user"]["email"] ?>
            </td>
        </tr>


        <tr>
            <td>Téléphone</td>
            <td>
                <?= $_SESSION["user"]["phone"] ?>
            </td>
        </tr>


        <tr>
            <td>Adresse</td>
            <td>
                <?php
                
                if (isset($_SESSION["user"]["address"])) {
                    $address = $_SESSION["user"]["address"]["format_address"];
                } else {
                    $address = "Adresse";
                }
                
                ?> <?= $address ?>
            </td>
        </tr>


        <tr>
            <td>Grade</td>
            <td>
                <?= $_SESSION["user"]["grade"] ?>
            </td>
        </tr>
    </tbody>
</table>
