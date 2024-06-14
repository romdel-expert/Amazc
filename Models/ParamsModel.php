<?php
namespace Models;

use Models\Database;

class ParamsModel extends Database{


    
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Cette methode sert à récupérer les information concernant l'association 
     * elle n'attend aucune valeur en entree mais retoure un tableau avec toutes les informations
     * sous forme array. 
     * 
     * Un tableau vide est retourné en cas de non information ou si certaines choses se passent
     * mal au cours du processus
     *
     * @return array
     */
    public function getParams():array{
        
        $request = $this->db->prepare("SELECT * FROM amazc");

        if (!$request) {
            return [];
        }

        $request->execute();

        $data = $request->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
           return [];
        }


        return $data;
    }



    /**
     * Cette methode sert à recupérer le contenu du champs qui detaille l'a propos de l'association
     * et lancer la procedure d'enregistrement de ce contenu dans la base de données
     * 
     * suite à l'enregistrement on retourne les params dans un tableau array
     * un tableau vide est retourné si quelque chose se passe mal
     *
     * @param array $params
     * @return array
     */
    public function saveParams(array $params):array{
        if (!$params) {
            return [];
        }

        $request = "";
        
        $arrayVar = [];

        $mode = $params["mode"];
        if ($mode == "about") {
            
             $request = $this->db->prepare("UPDATE amazc SET `about`=:about WHERE `id`=:id");

             $arrayVar = array(
                "about" => str_replace("\n", "<br>", $params["about"]),
                "id" => $params["id"],
            );
        }elseif ($mode == "dna") {
            
             $request = $this->db->prepare("UPDATE amazc SET `dna`=:dna WHERE `id`=:id");

             $arrayVar = array(
                "dna" => str_replace("\n", "<br>", $params["dna"]),
                "id" => $params["id"],
            );
        }if ($mode == "committee") {
            
             $request = $this->db->prepare("UPDATE amazc SET `committee`=:committee WHERE `id`=:id");

             $arrayVar = array(
                "committee" => str_replace("\n", "<br>", $params["committee"]),
                "id" => $params["id"],
            );
        }

        if (!$request || !$arrayVar) {
            return [];
        }

        $request->execute($arrayVar);


        return $this->getParams();
    }
}
