<?php

namespace Models;

use Models\DataManager;


require_once ROOT . "/Models/DataManager.php";

class DomainModel extends Database{
    

    public function __construct()
    {
        parent::__construct();
    }



    


    /**
     * Cette methode sert à enregistrer un nouveau domaine d'activité dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouveau domaine
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle activité enregistrée en faisont appel à la methode
     * findDomainById en utilisant le dernier id inserver dans la table Donation
     *
     * @param array $params
     * @return array
     */
    public function createDomain(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("INSERT INTO `domain`(`title`, `description`) 
                                            VALUES (:title,:description1)");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'title' => $params["title"],
            'description1' => $params["description"]
		);
		
		$request->execute($arrayVar);

		$lastId = $this->db->lastInsertId();
		if (!$lastId) {
			return [];
		} 

        return $this->findDomainById($lastId);
    }



    


    /**
     * Cette methode sert à enregistrer une mise à jour de domaine d'activité dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou le nouveau domaine d'activité
     * qui vient d'etre enregistré
     * 
     * On recupere le nouveau domaine d'actité enregistré en faisont appel à la methode
     * findDomainById en utilisant le dernier id inserer dans la table domain
     *
     * @param array $params
     * @return array
     */
    public function updateDomain(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `domain` 
                                        SET `title`=:title,`description`=:description1,`updated_at`=:updated_at 
                                        WHERE `id`=:id");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'id' => $params["id"],
            'title' => $params["title"],
            'description1' => $params["description"],
            "updated_at" => date('Y-m-d H:i:s')
		);
		
		$data = $request->execute($arrayVar);

		if (!$data) {
			return [];
		} 

        return $this->findDomainById($params["id"]);
    }




    /**
     * Cette methode sert à enregistrer une mise à jour de domaine d'intervention dans la base de données.
     * Elle attend comme paramètre d'entrée l'id du domaine et le nouveau statut du domaine d'intervention. 
     * Elle retourne un tableau qui est soit vide ou la nouvelle activité
     * qui vient d'etre enregistré
     * 
     * On recupere le nouveau domaine d'intervention enregistré en faisont appel à la methode
     * findDoamineById en utilisant le dernier id inserer dans la table domain
     *
     * @param integer $id
     * @param integer $isActive
     * @return array
     */
    public function setActiveDomain(int $id, int $isActive):array{
        
        
        if (!$id) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `domain` 
                                        SET `is_active`=:is_active, `updated_at`=:updated_at 
                                        WHERE `id`=:id");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'id' => $id,
            'is_active' => $isActive,
            "updated_at" => date('Y-m-d H:i:s')
		);
		
		$data = $request->execute($arrayVar);

		if (!$data) {
			return [];
		} 

        return $this->findDomainById($id);
    }


    /**
     * Cette methode sert à récupérer un domaine à partir de son id. Cette methode 
     * attend comme paramètre d'entree l'id du domaine d'activité et retourne le domaine 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idDomain
     * @return array
     */
    public function findDomainById(int $idDomain):array{

        
        if (!$idDomain) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `domain` WHERE id=:id");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'id' => $idDomain,
		);
		
		$request->execute($arrayVar);
        if (!$request) {
            return [];
        }

		$data = $request->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
             return [];
        }
        
        return $data;
    }




    


    /**
     * Cette methode sert à récupérer un domaine d'intervention à partir de son titre, sa 
     * description et le nom original de la photo qui lui est attachée. Cette methode 
     * attend comme paramètre d'entree les informatios pré citéesn du domaine et retoure le domaine 
     * sous forme de tableau
     * 
     * les valeurs fournies en parametre sont injectés dans la requete sql envoyée vers 
     * la base de données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idActivity
     * @return array
     */
    public function findDomainByTitleDescriptionAndOriginalImageName(
            string $title,
            string $description,
            string $originalName
    ):array{


        if (!$title || !$description || !$originalName) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT d.* FROM `domain` d
                                            INNER JOIN `image` i ON d.id = i.id_activity
                                            WHERE d.title=:title 
                                            AND d.description=:description1
                                            AND i.original_name=:original_name");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'title' => $title,
            'description1' => $description,
            'original_name' => $originalName,
		);
		
		$request->execute($arrayVar);
        if (!$request) {
            return [];
        }

		$data = $request->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
             return [];
        }
        
        return $data;
    }
    
    
    /**
     * Cette fonction sert à récupérer tous les domaine d'intervention sachant que le nombre 
     * charger est limiter pour des question de performance
     * 
     * Le chargement est effectué par page et à chaque fois on recupère un nombre precis
     *
     * @param integer $page
     * @return array
     */
    public function findAll(int $page):array{
        
        if (!$page) {
            $page = 1;
        }

        $from = ($page - 1) * DataManager::$QUANTITY_BY_PAGE;
        $quantity = DataManager::$QUANTITY_BY_PAGE;

        $request = $this->db->prepare("SELECT d.* FROM `domain` d
                                             ORDER BY d.id DESC");

        $request->execute();

        if (!$request) {
            return [];
        }

        $data = $request->fetchAll();
        if (!$data) {
            return [];
        }

        return $data;
    }
}
