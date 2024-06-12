<?php
namespace Models;

require_once (ROOT . "/Models/DataManager.php");

class DonationModel extends Database{
    

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Cette methode sert à enregistrer une nouvelle donation dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle donation
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle donation enregistrée en faisont appel à la methode
     * findDonationById en utilisant le dernier id inserver dans la table Donation
     *
     * @param array $params
     * @return array
     */
    public function createDonation(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("INSERT INTO `donation`(`name`, `email`, `phone`, `amount`, `message`) 
                                        VALUES (:name_don, :email, :phone, :amount, :message_don)");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'name_don' => $params["nameDonation"],
            'email' => $params["emailDonation"],
            'phone' =>$params["phoneDonation"],
            'amount' =>$params["amount"],
            'message_don' =>$params["messageDonation"]
		);
		
		$request->execute($arrayVar);

		$lastId = $this->db->lastInsertId();
		if (!$lastId) {
			return [];
		} 

        return $this->findDonationeById($lastId);
    }


    /**
     * Cette methode sert à récupérer une donation à partir de son id. Cette methode 
     * attend comme paramètre d'entree l'id de la donation et retoure la donation 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idDonation
     * @return array
     */
    public function findDonationeById(int $idDonation):array{


        if (!$idDonation) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `donation` WHERE id=:id");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'id' => $idDonation,
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
     * Cette methode sert à récupérer une donation à partir de l'id de l'utlisateur. Cette methode 
     * attend comme paramètre d'entree l'id de l'utilisateur et retoure la donation 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param string $email
     * @return array
     */
    public function findDonationeByEmail(string $email):array{


        if (!$email) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `donation` WHERE email=:email");


        if (!$email) {
           return [];
        }
		
		$arrayVar = array(
            'email' => $email,
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
     * Cette methode sert à enregistrer la mise à jour d'une donation dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou la nouvelle donation
     * qui vient d'etre enregistrée
     * 
     * On recupere la nouvelle donation enregistrée en faisont appel à la methode
     * findDonationById en utilisant le dernier id inserver dans la table Donation
     *
     * @param array $params
     * @return array
     */
    public function updateDonation(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            
		);
		
		$request->execute($arrayVar);
        
		if (!$request) {
			return [];
		} 

        return $this->findDonationeById($params["id"]);
    }





    /**
     * Cette methode sert à creer une nouvelle contisation annuelle liée à un utilisateur
     * elle atrend comme valeur d'entrée l'id de l'utilisateur et retourne la contisation créée
     * i-on ne prend en compte que la date d'expiration qui est la date du jour + un an
     * car la cotisation a lieu chaque année
     * 
     * Les autre champs de la table sont automatisés avec des valeurs par défaut
     *
     * @param integer $idUser
     * @return array
     */
    public function createContribution(int $idUser):array{
        
        if (!$idUser) {
            return [];
        }
        

        $contribution = $this->findContributionByYearAndUser($idUser, date('Y'));
        if ($contribution) {
            return $contribution;
        }
        
        $request = $this->db->prepare("INSERT INTO `contribution`(`id_user`, `date_exp`)
                                        VALUES (:id_user,:date_exp)");

		if (!$request) {
           return [];
        }

        $date = new \DateTime(date('Y-m-d H:i:s'));
        /**
         * Où 'P12M' indique 'Période de 12 Mois'
         */
        $date->add(new \DateInterval('P12M')); 
        $dateExp = $date->format('Y-m-d H:i:s');
        
		$arrayVar = array(
            'id_user' => $idUser,
            'date_exp' => $dateExp,
		);
		
		$request->execute($arrayVar);

		if (!$request) {
			return [];
		} 

        return $this->findContributionByUser($idUser);
    }




    /**
     * Cette fonction sert à récupérer une contribution par l'utilisateur. On fournit l'id de
     * l'utilisateur en entrée afin de trouver la contribution/cotisation qu'on souhaite déterminer
     * 
     * Il s'agit de recupere la dernière contribution de l'utilisateur car en fonction du nombre
     * d'années passées, un membre adhérent/utilisateur peut avoir plusieur contribution enregistrées
     *
     * @param integer $idUser
     * @return array
     */
    public function findContributionByUser(int $idUser):array{
        if (!$idUser) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `contribution` WHERE id_user=:id ORDER BY id DESC LIMIT 1");


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
     * Cette fonction sert à récupérer une contribution par l'utilisateur. On fournit l'id de
     * l'utilisateur en entrée afin de trouver la contribution/cotisation qu'on souhaite déterminer
     * 
     * On suppose qu'un utilisateur, membre adhérent ne doit pas avoir 2 cotisation dans une seule 
     * année Cela permet de regulariser le fait qu'on ne doit pas créer une nouvelle contribution
     * pour un utilisateur qui a deja enregistrer une contribution durant la même en cours
     * 
     * On calcul la difference entre la date du jour et la date d'expiration de la contribution
     * Si la difference est plus grand qu'une année alors on enregistre la nouvelle contribution
     *
     * @param integer $idUser
     * @return array
     */
    public function findContributionByYearAndUser(int $idUser):array{
        
        if (!$idUser) {
			return [];
		} 
        
        $contribution = $this->findContributionByUser($idUser);
        if (!$contribution) {
            return [];
        }

        $diff =  strtotime($contribution['date_exp']) - strtotime(date('Y-m-d H:i:s'));
        if( $diff <= 0 ){
            return [];
        }

        return $contribution;
    }
}
