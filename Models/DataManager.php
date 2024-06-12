<?php
namespace Models;

class DataManager{


    static $API_KEY = "AIzaSyA_BAG4LPfUj1CjxznPLAYruX6Egxlxn_0";

    public static $QUANTITY_ORDER_BAY_PAGE = 12;
    

    /**
     * Cette fonction sert à gérer le formatage d'une chaine de caractère afin de 
     * metre en forme les chaine avec des caractère spéciaux, les espaces, les 
     * apostrophe etc
     * 
     * Elle attend comme paramètre d'entrée la chaine de caractères à formater et 
     * retourne le resultat du formatage
     * 
     * Cela permet d'eviter d'avoir des erreur et le formattage est réalisé avant 
     * l'enregistrement des données dans la base de données
     *
     * @param string $input
     * @return string
     */
    public static function mysqlEscapeMimic(string $input):string {

        if(is_array($input))

            return array_map(__METHOD__, $input);



        if(!empty($input) && is_string($input)) {

            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $input);

        }



        return $input;

    }





    /**
     * Cette function sert à extraire toutes les donnnées concernant un adresse
     * Elle attend en entrée une adresse sous forme de chaine de caracteres et 
     * faire   ppel au service de google afin de récupérer toutes les données 
     * qui compose l'adresse, elle retourne un tableau avec toutes les données 
     * de l'adresse
     *
     * @param string $adr
     * @return array
     */
    public static function getInfosAddress(string $adr):array{
        
        
        if ($adr) {
            
            $url = "https://maps.google.com/maps/api/geocode/json?key=" . self::$API_KEY . "&address=" . str_replace(" ", "+", $adr) . "&sensor=false";

            /**
             * send  GET / POT / POST request to resource
             */
            $req=curl_init($url);
            
            curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);

            /**
             * get respnse from resource
             */
            $response=curl_exec($req);
        
            if($response){
                /**
                 * decode the response
                 */
                $result=json_decode($response);
                if(!$result->results){
                    return [];
                }
                $addressComponent = $result->results[0]->address_components;
                $street_number = "";
                $route = "";
                $city = "";
                $department = "";
                $area = "";
                $country = "";
                $country_code = "";
                $zip_code = 0;
                $format_address = $result->results[0]->formatted_address;
                $longitude = $result->results[0]->geometry->location->lng;
                $latitude = $result->results[0]->geometry->location->lat;
                for ($i=0; $i < count($addressComponent); $i++) { 
                    if ($addressComponent[$i]->types[0] == "administrative_area_level_1" && $addressComponent[$i]->types[1] == "political") {
                        $area = $addressComponent[$i]->long_name;    
                    }
                    if ($addressComponent[$i]->types[0] == "administrative_area_level_2" && $addressComponent[$i]->types[1] == "political") {
                        $department = $addressComponent[$i]->long_name;    
                    }
                    if ($addressComponent[$i]->types[0] == "locality" && $addressComponent[$i]->types[1] == "political") {
                        $city = $addressComponent[$i]->long_name;    
                    }
                    if ($addressComponent[$i]->types[0] == "postal_code") {
                        $zip_code = $addressComponent[$i]->long_name;    
                    }
                    if ($addressComponent[$i]->types[0] == "country") {
                        $country = $addressComponent[$i]->long_name; 
                        $country_code = $addressComponent[$i]->short_name;    
                    }
                    if ($addressComponent[$i]->types[0] == "street_number") {
                        $street_number = $addressComponent[$i]->long_name;    
                    }
                    if ($addressComponent[$i]->types[0] == "route") {
                        $route = $addressComponent[$i]->long_name;    
                    }
                }
                return array(
                    "street_number" => $street_number,
                    "route" => $route,
                    "city" => $city,
                    "department" => $department,
                    "area" => $area,
                    "country" => $country,
                    "country_code" => $country_code,
                    "zip_code" => $zip_code,
                    "format_address" => $format_address,
                    "longitude" => $longitude,
                    "latitude" => $latitude
                );
            }else{
                return [];
            }
        }else{
            return [];
        }
    }



    /**
     * Cette methode static peremet de faire l'affectation des données 
     * correspondant à un utilisateur. 
     * 
     * Elle attend comme valeur d'entrée un tableau array contenant les valeurs
     * et ne retourne pas de valeur apres les operation effectuées
     *
     * @param array $params
     * @return void
     */
    public static function setDataUser(array $params){
        $fName = $params['f_name'];
        $lName = $params['l_name'];
        $genre = $params['genre'];
        $email = $params['email'];
        $phone = $params['phone'];
        $address = $params['address'];
    }
    
    
    
    
    
    /**
     * Cette fonction permet de generer un code contenant une succession de 8 chiffres
     * Ce code est composé avec des chiffre triés au hasard grace à la fonction rand
     * qui permet de faire des selections aléatoires afin de creer un code different à chaque
     * demande
     * 
     *
     * @return string
     */
    public static function constructCode():string{
        $code = "";
        
        srand((int)microtime()*1000000);
        $list_caract=array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        $string_lengh = 8;
        $counter = 1;
        
        while ($counter<=$string_lengh){
            $code = $code.$list_caract[rand(0, count($list_caract)-1)];
            $counter += 1;
        }

        if(!$code){
            return "";
        }
        
       
        return $code;
    }
    
    
    
   
    /**
     * Cette methode sert à envoyer un message par email vers un destinataire
     * 
     * Cette attend comme valeur d'entrée,l'email du destinataire, le sujet du message
     * et le contenu du message. Elle retourne un boolean qui peut etre true ou false en 
     * fonction de la manière dont les choses se sobt dérolées 
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @return boolean
     */
    public static function sendContactEmail(string $to, string $subject, string $message):bool{

        if (!$to || !$subject || !$message) {
            return false;
        }
        
        
        $admContact = "associationmichelarchange@outlook.fr";
        
        $headers = "MIME-Version: 1.0"."\r\n";
        $headers.="Content-Type: text/html; charset=UTF-8"."\r\n";
        $headers .= "From: amazc@amazc.fr"."\r\n";
        
        if ($to != $admContact) {

            $headers .= "Cc: ".$admContact."\r\n"; // Copie Cc
        }
        
        if(!$to || !$subject || !$message){
            return false;
        }  

        if(mail($to, $subject, $message, $headers)){
            return true;
        }
        
        return false;
    }
}
