<?php 
    ob_start();
    
    

    $content = ob_get_clean();
    
    $title = "Page d'accueil de l'espace administrateur";
    require(ROOT . "/Views/template-admin.php");
?>
