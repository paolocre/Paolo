<?php

require_once ('class/Mysql.php');
$info = "";
$db = new MySQL('172.16.44.1', "root", "ePia6cH3mb", "SL_TRACKING_SEARCH");

//VARIABLES
//$tabInsertFb= array();
//ETAPE 1 : INSERTION DES NOUVEAUX CLIENTS
//on recupere la liste des nouveaux clients
$sqlinsert = "SELECT *
FROM LPG_ALL_CUSTOMER
WHERE ID_CUS2 NOT
IN (

SELECT ID_CUS2
FROM DB_LPG_GLOBAL.LPG_ALL_CUSTOMER
)
AND ID_CUS NOT
IN (

SELECT ID_CUS
FROM DB_LPG_GLOBAL.LPG_ALL_CUSTOMER
)";
$reqinsert = $db->getCollection($sqlinsert);
$nbresults = count($reqinsert);


if ($nbresults > 0) {
    foreach ($reqinsert as $ajouterClient) {

//        array_push($tabInsertFb,$ajouterClient);
        $sqlajouter = "UPDATE LPG_ALL_CUSTOMER SET REF_CUS =0 where ID_CUS = ".$ajouterClient->ID_CUS." and ID_CUS2=".$ajouterClient->ID_CUS2." and COUNTRY_CUS='".$ajouterClient->COUNTRY_CUS."'";

        $info .= "requete DROP : " . $sqlajouter."\n";
        $resultat = $db->query($sqlajouter);

    }
}

$db->close();


//STOCKER VISITE DE LA PAGE
//$date = new DateTime(); //this returns the current date time
//$result = $date->format('Y-m-d-H-i-s');
//$file = '/var/www/vhosts/lpgsystems.com/www/webserv.lpgsystems.com/script-cron/files/scriptDropDate' . $result . '.txt';
//$info .= "transfert date de fin de script :";
//$info .= "nombre de drop :" . $nbresults;

//file_put_contents($file, $info);
