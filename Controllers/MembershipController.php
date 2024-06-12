<?php
namespace Controllers;

require_once (ROOT ."/Models/UserModel.php");
require_once (ROOT ."/Models/AddressModel.php");
require_once (ROOT ."/Models/DonationModel.php");

use Models\AddressModel;
use Models\DataManager;
use Models\DonationModel;
use Models\UserModel;

class MembershipController{
    
    private $userModel;
    private $adrModel;
    private $donationModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->adrModel = new AddressModel();
        $this->donationModel = new DonationModel();
    }

    /**
     * Cette mzthode sert à envoyer la page qui affiche le formulaire d'inscription 
     * pour un nouveau membre. Cette methode ne prend pas de paramètre et n'a pas non 
     * plus de valeure de retour.
     *
     * @return void
     */
    public function formCreate(){
        $params = $_POST;
        $msgSubscribeError = "";
        $this->setContentFormUser($params, $msgSubscribeError);
    }

    /**
     * Cette methode sert à récupérer les données venant du formulaire d'inscription
     * verifier les données et proceder à l'enregistrement des données dans la base 
     * de données
     * 
     * cette methode effectue les différents traitement et envoie la vue appropriée
     * à l'utilisateur afin qu'il puisse observer le résultat
     *
     * @return void
     */
    public function create(){
        
        $msgSubscribeError = "";
        if (!empty($_POST)) {
            if ($_POST["password1"] != $_POST["password2"]) {
                $msgSubscribeError = "Les mots de passe ne sont pas identiques";
                $this->setContentFormUser($_POST, $msgSubscribeError);
                exit();
            }elseif ($_POST["password1"] == $_POST["password2"]) {
                if (strlen($_POST["password1"]) < 8) {
                    $msgSubscribeError = "Le mot mot de passe doit contenir au moins 8 caractères";
                    $this->setContentFormUser($_POST, $msgSubscribeError);
                    exit();
                }
                
                if ($this->userModel->findUserByEmail($_POST["email"])) {
                    $msgSubscribeError = "Cet e-mail est déjà utilisé par un autre utilisateur";
                    $this->setContentFormUser($_POST, $msgSubscribeError);
                    exit();
                }
                
                $newUser = $this->userModel->createUser($_POST);
                if (!$newUser) {
                    $msgSubscribeError = "Un problème est survenu lors de l'enregistrement du nouveau membre";
                    $this->setContentFormUser($_POST, $msgSubscribeError);
                    exit();
                }
                $address = DataManager::getInfosAddress($_POST["address"]);
                if ($address) {
                    $address["id_user"] = $newUser["id"];
                }
                unset($_POST);
                $_POST = array();  
                $newUser["address"] = $this->adrModel->createAddress($address);
                $_SESSION["user"] = $newUser;
                
                $title = "Espace de membre";
                
                require (ROOT . "/Views/acount.php");
            }
        } else {
           
            $msgSubscribeError = "Il faut que tous les champs obligatoires soient bien remplis";
            $this->setContentFormUser($_POST, $msgSubscribeError);
        }
    }


    /**
     * Cette methode sert à récupérer les données du tableau $_POST et en fonction des valeurs
     * on initialise les champs
     * 
     * cella parmet d'eviter à l'utilisateur de remplir à nouveau les champs suite à l'affichage 
     * d'un message d'erreur car car après chaque envoi du formulaire les champs sont vidés mais
     * le contenu du tablea $_POST est stocké en memoire
     * 
     * On remet les valeurs aux champs grance au contenu du tableau
     * 
     * Cette methode attend comme paramètre d'entrée le tableau contenant les données, et la chsine
     * de caractères du message d'erreur. Elle ne retourne pas de valeur en d'autres termes
     * le type de retour est void
     *
     * @param array $params
     * @param string $errMsg
     * @return void
     */
    private function setContentFormUser(array $params, string $errMsg){
        
        $fName = "";
        $lName = "";
        $genre = "";
        $email = "";
        $phone = "";
        $address = "";
            
        if (!empty($params)) {
            // DataManager::setDataUser($params);
            $fName = $params['f_name'];
            $lName = $params['l_name'];
            $genre = $params['genre'];
            $email = $params['email'];
            $phone = $params['phone'];
            $address = $params['address'];
        }
        
        $msgSubscribeError = $errMsg;
        $title = "Formualaire d'inscription";
        require(ROOT . "/Views/membership.php");
    }



    /**
     * Cette methode permet de mettre à jour le profil d'un utilisateur.
     * Lors de cette mise à jour on prend également en compte la mise à jour 
     * de l'adresse de l'utilisateur.
     * 
     * Lors de ce processus on verifie si la nouvelle adresse est identique à 
     * l'adresse actuelle si telle est le cas on ne fait rien
     * sinon on verifie si un autre utilisateur autre que l'utilisateur actuelle 
     * nest pas déjà inscrit avec la meme adresse email. Si c'est le cas on refuse 
     * la mise en précisant que l'adresse email est deja utilisé par un autre utilisateur
     * 
     * Selon la restriction deux utilisateurs différents ne peuvent pas avoir la meme 
     * adresse email car un email est unique
     * 
     * Cette methode ne prend pas de valeur d'entrée et retourne l'utilisateur 
     * mis à jour sous forme d'un tablea array
     *
     * @return array
     */
    public function update():array{
        
        if (empty($_POST)) {
            
            $msgUpdateUserError = "Tableau POST vide";
            
            $fName = $_SESSION['user']['f_name'];
            $lName = $_SESSION['user']['l_name'];
            $genre = $_SESSION['user']['genre'];
            $email = $_SESSION['user']['email'];
            $phone = $_SESSION['user']['phone'];
            $address = $_SESSION['user']['address'];
            $id = $_SESSION['user']['id'];
            
            $title = "Formualiaire de modification de compte";
            require(ROOT. "/Views/acount/update-acount.php");
            
            return [];
        }

        if (!isset($_POST["id"])) {
            
            $msgUpdateUserError = "Vous n'êtes pas identifié";
            
            $fName = $_POST['f_name'];
            $lName = $_POST['l_name'];
            $genre = $_POST['genre'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $id = $_POST['id'];
            
            $title = "Formualiaire de modification de compte";
            require(ROOT. "/Views/acount/update-acount.php");
            return [];
        }

        $user = $this->userModel->findUserById($_POST["id"]);
        if (!$user) {
            $msgUpdateUserError = "L'utilisateur avec cet id n'existe pas";
            
            $fName = $_POST['f_name'];
            $lName = $_POST['l_name'];
            $genre = $_POST['genre'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $id = $_POST['id'];
            
            $title = "Formualiaire de modification de compte";
            require(ROOT. "/Views/acount/update-acount.php");
            
            return [];
        }

        if ($_POST["email"] != $user["email"]) {

            if ($this->userModel->isEmailExisted($user["id"], $_POST["email"])) {
                
                $msgUpdateUserError = "Un autre utilisateur a déjà utilisé cette adresse e-mail, veuillez en fournir une autre";
                
                $fName = $_POST['f_name'];
                $lName = $_POST['l_name'];
                $genre = $_POST['genre'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $id = $_POST['id'];
                
                $title = "Formualiaire de modification de compte";
                require(ROOT. "/Views/acount/update-acount.php");
                return [];
            } 
        }

        $newUser = $this->userModel->updateUser($_POST);
        if (!$newUser) {
            
            $msgUpdateUserError = "Votre profil n'a pas été mis à jourp";
            
            $fName = $_POST['f_name'];
            $lName = $_POST['l_name'];
            $genre = $_POST['genre'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $id = $_POST['id'];
            
            $title = "Formualiaire de modification de compte";
            require(ROOT. "/Views/acount/update-acount.php");
            
            return [];
        }

        $params = DataManager::getInfosAddress($_POST["address"]);
        $params["id_user"] = $user["id"];
        
        $address = $this->adrModel->findAddresseByUser($user["id"]);
        if ($address) {
            $newUser["address"] = $this->adrModel->updateAddress($params);
        } else {
            $newUser["address"] = $this->adrModel->createAddress($params);
        }
        $newUser["contribution"] = $this->donationModel->findContributionByUser($user["id"]);
        $_SESSION["user"] = $newUser;
        $msgLoginError = "";
        $title = "Espace de membre";
        require(ROOT . "/Views/acount.php");
        return $newUser;
    }
}
