<?php

namespace Models;

use Models\DataManager;


require_once ROOT . "/Models/DataManager.php";

class EventModel extends Database{
    

    public function __construct()
    {
        parent::__construct();
    }



    


    /**
     * Cette methode sert à enregistrer une nouvelle activité dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle activité
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle activité enregistrée en faisont appel à la methode
     * findActivityById en utilisant le dernier id inserver dans la table Donation
     *
     * @param array $params
     * @return array
     */
    public function createActivity(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("INSERT INTO `activity`(`title`, `description`) 
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

        return $this->findActivityById($lastId);
    }



    


    /**
     * Cette methode sert à enregistrer une mise à jour d'activité dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle activité
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle activité enregistrée en faisont appel à la methode
     * findActivityById en utilisant le dernier id inserver dans la table activity
     *
     * @param array $params
     * @return array
     */
    public function updateActivity(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `activity` 
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

        return $this->findActivityById($params["id"]);
    }




    /**
     * Cette methode sert à enregistrer une mise à jour d'activité dans la base de données.
     * Elle attend comme paramètre d'entrée l'id de l'activité et le nouveau statut de l'activité. 
     * Elle retourne un tableau qui est soit vide ou la nouvelle activité
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle activité enregistrée en faisont appel à la methode
     * findActivityById en utilisant le dernier id inserver dans la table activity
     *
     * @param integer $id
     * @param integer $isActive
     * @return array
     */
    public function setActiveActivity(int $id, int $isActive):array{
        
        
        if (!$id) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `activity` 
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

        return $this->findActivityById($id);
    }


    /**
     * Cette methode sert à récupérer une activité à partir de son id. Cette methode 
     * attend comme paramètre d'entree l'id de l'activité et retoure l'activité 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idActivity
     * @return array
     */
    public function findActivityById(int $idActivity):array{

        
        if (!$idActivity) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `activity` WHERE id=:id");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'id' => $idActivity,
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
     * Cette methode sert à récupérer une activité à partir de son titre, sa 
     * description et le nom original de la photo qui lui est attachée. Cette methode 
     * attend comme paramètre d'entree les informations pre-citées de l'activité et retoure l'activité 
     * sous forme de tableau
     * 
     * les valeurs fournies en parametre sont injectés dans la requete sql envoyée vers 
     * la base de données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idActivity
     * @return array
     */
    public function findActivityByTitleDescriptionAndOriginalImageName(
            string $title,
            string $description,
            string $originalName
        ):array{


        if (!$title || !$description || !$originalName) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT a.* FROM `activity` a
                                            INNER JOIN `image` i ON a.id = i.id_activity
                                            WHERE a.title=:title 
                                            AND a.description=:description1
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
     * Cette fonction sert à récupérer tous les évenement sachant que le nombre 
     * charger est limiter pour des question de performance
     * 
     * Le chargement est effectué par page et à ahaque fois on recupère un nombre precis
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

        $request = $this->db->prepare("SELECT a.* FROM `activity` a
                                             ORDER BY a.id DESC");

                                             
        // $request = $this->db->prepare("SELECT a.*, i.* FROM `activity` a
        //                                     INNER JOIN `image` i ON i.id_activity = a.id
        //                                     LIMIT :from1, :quantity");

        // $request = $this->db->prepare("SELECT *
        //                                     FROM
        //                                     (
        //                                         SELECT t.*,
        //                                             @rn := @rn + 1 AS rn
        //                                         FROM activity t,
        //                                         (SELECT @rn := 0) r
        //                                     ) t
        //                                     WHERE rn BETWEEN :start AND :end;");

        // $arrayVar = array(
        //     'from1' => intval($from),
        //     "quantity" => $quantity 
        // );
        // $arrayVar = array(
        //     'start' => 0,
        //     "end" => 10 
        // );

        $request->execute();
        // $request->execute($arrayVar);

        if (!$request) {
            return [];
        }

        $data = $request->fetchAll();
        if (!$data) {
            return [];
        }

        return $data;
    }
    
    
    /**
     * Cette fonction sert à récupérer tous les évenement actifs sachant que le nombre 
     * charger est limiter pour des question de performance
     * 
     * Le chargement est effectué par page et à ahaque fois on recupère un nombre precis
     *
     * @param integer $page
     * @return array
     */
    public function findAllActive(int $page):array{
        
        if (!$page) {
            $page = 1;
        }

        $from = ($page - 1) * DataManager::$QUANTITY_BY_PAGE;
        $quantity = DataManager::$QUANTITY_BY_PAGE;

        $request = $this->db->prepare("SELECT a.* FROM `activity` a WHERE a.is_active = true
                                             ORDER BY a.id DESC");

                                             
        // $request = $this->db->prepare("SELECT a.*, i.* FROM `activity` a
        //                                     INNER JOIN `image` i ON i.id_activity = a.id
        //                                     LIMIT :from1, :quantity");

        // $request = $this->db->prepare("SELECT *
        //                                     FROM
        //                                     (
        //                                         SELECT t.*,
        //                                             @rn := @rn + 1 AS rn
        //                                         FROM activity t,
        //                                         (SELECT @rn := 0) r
        //                                     ) t
        //                                     WHERE rn BETWEEN :start AND :end;");

        // $arrayVar = array(
        //     'from1' => intval($from),
        //     "quantity" => $quantity 
        // );
        // $arrayVar = array(
        //     'start' => 0,
        //     "end" => 10 
        // );

        $request->execute();
        // $request->execute($arrayVar);

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
