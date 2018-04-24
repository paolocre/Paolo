<?php

require_once ('class/Mysql.php');
$info = "";
$db = new MySQL('172.16.44.1', "root", "ePia6cH3mb", "SL_TRACKING_SEARCH");

//ETAPE 1 : INSERTION DES NOUVEAUX CLIENTS
//on recupere la liste des nouveaux clients
$sqlinsert = "SELECT *  from LPG_ALL_CUSTOMER where PAGEPERSO_CUS NOT IN ( SELECT ID_FB from LPG_ALL_FACEBOOK)";
$reqinsert = $db->getCollection($sqlinsert);
$nbresults = count($reqinsert);


if ($nbresults > 0) {
    foreach ($reqinsert as $ajouterClient) {

  //ETAPE 2 : INSERTION LIGNE DANS TABLE FACEBOOK
        $sqlSearch="SELECT * FROM LPG_ALL_FACEBOOK where LOGIN_USR_FB='".$ajouterClient->ID_CUS."'";
        $reqSearch= $db->getCollection($sqlSearch);
        if ($reqSearch) {
             $date = date('y-m-d');
                $sqlfacebook ="INSERT INTO LPG_ALL_FACEBOOK (ID_FB,LOGIN_USR_FB,COUNTRY_FB,DATE_VALID_FB)"
                    . " VALUES (".$ajouterClient->PAGEPERSO_CUS.",'".$ajouterClient->ID_CUS."','".$ajouterClient-> COUNTRY_CUS."','".$date."')";
                $resultInsert = $db->query($sqlfacebook);
//                if($resultInsert)
//                {
//                      //ETAPE 3 : UPDATE LPG CUSTOMER BIS PAGE PERSO
//                    $sqlselect ="SELECT * from LPG_ALL_FACEBOOK where LOGIN_USR_FB='".$ajouterClient->ID_CUS."' and COUNTRY_FB ='".$ajouterClient-> COUNTRY_CUS."'";
//                    $info .= "requeteSelect : " . $sqlselect."\n";
//                    $idFacebook = $db->getCollection($sqlselect);
//                    $nbresultatsSelect=count($idFacebook);
//                    
//                    if($nbresultatsSelect > 0)
//                    {
//                        foreach($idFacebook as $fb){
//
//                            $sqlupdate= "UPDATE LPG_ALL_CUSTOMER SET PAGEPERSO_CUS = ".$fb->ID_FB." where ID_CUS=".$ajouterClient->ID_CUS." and ID_CUS2 = ".$ajouterClient->ID_CUS2." and COUNTRY_CUS='".$ajouterClient-> COUNTRY_CUS."'";
//                            $info .= "requeteUpdat : " . $sqlupdate."\n";
//                            $db->query($sqlupdate);
//                        }
//                    }
//
//                }
           
        $info .= "requete : " . $sqlfacebook."\n";
        }
    }
}


$db->close();


//STOCKER VISITE DE LA PAGE
$date = new DateTime(); //this returns the current date time
$result = $date->format('Y-m-d-H-i-s');
$file = '/var/www/vhosts/lpgsystems.com/www/webserv.lpgsystems.com/script-cron/files/scriptInsertFBDateBis' . $result . '.txt';
$info .= "transfert date de fin de script :";
$info .= "nombre d'insertion :" . $nbresults;

//file_put_contents($file, $info);
