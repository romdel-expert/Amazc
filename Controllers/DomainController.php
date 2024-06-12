<?php
namespace Controllers;


class DomainController{

    public function __construct(){
        
    }



    public function list(){
        $title = "Domaine d'activité";
        require(ROOT . "/Views/domains.php");
    }
}
