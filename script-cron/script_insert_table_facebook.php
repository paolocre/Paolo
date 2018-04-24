<?php

require_once ('class/Mysql.php');
$info = "";
$db = new MySQL('172.16.44.1', "root", "ePia6cH3mb", "SL_TRACKING_SEARCH");

//ETAPE 1 : INSERTION DES NOUVEAUX CLIENTS
//on recupere la liste des nouveaux clients
$sqlinsert = "SELECT *  from LPG_ALL_CUSTOMER where PAGEPERSO_CUS = 0 or PAGEPERSO_CUS = 1";
$reqinsert = $db->getCollection($sqlinsert);
$nbresults = count($reqinsert);
$db->close();

if ($nbresults > 0) {
    foreach ($reqinsert as $ajouterClient) {
$db = new MySQL('172.16.44.1', "root", "ePia6cH3mb", "SL_TRACKING_SEARCH");
  //ETAPE 2 : INSERTION LIGNE DANS TABLE FACEBOOK
        $sqlSearch="SELECT * FROM LPG_ALL_FACEBOOK where LOGIN_USR_FB='".$ajouterClient->ID_CUS."' and COUNTRY_FB = '".$ajouterClient->COUNTRY_CUS."'";
        $reqSearch= $db->getCollection($sqlSearch);
        if($reqSearch == null || empty($reqSearch) || $reqSearch ==0 || !$reqSearch){
            $nbresultsinsert=0;
        }else{
            $nbresultsinsert = count($reqSearch);
        }
        
        $info .= "nb seleect:".$nbresultsinsert." ".$sqlSearch;
        if ($nbresultsinsert == 0 ) {
                $sqlfacebook ="INSERT INTO LPG_ALL_FACEBOOK (LOGIN_USR_FB,COUNTRY_FB)"
                    . " VALUES ('".$ajouterClient->ID_CUS."','".$ajouterClient-> COUNTRY_CUS."')";
                $resultInsert = $db->query($sqlfacebook);
                        $info .= "requeteInsert : " . $sqlfacebook."\n";
                if($resultInsert)
                {
                      //ETAPE 3 : UPDATE LPG CUSTOMER BIS PAGE PERSO
                    $sqlselect ="SELECT * from LPG_ALL_FACEBOOK where LOGIN_USR_FB='".$ajouterClient->ID_CUS."' and COUNTRY_FB ='".$ajouterClient-> COUNTRY_CUS."'";
                    $info .= "requeteSelect : " . $sqlselect."\n";
                    $idFacebook = $db->getCollection($sqlselect);
                    $nbresultatsSelect=count($idFacebook);
                    
                    if($nbresultatsSelect > 0)
                    {
                        foreach($idFacebook as $fb){

                            $sqlupdate= "UPDATE LPG_ALL_CUSTOMER SET PAGEPERSO_CUS = ".$fb->ID_FB." where ID_CUS=".$ajouterClient->ID_CUS." and COUNTRY_CUS='".$ajouterClient-> COUNTRY_CUS."'";
                            $info .= "requeteUpdat : " . $sqlupdate."\n";
                            $db->query($sqlupdate);
                        }
                    }

                }
           
        $info .= "requete : " . $sqlfacebook."\n";
        }else{
            //update de page perso all customer
            $sqlupdate= "UPDATE LPG_ALL_CUSTOMER SET PAGEPERSO_CUS = ".$reqSearch->ID_FB." where ID_CUS=".$ajouterClient->ID_CUS." and COUNTRY_CUS='".$ajouterClient-> COUNTRY_CUS."'";
                            $info .= "requeteUpdat : " . $sqlupdate."\n";
                            $db->query($sqlupdate);
        }
        $db->close();
    }
}





//STOCKER VISITE DE LA PAGE
//$date = new DateTime(); //this returns the current date time
//$result = $date->format('Y-m-d-H-i-s');
//$file = '/var/www/vhosts/lpgsystems.com/www/webserv.lpgsystems.com/script-cron/files/scriptInsertFBDate' . $result . '.txt';
//$info .= "transfert date de fin de script :";
//$info .= "nombre d'insertion :" . $nbresults;
//
//file_put_contents($file, $info);
