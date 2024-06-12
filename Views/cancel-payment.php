<?php 

    ob_start();

?>

<div class="container" style="margin-top: 160px;margin-bottom: 60px;">
    <div class="mt-4 p-5 bg-white text-danger rounded">
        <h1>Paiement annulé</h1>
        <p>
            Votre paiement a été annulé ou refusé. Vous pouvez à tout moment renouveler votre paiement
        </p>
        <p>
            Si vous êtes membre adhérent, vous pouvez effectuer votre cotisation annulelle depuis&nbsp;
            <a href="/acount/acount">Votre espace</a>
        </p>
        <p>
            Vous êtes donneur ou partenaire ou membre adhérent vous pouvez également faire un don
        </p>

        <p class="mt-5">
            <a class="btn-official" href="/donation/form">Je fais un don</a>
        </p>
    </div>
</div>


<?php 

    $content = ob_get_clean();
    require(ROOT . "/Views/template.php");      
?>
