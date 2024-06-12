<?php 

include(ROOT ."/Views/partials/header.php"); 
include(ROOT ."/Views/admin/menu.php");

if (isset($_SESSION["admin"]) && $_SESSION["admin"]) { ?>

<div class="left-page">

    <h1 class="mt-5 mb-4">
        Les domaines d'intervention
        &nbsp;&nbsp;
        <a class="btn-official" href="/admin/addDomain">
            <i class="bi bi-plus-lg"></i>
        </a>
    </h1>

    <div class="row">
        <div class="col-xxl-3 col-xl-4 col-sm-6 p-1">
            <?php include(ROOT . "/Views/comon/domain.php"); ?>
        </div>
    </div>
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
