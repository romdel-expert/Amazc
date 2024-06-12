<?php 
ob_start();
?>

<div class="page">
    <div class="container" style="margin-top: 160px;margin-bottom: 60px;">
        <div class="mt-4 p-5 bg-white text-danger rounded">
            <h1>Erreur 404</h1>
            <p>
                Un problème est arrivé lors du lancement de votre requête
            </p>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require(ROOT ."/Views/template.php");
?>
