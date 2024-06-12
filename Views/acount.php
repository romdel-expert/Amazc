<?php 

    ob_start();

?>

<div class="content-page">
    <?php 
        if (isset($_SESSION["user"]) && $_SESSION["user"]) {
            require(ROOT . "/Views/acount/profil.php");

            include("acount/options-user.php");
        } else {
            $emailLogin = "";
            if (!empty($_POST)) {
                $emailLogin = $_POST["email"];
            }else{
                $msgLoginError = "";
            }
            require(ROOT . "/Views/acount/login.php");
        }
        
     ?>
</div>


<?php 

    $content = ob_get_clean();
    require(ROOT . "/Views/template.php");
?>
