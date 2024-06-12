<?php 

include(ROOT ."/Views/partials/header.php"); 
include(ROOT ."/Views/admin/menu.php");

if (isset($_SESSION["admin"]) && $_SESSION["admin"]) { ?>

<div class="left-page">

    <h1 class="mt-5 mb-4">
        Créer un domaine d'intervention
    </h1>

    <?php include(ROOT . "/Views/admin/pages/form-domain.php")?>
</div>
<?php } else {
$emailLogin = "";
if (!empty($_POST)) {
$emailLogin = $_POST["email"];
}else{
$msgLoginError = "";
}
require ("login.php");
}

include(ROOT ."/Views/partials/footer.php")


?>
