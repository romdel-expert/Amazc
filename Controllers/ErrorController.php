<?php

namespace Controllers;


class ErrorController{
    
    public function show(){
        $title = "Erreur";
        require (ROOT . "/Views/error.php");
    }
}
