<?php


namespace Models;


class ImageModel extends Database{
    

    public function __construct()
    {
        parent::__construct();
    }



    


    /**
     * Cette methode sert à enregistrer une nouvelle image dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle image
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle image enregistrée en faisont appel à la methode
     * findActivityById en utilisant le dernier id inserver dans la table Donation
     *
     * @param array $params
     * @return array
     */
    public function createImage(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("INSERT INTO `image`(`name`, `original_name`, `title`, `description`, `size`, `extension`, `link`, `repository`, `size_text`, `id_activity`) 
                                        VALUES (:name1,:original_name,:title,:description1,:size1,:extension,:link,:repository,:size_text,:id_activity)");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            "name1" => $params["name"],
            "original_name" => $params["originalName"],
            "title" => $params["title"],
            "description1" => $params["description"],
            "size1" => $params["size"],
            "extension" => $params["extension"],
            "link" => $params["link"],
            "repository" => $params["repository"],
            "size_text" => $params["sizeText"],
            "id_activity" => $params["idActivity"]
		);
		
		$request->execute($arrayVar);

		$lastId = $this->db->lastInsertId();
		if (!$lastId) {
			return [];
		} 

        return $this->findImageById($lastId);
    }



    


    /**
     * Cette methode sert à enregistrer une mise à jour d'image dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle image
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle image enregistrée en faisont appel à la methode
     * findActivityById en utilisant le dernier id inserver dans la table Donation
     *
     * @param array $params
     * @return array
     */
    public function updateImage(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `image` 
                                        SET `name`=:name1,`original_name`=:original_name,`title`=:title,`description`=:description1,`size`=:size1,`extension`=:extension,`link`=:link,`size_text`=:size_text,`updated_at`=:updated_at 
                                        WHERE `id_activity`=:id_activity");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            "name1" => $params["name"],
            "original_name" => $params["originalName"],
            "title" => $params["title"],
            "description1" => $params["description"],
            "size1" => $params["size"],
            "extension" => $params["extension"],
            "link" => $params["link"],
            "size_text" => $params["sizeText"],
            "id_activity" => $params["idActivity"],
            "updated_at" => date('Y-m-d H:i:s')
		);
		
		$data = $request->execute($arrayVar);

		if (!$data) {
			return [];
		} 

        return $this->findImageByActivity($params["idActivity"]);
    }





    /**
     * Cette methode sert à récupérer une image à partir de son id. Cette methode 
     * attend comme paramètre d'entree l'id de l'image et retoure l'image 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idImage
     * @return array
     */
    public function findImageById(int $idImage):array{


        if (!$idImage) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `image` WHERE id=:id");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'id' => $idImage,
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
     * Cette methode sert à récupérer une image à partir de l'id de l'activity. Cette methode 
     * attend comme paramètre d'entree l'id de l'activité et retoure l'image 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idActivity
     * @return array
     */
    public function findImageByActivity(int $idActivity):array{


        if (!$idActivity) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `image` WHERE id_activity=:id");


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
     * Cette methode sert à envoyer une reque sql vers la base de donnees 
     * afin de recuperer toutes les informations concernant l'association dans la table amazc
     * 
     * Cette methode retourne le resultat sous forme de tableau array et un tableau vide
     * est retourner si quelque chose se passe mal ou si aucune donnée n'est trouvée
     *
     * @return array
     */
    public function getAmazcParams():array{
        
        
        
        $request = $this->db->prepare("SELECT * FROM `amazc`");


        if (!$request) {
           return [];
        }
		
		
		
		$request->execute();
        if (!$request) {
            return [];
        }

		$data = $request->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
             return [];
        }
        
        return $data;
    }
}
