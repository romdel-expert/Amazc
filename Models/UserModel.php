<?php
namespace Models;

require_once (ROOT . "/Models/DataManager.php");

class UserModel extends Database{
    

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Cette methode sert à enregistrer un nouvel utilisateur dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou le nouvel utilisateur
     * qui veint d'etre enregistré
     * 
     * On recupere le nouvel utilisateur enregistré en faisont appel à la methode
     * find UserById en utilisant le dernier id inserver dans la table user
     *
     * @param array $params
     * @return array
     */
    public function createUser(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("INSERT INTO `user`(`f_name`, `l_name`, `genre`, `email`, `phone`, `password`, `created_at`, `updated_at`) 
        VALUES (:f_name, :l_name, :genre, :email, :phone, :password1, :created_at, :updated_at)");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'f_name' => DataManager::mysqlEscapeMimic($params['f_name']),
            'l_name' => DataManager::mysqlEscapeMimic($params['l_name']),
            'genre' => $params['genre'],
            'email' => $params['email'],
            'phone' => $params['phone'],
            'password1' => md5($params['password1']),
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		$request->execute($arrayVar);

		$lastId = $this->db->lastInsertId();
		if (!$lastId) {
			return [];
		} 
        
        $codePw = $this->createCodePassword($params['email']);
        if (!$codePw) {
            return [];
        }
        
        return $this->findUserById($lastId);
    }


    /**
     * Cette methode sert à récupérer une utilisateur à partir de son id. Cette methode 
     * attend comme paramètre d'entree l'id de l'utilisateur et retoure l'utilisateur 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idUser
     * @return array
     */
    public function findUserById(int $idUser):array{


        if (!$idUser) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `user` WHERE id=:id");


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
     * Cette methode sert à récupérer une utilisateur à partir de son email. Cette methode 
     * attend comme paramètre d'entree l'email de l'utilisateur et retoure l'utilisateur 
     * sous forme de tableau
     * 
     * l'email fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param string $email
     * @return array
     */
    public function findUserByEmail(string $email):array{


        if (!$email) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `user` WHERE email=:email");


        if (!$request) {
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
     * Cette methode sert à récupérer une utilisateur à partir de son email et son mot 
     * de passe crypté. Cette methode attend comme paramètre d'entree l'email de 
     * l'utilisateur et retoure l'utilisateur sous forme de tableau
     * 
     * l'email et le mot de passe crypté fourni en parametre est injecté dans la requete 
     * sql envoyée vers la base de données afin d'effectuer le tri de façon plus efficace
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function findUserByEmailAnPassword(string $email, string $password):array{


        if (!$email || !$password) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `user` WHERE email=:email AND `password`=:password1");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'email' => $email,
            'password1' => md5($password)
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
     * Cette methode sert à enregistrer la mise à jour d'un utilisateur dans la base de données.
     * Elle attend comme paramètre d'entrée un tableau contenant les informations à 
     * enregistrer. Elle retourne un tableau qui est soit vide ou le nouvel utilisateur
     * qui veint d'etre enregistré
     * 
     * On recupere le nouvel utilisateur enregistré en faisont appel à la methode
     * find UserById en utilisant le dernier id inserver dans la table user
     *
     * @param array $params
     * @return array
     */
    public function updateUser(array $params):array{
        
        if (!$params || empty($params)) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `user` 
                        SET `f_name`=:f_name,`l_name`=:l_name,`genre`=:genre,`email`=:email,`phone`=:phone,`updated_at`=:updated_at 
                        WHERE id=:id");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'f_name' => DataManager::mysqlEscapeMimic($params['f_name']),
            'l_name' => DataManager::mysqlEscapeMimic($params['l_name']),
            'genre' => $params['genre'],
            'email' => $params['email'],
            'phone' => $params['phone'],
			'updated_at' => date('Y-m-d H:i:s'),
            'id' => $params["id"]
		);
		
		$request->execute($arrayVar);

		if (!$request) {
			return [];
		} 

        $codePw = $this->findCodeByEmail($params["email"]);
        if (!$codePw) {
            $codePw = $this->createCodePassword($params['email']);
        }else{
            $codePw = $this->updateEmailCodePassword($params["email"], $params["id"]);
        }

        if (!$codePw) {
            return [];
        }
        
        return $this->findUserById($params["id"]);
    }



    /**
     * Cette methode sert à vérifier si un email exist pour d'autres utilisateur 
     * autres quee l'utilisateur dont son id est fourni parmi les valeurs d'entrée
     * 
     * Elle attend comme valeurs d'entrée l'id de l'utilisateur et l'email à rechercher
     * ces informations sont injectées dans la requete sql envoyée vers la base de 
     * données afin d'effectuer l'opération de manière tres precise
     * 
     * Cette methode retourne une chaine de caracteres qui l'email retrouvé
     * Si aucun email ne correspond elle retourne une chaine vide
     *
     * @param integer $idUser
     * @param string $email
     * @return string
     */
    public function isEmailExisted(int $idUser, string $email):string{
        if (!$idUser || !$email) {
            return "";
        }

        $request = $this->db->prepare("SELECT DISTINCT `email` FROM `user` 
                                            WHERE `email` =:email AND `id` <> :id LIMIT 1");
        
        $array = array(
            'id' => $idUser,
            'email' => $email
        );

        $data = $request->fetch(\PDO::FETCH_ASSOC);
        if (!$data) {
            return "";
        }

        return $data["email"];
    }





    /**
     * Cette methode permet de declare un ustilisateur comme etant en regle
     * c'est à dire d'appler la methode qui sert à modifier l'utilisateur dans 
     * la base de données en mettant la valeur de la colonne is_rules à true
     * 
     * Cette methode attend comme valeur d'entrée l'id de l'utilisateur. et retourne
     * l'utilisateur mis à jour sous forme de tableau array
     * 
     * 'l'id fourni en entrée est injecté dans la requete sql envoyée au server
     * afin d'effectuer l'operation necessaire
     * 
     * Cette modification met à jour la date de modification, la colonne is_rules
     * la date limite de renouvellement du paiement de l'adhésion
     *
     * @param integer $idUser
     * @param boolean $isRules
     * @return array
     */
    public function updateRulesUser(int $idUser, bool $isRules):array{
        if (!$idUser) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `user` 
                                            SET `is_rules`=:isRules,`updated_at`=:updated_at 
                                            WHERE `id`=:id");

		if (!$request) {
           return [];
        }

        $date = new \DateTime(date('Y-m-d H:i:s'));
        /**
         * Où 'P12M' indique 'Période de 12 Mois'
         */
        $date->add(new \DateInterval('P12M')); 
        $dataRules = $date->format('Y-m-d H:i:s');
        
		$arrayVar = array(
            'isRules' => $isRules,
			'updated_at' => date('Y-m-d H:i:s'),
            'id' => $idUser
		);
		
		$request->execute($arrayVar);

		if (!$request) {
			return [];
		} 

        return $this->findUserById($idUser);
    }





    /**
     * Cette methode sert à enregistrer un nouveau code de mot de passe dans la base de données.
     * Elle attend comme paramètre d'entrée une chaine de carracteres qui est l'e-mail de 
     * l'utilisateur à enregistrer. Elle retourne un tableau qui est soit vide ou le nouveau code
     * qui vient d'etre enregistré
     * 
     * On recupere le nouveau code enregistré en faisont appel à la methode
     * findCodeById en utilisant le dernier id inserver dans la table code_pw
     *
     * @param string $email
     * @param string $code
     * @return array
     */
    public function createCodePassword(string $email, string $code = null):array{
        
        if (!$email) {
            return [];
        }
        
        $request = $this->db->prepare("INSERT INTO `code_pw`(`email`, `code`, `date_exp`, `id_user`) 
        VALUES (:email, :code, :date_exp, :id_user)");

		if (!$request) {
           return [];
        }

        $date = new \DateTime(date('Y-m-d H:i:s'));
        /**
         * Où 'P12M' indique 'Période de 1 jour 1 day'
         */
        $date->add(new \DateInterval('P1D')); 
        $dateExp = $date->format('Y-m-d H:i:s');
        

        $user = $this->findUserByEmail($email);
        if (!$user) {
            return [];
        }
        
        $idUser = $user["id"];
        
		$arrayVar = array(
            'email' => $email,
            'code' => $code,
            'date_exp' => $dateExp,
            'id_user' => $idUser
		);
		
		$request->execute($arrayVar);

		$lastId = $this->db->lastInsertId();
		if (!$lastId) {
			return [];
		} 

        return $this->findCodeById($lastId);
    }


    /**
     * Cette methode sert à récupérer un code de mot de passe à partir de son id. Cette methode 
     * attend comme paramètre d'entree l'id du code et retoure le code de mot de passe 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param integer $idCode
     * @return array
     */
    public function findCodeById(int $idCode):array{


        if (!$idCode) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `code_pw` WHERE id=:id");


        if (!$request) {
           return [];
        }
		
		$arrayVar = array(
            'id' => $idCode,
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
     * Cette methode sert à récupérer un code de mot de passe à partir de son email. Cette methode 
     * attend comme paramètre d'entree l'email du code et retoure le code de mot de passe 
     * sous forme de tableau
     * 
     * l'id fourni en parametre est injecté dans la requete sql envoyée vers la base de 
     * données afin d'effectuer le tri de façon plus efficace
     *
     * @param strin $email
     * @return array
     */
    public function findCodeByEmail(string $email):array{


        if (!$email) {
			return [];
		} 
        
        $request = $this->db->prepare("SELECT * FROM `code_pw` WHERE email=:email");


        if (!$request) {
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
     * Cette methode sert à enregistrer la mise à jour d'un code de mot de passe dans 
     * la base de données. Elle attend comme paramètre d'entrée un tableau contenant les 
     * informations à enregistrer. Elle retourne un tableau qui est soit vide ou le nouveau 
     * code qui veint d'etre enregistré
     * 
     * On recupere le nouveau code enregistré en faisont appel à la methode
     * findCodeByEmail en utilisant l'email fourni à l'ntrée de la méthode
     *
     * @param string $email
     * @param string $code
     * @return array
     */
    public function updateCodePassword(string $email, string $code):array{
        
        if (!$email || !$code) {
            return [];
        }

        $today = date('Y-m-d H:i:s');

        $date = new \DateTime(date('Y-m-d H:i:s'));
        /**
         * Où 'P12M' indique 'Période de 12 Mois'
         */
        $date->add(new \DateInterval('P1D')); 
        $dateExp = $date->format('Y-m-d H:i:s');
        
        $request = $this->db->prepare("UPDATE `code_pw` 
                        SET `code`=:code, `updated_at`=:today, `date_exp`=:date_exp
                        WHERE email=:email");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'email' => $email,
            'code' => $code,
            'today' => $today,
            'date_exp' => $dateExp
		);
		
		$request->execute($arrayVar);

		if (!$request) {
			return [];
		} 

        return $this->findCodeByEmail($email);
    }


    /**
     * Cette methode sert à enregistrer la mise à jour d'un code de mot de passe dans 
     * la base de données. Elle attend comme paramètre d'entrée un tableau contenant les 
     * informations à enregistrer. Elle retourne un tableau qui est soit vide ou le nouveau 
     * code qui veint d'etre enregistré
     * 
     * On recupere le nouveau code enregistré en faisont appel à la methode
     * findCodeByEmail en utilisant l'email fourni à l'ntrée de la méthode
     *
     * @param string $email
     * @param  integer $idUser
     * @return array
     */
    public function updateEmailCodePassword(string $email, int $idUser):array{
        
        if (!$email || !$idUser) {
            return [];
        }
        
        $today = date('Y-m-d H:i:s');
        
        $request = $this->db->prepare("UPDATE `code_pw` 
                        SET `email`=:email, `updated_at`=:today
                        WHERE id_user=:id");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'email' => $email,
            'id' => $idUser,
            'today' => $today
		);
		
		$request->execute($arrayVar);

		if (!$request) {
			return [];
		} 

        return $this->findCodeByEmail($email);
    }


    /**
     * Cette methode sert à enregistrer la mise à jour du mot de passe d'un 
     * utilisateur dans la base de données.
     * Elle attend comme paramètre d'entrée le mot de passe à enregistrer et 
     * l'email de l'utilisateur. Elle retourne un tableau qui est soit vide ou 
     * le nouvel utilisateur qui vient d'etre enregistré
     * 
     * On recupere le nouvel utilisateur enregistré en faisont appel à la methode
     * find UserById en utilisant le dernier id inserver dans la table user
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function updatePassword(string $email, string $password):array{
        
        if (!$email || !$password) {
            return [];
        }
        
        $request = $this->db->prepare("UPDATE `user` 
                        SET `password`=:password1,`updated_at`=:updated_at 
                        WHERE email=:email");

		if (!$request) {
           return [];
        }
        
		$arrayVar = array(
            'password1' => md5($password),
            'email' => $email,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		
		$request->execute($arrayVar);

		if (!$request) {
			return [];
		} 
        
        return $this->findUserByEmail($email);
    }
}
