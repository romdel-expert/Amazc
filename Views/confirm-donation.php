<?php 

    ob_start();

?>

<div class="container-fluid page" style="margin-top: 160px;margin-bottom: 60px;">
    <div class="mt-4 p-5 bg-success text-white rounded">
        <h1 class="text-white">Paiement réussi</h1>
        <p>
            Nous vous remercions infiniment pour votre générosité
        </p>
    </div>
</div>

<?php 

    $content = ob_get_clean();
    require(ROOT . "/Views/template.php");
?>
