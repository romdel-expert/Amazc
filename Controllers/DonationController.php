<?php
namespace Controllers;

use Models\DonationModel;

require_once ROOT . "/Models/DonationModel.php";

class DonationController{

    private $donationModel;
    
    public function __construct(){
        $this->donationModel = new DonationModel();
    }


    /**
     * Cette methode sert à afficher la page permettant d'enregistrer une donation
     * Elle envoie le formaulaire d'enregistrement
     * 
     * Elle n'attend aucune valeur en entrée et ne retourne aucun type
     *
     * @return void
     */
    public function form(){
        $amount = 0;
        $nameDonation = "";
        $emailDonation = "";
        $phoneDonation = "";
        $messageDonation = "";
        
        $msgErrDonation = "";
        require (ROOT . "/Views/donation.php");
    }

    /**
     * Cette methose sert à récuperer les données depuis le formulaire d'enregistrement de don
     * Elle vérifie les données et faire appel au model permettant d'envoyer les données vers la 
     * base de données
     * 
     * Après lenregistrement des données l'utilisateur est redirigé vers la page de paiement
     * où il procedera au paiement de son don
     * 
     * Cette methode ne prend pas de valeur d'nenntrée et ne retourne pas de valeur, elle ne fait
     * que d'envoyer des page/vue en fonction du cas
     * 
     * En cas de problème au niveau des données recuperées on reste sur la vue du formualire et on 
     * affiche un message d'erreur et si toutes les données sont corrects on fait appel au model 
     * pour l'enregistrement si tout va bien on est rediriger vers la page de paiement sur paypal
     *
     * @return void
     */
    public function create(){
            
        if (empty($_POST)) {

            $amount = "";
            $nameDonation = "";
            $emailDonation = "";
            $phoneDonation = "";
            $messageDonation = "";
            
            $msgErrDonation = "Veillez remplir tous les champs obligatoires";
            require (ROOT . "/Views/donation.php");
            exit();
        }
        $msgErrDonation = "";
        $donation = $this->donationModel->createDonation($_POST);
        if (!$donation) {
            
            $amount = $_POST["amount"];
            $nameDonation = $_POST["nameDonation"];
            $emailDonation = $_POST["emailDonation"];
            $phoneDonation = $_POST["phoneDonation"];
            $messageDonation = $_POST["messageDonation"];
            
            $msgErrDonation = "Votre donation n'a pa été enregistrée. Veuillez vérifier et recommencer.";
            require (ROOT . "/Views/donation.php");
            exit();
        }
        $msgErrDonation = "";
        header("Location:https://www.paypal.com/donate/?hosted_button_id=R82EHRWXKDHXC");
    }


    /**
     * Cette methode permet d'afficher la page de confirmation d'un paiement en cours
     * La methode n'attend aucun parametre d'entrée et ne retourne rien
     * 
     * Mais envoie la page à afficher
     *
     * @return void
     */
    public function confirm(){
        $title = "Confirmation de donation";
        require(ROOT . "/Views/confirm-donation.php");
    }
}
