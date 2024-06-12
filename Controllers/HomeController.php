<?php
namespace Controllers;

use Models\EventModel;
use Models\ImageModel;

require ROOT . "/Models/EventModel.php";
require ROOT . "/Models/ImageModel.php";

class HomeController{

    private $eventModel;
    private $imageModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->imageModel = new ImageModel();
    }
    
    /**
     * Cette fonction du controller sert à récupérer les données necessaires 
     * et afficher la page d'accueil
     *
     * @return void
     */
    public function home(){
        $title = "Accueil Association Michel-Archange";
        $page = 1;
        $listActivities = $this->setListActivities($this->eventModel->findAll($page));
        require(ROOT ."/Views/home.php");
    }


    /**
     * Cette fonction du controller sert à récupérer les données necessaires 
     * et afficher les la page qui presente des informations à propose de 
     * l'association
     *
     * @return void
     */
    public function about(){
       $title = "A propos de Association Michel Archange Zéero chômage";
       require(ROOT . "/Views/home/about.php"); 
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
