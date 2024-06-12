<?php
namespace Controllers;


use Models\DataManager;
use Models\EventModel;
use Models\ImageModel;

require ROOT . "/Models/ImageModel.php";
require ROOT . "/Models/DataManager.php";
require ROOT . "/Models/EventModel.php";

class NewsController{

    private $imageModel;
    private $eventModel;


    public function __construct()
    {
        $this->imageModel = new ImageModel();
        $this->eventModel = new EventModel();
    }


    /**
     * Cette methode permet de visualiser la liste des activités réalisées par l'association
     * On retourne la liste sous forme d'un tableau array qui peut êtrevide en cas de récupération
     * d'aucune activité 
     *
     * @return void
     */
    public function list(){

        $page = 1;
        $listActivities = $this->setListActivities($this->eventModel->findAll($page));
        require(ROOT . "/Views/news.php");
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
            
            if ($activity["is_active"] == 1) {
                
                $newList[] = $this->setActivity($activity);
            }
        }
        return $newList;
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
