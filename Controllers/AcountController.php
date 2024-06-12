<?php
namespace Controllers;

use Models\AddressModel;
use Models\DataManager;
use Models\DonationModel;
use Models\UserModel;

require_once (ROOT ."/Models/AddressModel.php");
require_once (ROOT ."/Models/UserModel.php");
require_once (ROOT ."/Models/DonationModel.php");

class AcountController{


    private $userModel;
    private $adrModel;
    private $donationModel;
    
    public function __construct(){
        $this->userModel = new UserModel();
        $this->adrModel = new AddressModel();
        $this->donationModel = new DonationModel();
    }
    
    /**
     * Cette methode sert à récupérer le profil de l'utilisateur dont la 
     * session est en cours Via l'id de l'utilisateur stocké en session on 
     * recupère l'utilisateur
     * 
     * Cette methode n'a pas de valeur/type de retour et n'attend pas non 
     * plus de valeur d'entrée
     *
     * @return void
     */
    public function acount(){
        if (isset($_SESSION["user"])) {
            if (isset($_SESSION["user"]["id"])) {
                $idUser = $_SESSION["user"]["id"];
                $user = $this->userModel->findUserById($idUser);
                
                $_SESSION["user"] = $this->setUser($user);
            }
        }
        $title = "Espace de membre";
        require(ROOT . "/Views/acount.php");
    }


    public function create(){
        $title = "Formulaire d'inscription";
        require(ROOT . "/Views/subscribe.php");
    }

    /**
     * Cette methode sert à afficher le formulaire de modification d'un 
     * utilisateur.
     * On verifie si la session est en cours, si oui on récupère l'utilisateur
     * via le model en utilisant son id
     * sinon on redirige vers la page de connexion
     *
     * @return void
     */
    public function updateForm(){
        if (!isset($_SESSION["user"])) {
            $msgLoginError = "Vous êtes déconnecté(e)";
            $title = "Formulaire de connexion";
            require(ROOT . "/Views/acount.php");
            exit();
        }

        $user = $this->userModel->findUserById($_SESSION["user"]["id"]);
        if (!$user) {
            $msgLoginError = "Cet utilisateur n'existe pas";
            $title = "Formulaire de connexion";
            require(ROOT . "/Views/acount.php");
            exit();
        }

        $user["address"] = $this->adrModel->findAddresseByUser($user["id"]);
        $fName = $user["f_name"];
        $lName = $user["l_name"];
        $genre = $user["genre"];
        $email = $user["email"];
        $phone = $user["phone"];
        $address = $user["address"]["format_address"];
        $id = $user["id"];
        
        $msgUpdateUserError = "";
        $title = "Modification du profil";
        require(ROOT . "/Views/acount/update-acount.php");
    }


    /**
     * Cette methode sert à gerer la mise en session d'un utilisateur et faisant 
     * appel à la methode du model permettant de récupérer l'utilisateur par son 
     * email et son mot de passe
     * 
     * On recupère l'email et le mot de passe depuis le formulaire puis appeler 
     * la methode du modele avec les informations attendues
     *
     * @return void
     */
    public function login(){
        
        if (empty($_POST)) {
            $msgLoginError = "Il faut renseigner votre email et votre mot de passe";
            $title = "Formulaire de connexion";
            require(ROOT . "/Views/acount.php");
            exit();
        }
        
        $user = $this->userModel->findUserByEmailAnPassword($_POST["email"], $_POST["password"]);
        if (!$user) {
            $msgLoginError = "E-mail et/ou mot de passe incorrect(s)";
            $emailLogin = $_POST["email"];
            $title = "Formulaire de connexion";
            require(ROOT . "/Views/acount.php");
            exit();
        }

        if (!$user["is_active"]) {
            $msgLoginError = "Votre compte n'est plus actif. Veuillez contacter l'administration pour l'activation de votre compte";
            $emailLogin = $_POST["email"];
            session_destroy();
            $title = "Formulaire de connexion";
            require(ROOT . "/Views/acount.php");
            exit();
        }
        
        $msgLoginError = "";
        
        $_SESSION["user"] = $this->setUser($user);;
        $title = "Espace de membre";
        require(ROOT . "/Views/acount.php");
    }






    /**
     * Cette methode sert à gerer la mise en session d'un utilisateur et faisant 
     * appel à la methode du model permettant de récupérer l'utilisateur par son 
     * email et son mot de passe
     * 
     * On recupère l'email et le mot de passe depuis le formulaire puis appeler 
     * la methode du modele avec les informations attendues
     *
     * @return void
     */
    public function loginAdmin(){
        
        if (empty($_POST)) {
            $msgLoginError = "Il faut renseigner votre email et votre mot de passe";
            $title = "Connexion administrateur";
            require(ROOT . "/Views/admin/pages/login.php");
            exit();
        }
        
        $user = $this->userModel->findUserByEmailAnPassword($_POST["email"], $_POST["password"]);
        if (!$user) {
            $msgLoginError = "E-mail et/ou mot de passe incorrect(s)";
            $emailLogin = $_POST["email"];
            $title = "Connexion administrateur";
            require(ROOT . "/Views/admin/pages/login.php");
            exit();
        }

        if ($user["grade"] != strtoupper("admin")) {
            $msgLoginError = "Vous n'avez pas le droit d'accès à cet espace";
            $emailLogin = $_POST["email"];
            $title = "Connexion administrateur";
            require(ROOT . "/Views/admin/pages/login.php");
            exit();
        }
        $msgLoginError = "";
        $_SESSION["admin"] = $user;
        $title = "Espace administrateur";
        require(ROOT . "/Views/admin/pages/home.php");
    }

    


    /**
     * Cette methode sert à gerer la deconnexion de l'utilisateur dont 
     * la session est en cours on detruit egalement toutes les sessions en cours
     * 
     * Cette methode ne retourne rien et l'utilisateur est redirigé vers la 
     * page de connexion
     *
     * @return void
     */
    public function logout(){
        
        session_destroy();
        $_SESSION["user"] = null;
        $msgLoginError = "";
        $title = "Formulaire de connexion";
        require(ROOT . "/Views/acount.php");
    }

    


    /**
     * Cette methode sert à gerer la deconnexion de l'utilisateur de type admin dont 
     * la session est en cours on detruit egalement toutes les sessions en cours
     * 
     * Cette methode ne retourne rien et l'utilisateur est redirigé vers la 
     * page de connexion
     *
     * @return void
     */
    public function logoutAdmin(){
        
        session_destroy();
        $_SESSION["admin"] = null;
        $msgLoginError = "";
        $emailLogin = "";

        require(ROOT . "/Views/admin/pages/login.php");
    }



    /**
     * Cette methode permet de declare un ustilisateur comme etant en regle
     * c'est à dire d'appler la methode qui sert à modifier l'utilisateur dans 
     * la base de données en mettant la valeur de la colonne is_rules à true
     * 
     * Cette methode n'attend pas de valeur d'entrée. Elle recupère la session 
     * en cours de l'utilisateur et récupere l'id de l'utilisateur pour faciliter
     * le traitement et effectuer la tache demander
     * 
     * Dans tous les cas l'utilisarteur est redirigé vers la page de profil
     *
     * @return void
     */
    public function rules(){
        
        if (isset($_SESSION["user"])) {
            if (isset($_SESSION["user"]["id"])) {
                $idUser = $_SESSION["user"]["id"];
                
                $newUser = $this->userModel->updateRulesUser($idUser, true);
                
                $_SESSION["user"] = $this->setUser($newUser);
            }
        }
        $title = "Espace de membre";
        require(ROOT . "/Views/acount.php");
    }



    /**
     * Cette methode permet d'afficher la page d'annulation d'un paiement en cours
     * La methode n'attend aucun parametre d'entrée et ne retourne rien
     * 
     * Mais envoie la page à afficher
     *
     * @return void
     */
    public function cancelPayment(){
        $title = "Annulation de paiement";
        require(ROOT . "/Views/cancel-payment.php");
    }




    /**
     * Cette methode sert à s'occuper de la construction complete du tableau 
     * contenant les informations concernant un utilisateur
     *
     * @param array $user
     * @return array
     */
    private function setUser(array $user):array{

        if (!$user) {
            return [];
        }
        $user["address"] = $this->adrModel->findAddresseByUser($user["id"]);
        $user["contribution"] = $this->donationModel->findContributionByUser($user["id"]);

        return $user;
    }




    /**
     * Cette mthode sert à afficher la page permettant de d'entrer le code de 
     * reinitialisation pour le mot de passe de l'utilisateur lors du processus 
     * de réinitialisation
     *
     * @return void
     */
    public function codePw(){
        
        $msgCodePw = "";
        $codePw = "";
        
        require(ROOT . "/Views/acount/code-password.php");
    }




    /**
     * Cette methode permet d'afficher le formulaire permettant à 
     * l'utilisateur de renseigner son adresse email lors de la 
     * reiitialisation de son mot de passe
     *
     * @return void
     */
    public function emailPw(){
        
        $emailPw = "";
        $msgEmailPw = "";
        require(ROOT . "/Views/acount/email-password.php");
    }



    /**
     * Cette methode permet de récupérer l'email de l'utilisateur, verfier la valeur de l'email
     * verifier l'existance de l'utilisateur lié à l'adresse e-mail. 
     * 
     * Si l'utilisateur existe, on cree le code et l'enregistrer dans la base de données
     * puis envoyer le code par email
     * 
     * si l'utilisateur n'existe pas, on envoi un message d'erreur pour notifier l'utilisateur
     * que l'email ne correspond à aucun utilisateur
     *
     * @return void
     */
    public function createCode(){


        $newCode = [];
        
        if (empty($_POST)) {
            $msgEmailPw = "Veuiller renseigner votre adresse e-mail";
            $emailPw = "";
            require(ROOT . "/Views/acount/email-password.php");
            exit();
        }


        $email = $_POST["email"];
        
        $user = $this->userModel->findUserByEmail($email);
        if (!$user) {
            $msgEmailPw = "Aucun utilisateur ne correspond à cet e-mail";
            $emailPw = $_POST["email"];
            require(ROOT . "/Views/acount/email-password.php");
            exit();
        }


        $code = DataManager::constructCode();
        if (!$code) {
            $msgEmailPw = "Le code de réinitialisation n'a pas été généré et envoyé par email";
            $emailPw = $_POST["email"];
            require(ROOT . "/Views/acount/email-password.php");
            exit();
        }
        
        $existedCode = $this->userModel->findCodeByEmail($email);
        if (!$existedCode) {
            $newCode = $this->userModel->createCodePassword($email, $code);
        }else{
            $newCode = $this->userModel->updateCodePassword($email, $code);
        }
        
        if (!$newCode) {
            $msgEmailPw = "Le code de réinitialisation n'a pas été enregistré";
            $emailPw = $_POST["email"];
            require(ROOT . "/Views/acount/email-password.php");
            exit();
        }
        
        $to = $email;
        $subject = "Votre code de réinitialisation pour votre mot de passe";
        $message = 
            "Bonjour " . $user["genre"] . " " . $user["l_name"] . "<br><br>"
            ."Suite à votre demande de réinitialisation de mot de passe, nous avons le plaisir de vous 
                communiquer votre code de réinitialisation pour votre mot de passe" . "<br><br>"
            ."<h1>" . $newCode["code"] . "<h1>" . "<br><br>"
            ."Nous vous remercions pour votre confiance" . "<br><br>"
            ."Administration AMZC <br>"
            ."Association Michel Archange Zéro Chômage";
        
        if (!DataManager::sendContactEmail($to, $subject, $message)) {
            $newCode = $this->userModel->createCodePassword($email);
            if (!$newCode) {
                $msgEmailPw = "Le code de réinitialisation ne vous a pas été envoyé";
                $emailPw = $_POST["email"];
                require(ROOT . "/Views/acount/email-password.php");
                exit();
            }
        }

        $_SESSION["email"] = $email;
        
        $msgEmailPw = "";
        $msgCodePw = "";
        $codePw = "";
        require(ROOT . "/Views/acount/code-password.php");
    }





    /**
     * Cette methode sert à vérifier le code entré par l'utilisateur lors du processu 
     * de reinitialisation de son mot de passe
     * 
     * Lors de la vérification on récupère le code lié à l'utilisateur dans la bse de données
     * on compare le code avec celui entré par l'utilisateur, si different on lui informe
     * que le code n'est pas reconnu, si equi valent on compare sa date d'expiration avec celle
     * d'aujourd'hui pour savair si le delai de est dépassé afin de lui demander de tout recommancer
     * 
     * On part avec l'hypothèse que le code doit être utilisé dans un delai de 24h
     *
     * @return void
     */
    public function checkCode(){
        
        if (empty($_POST)) {
            $msgCodePw = "Tableau de la requête vide";
            $codePw = "";
            require(ROOT . "/Views/acount/code-password.php");
            exit();
        }

        if (!isset($_SESSION["email"])) {
            $msgEmailPw = "Veuiller renseigner votre adresse e-mail";
            $emailPw = "";
            require(ROOT . "/Views/acount/email-password.php");
            exit();
        }

        $codeData = $this->userModel->findCodeByEmail($_SESSION["email"]);
        if (!$codeData) {
            $msgCodePw = "Aucun code ne correspond à votre adresse e-mail";
            $codePw = $_POST["code"];
            require(ROOT . "/Views/acount/code-password.php");
            exit();
        }

        if ($codeData["code"] != $_POST["code"]) {
            $msgCodePw = "Vous avez entré un faux code";
            $codePw = $_POST["code"];
            require(ROOT . "/Views/acount/code-password.php");
            exit();
        }


        $dateExp = $codeData["date_exp"];
        
        if (date_create(date('Y-m-d H:i:s')) > date_create($dateExp)) {
           $msgCodePw = "Votre code a expiré, veuillez recommencer";
            $codePw = $_POST["code"];
            require(ROOT . "/Views/acount/code-password.php");
            exit();
        }

        $msgPw = "";
        $pw1 = $pw2 = "";
        require(ROOT . "/Views/acount/form-password.php");
    }




    /**
     * Cette methode permet de mettre à jour le mot de passe d'un utilisateur.
     * Elle verifie le contenu du tableau post, comparer les mots de passe afin de s'assurer que
     * l'utilisateur a bien confirmaer le mot de passe
     * 
     * on verifie que le mot de passe est bien selon la norme définie et si tout va bien on appelle
     * la methode de mise à jour du mot de passe et on redige l'utilisateur vers son espace, 
     * 
     * sionon on envoie le message d'erreur pour prévenir 
     * l'utilisateur de ce qui ne va pas tout en restant sur le meme form
     *
     * @return void
     */
    public function savePw(){
        
        if (empty($_POST)) {
            $msgPw = "Tableau de la requête vide";
            $pw1 = "";
            $pw2 = "";
            require(ROOT . "/Views/acount/form-password.php");
            exit();
        }

        
        if (!isset($_POST["pw1"]) || !isset($_POST["pw2"])) {
            $msgPw = "Veuillez fournir et confirmer le nouveau mot de passe";
            $pw1 = "";
            $pw2 = "";
            require(ROOT . "/Views/acount/form-password.php");
            exit();
        }

        $pw1 = $_POST["pw1"];
        $pw2 = $_POST["pw2"];
        if ($pw1 != $pw2) {
            $msgPw = "Les mots de passe ne sont pas identiques";
            $pw1 = "";
            $pw2 = "";
            require(ROOT . "/Views/acount/form-password.php");
            exit();
        }

        if (strlen($pw1) < 8) {
            $msgPw = "Le mot de passe doit contenir au moins 8 caractères";
            $pw1 = "";
            $pw2 = "";
            require(ROOT . "/Views/acount/form-password.php");
            exit();
        }

        if (isset($_SESSION["email"]) < 8) {
            $msgEmailPw = "Adresse e-mail inconnu";
            $email = "";
            require(ROOT . "/Views/acount/email-password.php");
            exit();
        }

        $user = $this->userModel->updatePassword($_SESSION["email"], $pw1);
        if (!$user) {
            $msgLoginError = "Votre mot de passe n'a pu être modifié";
            $emailLogin = "";
            $title = "Formulaire de connexion";
            require(ROOT . "/Views/acount.php");
            exit();
        }

        if (!$user["is_active"]) {
            $msgLoginError = "Votre compte n'est plus actif. Veuillez contacter l'administration pour l'activation de votre compte";
            $emailLogin = "";
            session_destroy();
            require(ROOT . "/Views/acount.php");
            exit();
        }
        
        
        $_SESSION["user"] = $this->setUser($user);;
        $title = "Espace de membre";
        require(ROOT . "/Views/acount.php");
    }
}
