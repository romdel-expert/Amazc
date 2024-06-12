<?php
namespace Models;

require_once (ROOT . "/Models/DataManager.php");

class AddressModel extends Database{
    

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Cette methode sert à enregistrer une nouvelle adresse dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle adresse
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle adresse enregistrée en faisont appel à la methode
     * findAdresseById en utilisant le dernier id inserver dans la table address
     *
     * @param array $params
     * @return array
     */
    public function createAddress(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("INSERT INTO `address`(street_number, `route`, zip_code, city, department, area, country, country_code, format_address, longitude, latitude, id_user)
                        VALUES (:street_number, :route_adr, :zip_code, :city, :department, :area, :country, :country_code, :format_address, :longitude, :latitude, :id_user)");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'street_number' => $params["street_number"],
            'route_adr' => $params["route"],
            'zip_code' => $params["zip_code"],
            'city' => $params["city"],
            'department' => $params["department"],
            'area' => $params["area"],
			'country' =>$params["country"] ,
			'country_code' => $params["country_code"],
            'format_address' => $params["format_address"],
            'longitude' => $params["longitude"],
            'latitude' => $params["latitude"],
            'id_user' => $params["id_user"],
		);
		
		$request->execute($arrayVar);

		$lastId = $this->db->lastInsertId();
		if (!$lastId) {
			return [];
		} 

        return $this->findAddresseById($lastId);
    }


    /**
     * Cette methode sert à récupérer une adresse à partir de son id. Cette methode 
     * attend comme paramètre d'entree l'id de l'adresse et retoure l'adresse 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idAddress
     * @return array
     */
    public function findAddresseById(int $idAddress):array{


        if (!$idAddress) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `address` WHERE id=:id");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'id' => $idAddress,
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
     * Cette methode sert à récupérer une adresse à partir de l'id de l'utlisateur. Cette methode 
     * attend comme paramètre d'entree l'id de l'utilisateur et retoure l'adresse 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idAddress
     * @return array
     */
    public function findAddresseByUser(int $idUser):array{


        if (!$idUser) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `address` WHERE id_user=:id");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'id' => $idUser,
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
     * Cette methode sert à enregistrer la mise à jour d'une adresse dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle adresse
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle adresse enregistrée en faisont appel à la methode
     * findAdresseById en utilisant le dernier id inserver dans la table address
     *
     * @param array $params
     * @return array
     */
    public function updateAddress(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `address` 
                SET `street_number`=:street_number,`route`=:route_adr,`zip_code`=:zip_code,`city`=:city,`department`=:department,`area`=:area,`country`=:country,`country_code`=:country_code,`format_address`=:format_address,`longitude`=:longitude,`latitude`=:latitude 
                WHERE id_user=:id_user");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'street_number' => $params["street_number"],
            'route_adr' => $params["route"],
            'zip_code' => $params["zip_code"],
            'city' => $params["city"],
            'department' => $params["department"],
            'area' => $params["area"],
			'country' =>$params["country"] ,
			'country_code' => $params["country_code"],
            'format_address' => $params["format_address"],
            'longitude' => $params["longitude"],
            'latitude' => $params["latitude"],
            'id_user' => $params["id_user"],
		);
		
		$request->execute($arrayVar);
        
		if (!$request) {
			return [];
		} 

        return $this->findAddresseByUser($params["id_user"]);
    }
}
