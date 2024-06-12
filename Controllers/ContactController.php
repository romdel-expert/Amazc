<?php
namespace Controllers;

class ContactController{

    public function __construct(){
        
    }



    public function form(){
        $title = "Formulaire de contact";
        require(ROOT . "/Views/contact.php");
    }
}
