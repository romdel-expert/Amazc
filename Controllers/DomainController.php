<?php
namespace Controllers;


use Models\DataManager;
use Models\DomainModel;
use Models\ImageModel;

require ROOT . "/Models/ImageModel.php";
require ROOT . "/Models/DataManager.php";
require ROOT . "/Models/DomainModel.php";

class DomainController{


    private $imageModel;
    private $domainModel;

    public function __construct(){
        $this->imageModel = new ImageModel();
        $this->domainModel = new DomainModel();
    }


    /**
     * Cette methode permet de visualiser la liste des domaines d'intervention de l'association
     * On retourne la liste sous forme d'un tableau array qui peut êtrevide en cas de récupération
     * d'aucun domaine d'intervention
     *
     * @return void
     */
    public function list(){

        $page = 1;
        $listDomains = $this->setListDomains($this->domainModel->findAll($page));
        require(ROOT . "/Views/domains.php");
    }




    /**
     * Cette methode sert effectuer la structuration des données des domaines d'activité
     * il s'agit de mettre lesdonnées attachées au domain afin d'avoir un tableau
     * complet pour faciliter l'affichage
     * 
     * Cette methode attend comme parametre ou valeurs d'entree un tableau de domaines et
     * retourne le nouveau tableau de domaines sous forme de array 
     *
     * @param array $listDomains
     * @return array
     */
    private function setListDomains(array $listDomains):array{
        
        $newList = [];

        if (!$listDomains) {
            return [];
        }


        foreach ($listDomains as $domain) {
            if ($domain["is_active"] == 1) {
                $newList[] = $this->setDomain($domain);
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
     * @param array $domain
     * @return array
     */
    private function setDomain(array $domain):array{
        
        if (!$domain) {
            return [];
        }

        $domain["image"] = $this->imageModel->findImageByDomain($domain["id"]);
        
        return $domain;
    }
}
