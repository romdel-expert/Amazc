<?php

namespace Controllers;

use Models\DataManager;
use Models\EventModel;
use Models\ImageModel;

require ROOT . "/Models/ImageModel.php";
require ROOT . "/Models/DataManager.php";
require ROOT . "/Models/EventModel.php";

class AdminController{

    private $imageModel;
    private $eventModel;


    public function __construct()
    {
        $this->imageModel = new ImageModel();
        $this->eventModel = new EventModel();
    }
    
    
    public function home(){
        $title = "Espace administrateur";
        require ROOT."/Views/admin/pages/home.php";
    }


    /**
     * Cette mthode sert à afficher le formulaire permettant d'enregistrer un nouvel evenement
     * On verifie d'abord que la session de l'administrateur est en cours, sion on le renvoie 
     * vers la page de connexion
     *
     * @return void
     */
    public function formEvent(){
        
        if (!isset($_SESSION["admin"])) {
            $msgLoginError = "";
            $emailLogin = "";
            require(ROOT . "/Views/admin/pages/login.php");
            exit();
        }

        $msgEventError = "";
        $titleEvent = "";
        $description = "";
        
        if (isset($_POST["title"])) {
            $titleEvent = $_POST["title"];
        }

        if (isset($_POST["description"])) {
            $description  = $_POST["description"];
        }
        
        require(ROOT . "/Views/admin/pages/form-event.php");
    }


    /**
     * Cette mthode sert à afficher le formulaire permettant d'enregistrer la mise à jour 
     * d'un evenement existant
     * On verifie d'abord que la session de l'administrateur est en cours, sion on le renvoie 
     * vers la page de connexion
     *
     * @return void
     */
    public function formActivityUpd(){
        
        if (!isset($_SESSION["admin"])) {
            $msgLoginError = "";
            $emailLogin = "";
            require(ROOT . "/Views/admin/pages/login.php");
            exit();
        }

        
        if (empty($_POST)) {
            $msgEventError = "L'activité que vous souhaitez modifier n'est pas identifiée";
            $class = "alert-danger";
            $page = 1;
            $listActivities = $this->setListActivities($this->eventModel->findAll($page));
            require(ROOT . "/Views/admin/pages/events.php");
            exit();
        }
        
        $activity = $this->eventModel->findActivityById($_POST["id"]);
        
        if (!$activity) {
            $msgEventError = "Aucune activité ne correspond à cet identifiant";
            $class = "alert-danger";
            $page = 1;
            $listActivities = $this->setListActivities($this->eventModel->findAll($page));
            require(ROOT . "/Views/admin/pages/events.php");
            exit();
        }
        
        $msgEventError = "";    
        $activity = $this->setActivity($activity);
        require(ROOT . "/Views/admin/pages/form-upd-event.php");
    }


    /**
     * Cette mthode sert à afficher la page qui présente la liste des évenement realisés 
     * On verifie d'abord que la session de l'administrateur est en cours, sion on le renvoie 
     * vers la page de connexion
     *
     * @return void
     */
    public function events(){
        
        if (!isset($_SESSION["admin"])) {
            $msgLoginError = "";
            $emailLogin = "";
            require(ROOT . "/Views/admin/pages/login.php");
            exit();
        }

        $page = 1;
        $msgEventError = "";
        $listActivities = $this->setListActivities($this->eventModel->findAll($page));
        require(ROOT . "/Views/admin/pages/events.php");
    }
    

    /**
     * Cette fonction sert à recupérer toutes les informations concernant un evenement 
     * organisé, charger la photo, la stoker dans un repertoire l'enregistrer dans la 
     * base de données elle enregistre egalement les autres information dans la base 
     * de données
     * 
     * On teste l'exitance de la session de ladministrateur si tel n'est pas le cas
     * on le redirige vers la page de connexion'
     *
     * @return void
     */
    public function saveEvent(){
        
        if (!isset($_SESSION["admin"])) {
            $msgLoginError = "";
            $emailLogin = "";
            require(ROOT . "/Views/admin/pages/login.php");
        }

        
        /**
         * On teste le tableau contenant les informations concernant l'evenement 
         */
        if(empty($_POST)){
            
            $msgEventError = "Aucune information sur l'évenement n'est retrouvée";
            $titleEvent = "";
            $description = "";
            require(ROOT . "/Views/admin/pages/form-event.php");
            exit();
        }

        if (!isset($_POST["title"]) || !isset($_POST["description"])) {
            $msgEventError = "Le titre et/ou la description de l'événement ne sont pas renseignés";
            $titleEvent = "";
            $description = "";
            require(ROOT . "/Views/admin/pages/form-event.php");
            exit();
        }

        $nameStoreed = "";
            
        $loadFile = $this->loadFile("event", $nameStoreed);
        
        if ($loadFile["message"]) {
            $msgEventError = $loadFile["message"];
            $titleEvent = $_POST["title"];
            $description = $_POST["description"];
            require(ROOT . "/Views/admin/pages/form-event.php");
            exit();
        }

        /**
         * On teste s'il y a une activité qui existe déjà avec les mêmes titre, description 
         * et original nom d'image pour éviter deux choses
         * 
         * D'abord pour eviter que le formulaire soit renvoyer suite au refresh de la page
         * puis pour eviter que l'utilisateur s'amuse à enregistrer des activités identiques
         */
        $existingActivity = $this->eventModel->findActivityByTitleDescriptionAndOriginalImageName(
            $_POST["title"],
            $_POST["description"],
            $loadFile["originalName"]
        );
        
        if (!$existingActivity) {
            
            $activity = $this->eventModel->createActivity($_POST);
            if (!$activity) {
                $msgEventError = "L'activité n'a pas été enregistrée";
                $titleEvent = $_POST["title"];
                $description = $_POST["description"];
                require(ROOT . "/Views/admin/pages/form-event.php");
                exit();
            }

            $loadFile["title"] = $_POST["title"];
            $loadFile["description"] = $_POST["description"];
            $loadFile["idActivity"] = $activity["id"];
            
            $photo = $this->imageModel->createImage($loadFile);
            if (!$photo) {
                $msgEventError = "Suite à un problème interne, la photo a été chargé mais non enregistrée";
                $titleEvent = $_POST["title"];
                $description = $_POST["description"];
                require(ROOT . "/Views/admin/pages/form-event.php");
                exit();
            }
        }


            
        $this->events();
    }
    

    /**
     * Cette fonction sert à recupérer toutes les informations concernant un evenement 
     * organisé, charger la photo, la stoker dans un repertoire l'enregistrer dans la 
     * base de données elle enregistre egalement les autres information dans la base 
     * de données
     * 
     * On teste l'exitance de la session de ladministrateur si tel n'est pas le cas
     * on le redirige vers la page de connexion'
     *
     * @return void
     */
    public function updateEvent(){
        
        if (!isset($_SESSION["admin"])) {
            $msgLoginError = "";
            $emailLogin = "";
            require(ROOT . "/Views/admin/pages/login.php");
        }

        
        /**
         * On teste le tableau contenant les informations concernant l'evenement 
         */
        if(empty($_POST)){
            
            $msgEventError = "Aucune information sur l'évenement n'est retrouvée";
            $activity = array(
                "id" => 0,
                "title" => "",
                "description" => "",
                "image" => null
            );
            require(ROOT . "/Views/admin/pages/form-upd-event.php");
            exit();
        }

        $activity = array(
            "id" => $_POST["id"],
            "title" => $_POST["title"],
            "description" => $_POST["description"],
            "image" => null
        );

        if (!isset($_POST["id"])) {
            $activity["id"] = 0;
        }

        if (!isset($_POST["title"])) {
            $activity["title"] = "";
        }

        if (!isset($_POST["description"])) {
            $activity["description"] = "";
        }
        
        if (!isset($_POST["id"]) || !isset($_POST["title"]) || !isset($_POST["description"])) {
            $msgEventError = "Le titre et/ou la description de l'événement ne sont pas renseignés ou l'activité n'est pas identifiée";
            
            require(ROOT . "/Views/admin/pages/form-upd-event.php");
            exit();
        }



        $existingActivity = $this->eventModel->findActivityById($_POST["id"]);
        if (!$existingActivity) {
            $msgEventError = "Aucune activité ne correspond à l'id";
            
            require(ROOT . "/Views/admin/pages/form-upd-event.php");
            exit();
        }

        
        

        $newActivity = $this->eventModel->updateActivity($_POST);
        if (!$newActivity) {
            $msgEventError = "L'activité n'a pas été modifiée";
            
            require(ROOT . "/Views/admin/pages/form-upd-event.php");
            exit();
        }

        
        
        if ($_FILES["file_event"]["tmp_name"]) {

            $nameStoreed = $this->imageModel->findImageByActivity($_POST["id"])["name"];
            
            $loadFile = $this->loadFile("event", $nameStoreed);
        
            if ($loadFile["message"]) {
                $msgEventError = $loadFile["message"];
                
                require(ROOT . "/Views/admin/pages/form-upd-event.php");
                exit();
            }

            $loadFile["title"] = $_POST["title"];
            $loadFile["description"] = $_POST["description"];
            $loadFile["idActivity"] = $newActivity["id"];
            
            $photo = $this->imageModel->updateImage($loadFile);
            if (!$photo) {
                $msgEventError = "Suite à un problème interne, la photo a été chargé mais non enregistrée";
                $activity = $newActivity;
                require(ROOT . "/Views/admin/pages/form-upd-event.php");
                exit();
            }
        }


            
        $this->events();
    }




    /**
     * Cette mthode sert à mettre à jour une activité en la déclarant active ou inactive
     * Active: l'activite s'affiche sur le site
     * inactive : l'activité ne s'affiche pas sur le site
     * 
     * sauf l'administrateur peut consulter une activité qui n'est pas en état active
     *
     * @return void
     */
    public function setActive(){
        
        if (!isset($_SESSION["admin"])) {
            $msgLoginError = "";
            $emailLogin = "";
            require(ROOT . "/Views/admin/pages/login.php");
        }

        
        /**
         * On teste le tableau contenant les informations concernant l'evenement 
         */
        if(empty($_POST)){
            
            $msgEventError = "Aucune information sur l'activité n'est retrouvée";
            $class = "alert-danger";
            $page = 1;
            $listActivities = $this->setListActivities($this->eventModel->findAll($page));
            require(ROOT . "/Views/admin/pages/events.php");
            exit();
        }


        if(!isset($_POST["id"])){
            
            $msgEventError = "L'activité n'est pas identifiée";
            $class = "alert-danger";
            $page = 1;
            $listActivities = $this->setListActivities($this->eventModel->findAll($page));
            require(ROOT . "/Views/admin/pages/events.php");
            exit();
        }

        $id = $_POST["id"];
        
        $activity = $this->eventModel->findActivityById($id);
        
        if(!$activity){
            
            $msgEventError = "Aucune activité ne correspondà l'id fourni ";
            $class = "alert-danger";
            $page = 1;
            $listActivities = $this->setListActivities($this->eventModel->findAll($page));
            require(ROOT . "/Views/admin/pages/events.php");
            exit();
        }


        $isActive = $activity["is_active"];
        if ($isActive == 0) {
            $isActive = 1;
        }elseif ($isActive == 1) {
            $isActive = 0;
        }
            
        $newActivity = $this->eventModel->setActiveActivity($id, $isActive);
        if (!$newActivity) {
            $msgEventError = "L'activité n'a pas été mise à jour";
            $class = "alert-danger";
            $page = 1;
            $listActivities = $this->setListActivities($this->eventModel->findAll($page));
            require(ROOT . "/Views/admin/pages/events.php");
            exit();
        }


        
        $msgEventError = "L'activité a été mise à jour avec succès";
        $class = "alert-success";
        $page = 1;
        $listActivities = $this->setListActivities($this->eventModel->findAll($page));
        require(ROOT . "/Views/admin/pages/events.php");
    }

    public function domains(){
        $title = "Domaine d'activité";
        require ROOT."/Views/admin/pages/domains.php";
    }


    public function addDomain(){
        $title = "Formulaire de nouveau domaine d'activité";
        require ROOT."/Views/admin/pages/new-domain.php";
    }





    /**
     * Cette fonction sert à recuperer toutes les information concernant le fichier chargé
     * si tout va bien on retourne un tableau avec toutes les informations concernant le 
     * fichier contenant un message, ce dernier est vide si tout va bien main contient un 
     * text non vide si que que chosese passe mal
     * 
     * le tableau ne contient que le texte d'erreur si ça se passe mal mais les autres 
     * informations sont vides 
     * 
     * Cette methode ne prends pas de parametre d'entrée et retourne le tableau du 
     * resultat du deroulement du chargement des informations
     *
     * @param string $groupFile : depandamment du context c'est à dire
     * il peut s'agir d'un evenement ou d'un domaine ou d'un logo ou d'une photo de profil
     * @param string $nameStoreed : le nom du fichier dans le repertoire stocké dans la 
     * base de données
     * @return array
     */
    private function loadFile(string $groupFile, string $nameStoreed ):array{

        /**
         * Récupération des paramètres de configuration
         */
        $params = $this->imageModel->getAmazcParams();
        if (!$params) {
            return array(
                "message" => "Les paramères de configuration pour le bon déroulement du processus ne sont pas récupérés",
            );
        }
        
        $folder = "images";

        /**
         * definition de la taille maximal du logo
         */
        define('MAX_SIZE_LOGO', 10000000);
        /**
         * la valeur de l'attribut name du champ de type file qui permet de charger le fichier
         */
        $index = "file_event";
        
        /**
         * Le repertoire ou sera stocké le fichier
         */
        $targetDir = ROOT."/Assets/images";
        /**
         * On teste le tableau contenant les informations du fichier chargé en général
         */
        if(empty($_FILES)){
            return array(
                "message" => "Tableau de fichier vide",
            );
        }

        
        /**
         * On teste le contenu du tableau pour le fichier du logo
         */
        if (empty($_FILES[$index])) {
            return array(
                "message" => "Aucun fichier chargé",
            );
        }


        /**
         * Vérification de l'existance du fichier dans la memoire tempon
         */
        if (!$_FILES[$index]["tmp_name"]) {
            return array(
                "message" => "Les informations concernant le fichier ne sont pas reconnues",
            );
        }
            
        $size = $_FILES[$index]["size"];
        /**
         * Comparaison de la raille du fichier reçu avec la taille maximale autorisée
         */
        if ($size > MAX_SIZE_LOGO) {
            return array(
                "message" => "La taille du fichier est trop grande, Taille maximum autorisé " . $this->formatSizeFile(MAX_SIZE_LOGO),
            );
        }	
        /**
         * La taille sous forme de texte, exemple 16 Ko
         */
        $sizeText = $this->formatSizeFile($size);	
        /**
         * Le repertoire dans lequel se trouve le fichier
         */
        $repository = $params["url"] . "/Assets/images";
        /**
         * Date de création
         */
        $created_at = date('Y-m-d H:i:s');
        /**
         * Date de modification
         */	
        $updated_at = date('Y-m-d H:i:s');
        /**
         * Le nom original du fichier
         */
        $originalName = 
            str_replace(".png", "", 
                str_replace(".PNG", "", 
                    str_replace(".jpeg", "", 
                        str_replace(".JPEG", "", 
                            str_replace(".jpg", "", 
                                str_replace(
                                    ".JPG", "", 
                                        str_replace(".gif", "", str_replace(".GIF", "", basename($_FILES[$index]["name"]))
                                    )
                                )
                            )
                        )
                    )
                )
            );

        /**
         * Extension du fichier
         */   
        $tab = explode(".", basename($_FILES[$index]["name"]));
        /**
         * L'extention est le dernier element/chaine du tableau car certains nom 
         * de fichier contennet également des . mais l'extension est toujours 
         * àpreès le dernier point
         */
        $extension = $tab[count($tab) - 1];

        /**
         * le nom du fichier qui sera utilisfé
         */	
        $name = uniqid($groupFile ."_", true) . "." . $extension;
        /**
         * Le fichier de destination
         */
        $targetFile = $targetDir . "/" . $name;

        /**
         * Le lien vers la source de l'image
         */
        $link = $params["url"] . "/Assets/" . $folder . "/" . $name;
        
        if ($nameStoreed) {
            if (file_exists($targetDir . "/" . $nameStoreed)) {
                unlink($targetDir . "/" . $nameStoreed);
            }
        }
        
        if (move_uploaded_file($_FILES[$index]["tmp_name"], $targetFile)) {
            return array(
                "message" => "",
                "name" => $name,
                "originalName" => DataManager::mysqlEscapeMimic($originalName),	
                "size" => $size,	
                "extension" => $extension,	
                "link" => $link,	
                "repository" => $repository,	
                "sizeText" => $sizeText,
            );
        }else{
            return array(
                "message" => "Votre fichier n'est pas chargé"
            );
        }
    }


    



    /**
     * Cette fonction permet de convertir la taille du fichier en texte.
     * 
     * Cette fonction est importe pour l'utilisateur car tous les utilisateurs 
     * ne comprenne pas les nombre d'octets de façon brute. Il comprennent plus 
     * facilement l'ecriture en kilo ou mega ou gia, tetra etc
     * 
     * Cette fonction attend en entrée la quantité en nombre décimal et retourne 
     * la quantité en chaine de caractères
     *
     * @param float $size
     * @return string
     */
    private function formatSizeFile(float $size):string{
        
        $sizeText = "0 b";
        
        if ($size < 1000) {
            $sizeText = number_format($size, 2) . " b";
        }if ($size >=1000 && $size < 1000000) {
            $sizeText = number_format($size/1000, 2) . " Kb";
        }if ($size >=1000000 && $size < 1000000000) {
            $sizeText = number_format($size/1000000) . " Mb";
        }if ($size >=1000000000 && $size < 1000000000000) {
            $sizeText = number_format($size/1000000000) . " Gb";
        }
        return $sizeText;
    }




    /**
     * Cette methode sert effectuer la structuration des données des activité
     * il s'agit de mettre lesdonnées attachées au activités afin d'avoir un tableau
     * complet pour faciliter l'affichage
     * 
     * Cette methode attend comme parametre ou valeurs d'entree un tableau d'activités et
     * retourne le nouveau tableau d'activité sous forme de array 
     *
     * @param array $listActivities
     * @return array
     */
    private function setListActivities(array $listActivities):array{
        
        $newList = [];

        if (!$listActivities) {
            return [];
        }


        foreach ($listActivities as $activity) {
            $nawList[] = $this->setActivity($activity);
        }

        return $nawList;
    }




    /**
     * Cette fonction sert à effectuer la structuration des données afin de rendre une 
     * activité compléte c'est à dire de recupérer toutes les données attachée à une activités
     * 
     * afin de construire un tablea ou un objet complet
     *
     * @param array $activity
     * @return array
     */
    private function setActivity(array $activity):array{
        
        if (!$activity) {
            return [];
        }

        $activity["image"] = $this->imageModel->findImageByActivity($activity["id"]);
        
        return $activity;
    }
}
