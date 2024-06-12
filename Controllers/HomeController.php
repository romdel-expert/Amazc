<?php
namespace Controllers;


class HomeController{
    
    /**
     * Cette fonction du controller sert à récupérer les données necessaires 
     * et afficher la page d'accueil
     *
     * @return void
     */
    public function home(){
        $title = "Accueil Association Michel-Archange";
        require(ROOT ."/Views/home.php");
    }


    /**
     * Cette fonction du controller sert à récupérer les données necessaires 
     * et afficher les la page qui presente des informations à propose de 
     * l'association
     *
     * @return void
     */
    public function about(){
       $title = "A propos de Association Michel Archange Zéero chômage";
       require(ROOT . "/Views/home/about.php"); 
    }
}
