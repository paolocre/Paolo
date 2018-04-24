<?php

require_once ('class/Mysql.php');
$info = "";
$db = new MySQL('172.16.44.1', "root", "ePia6cH3mb", "SL_TRACKING_SEARCH");

//ETAPE 1 : INSERTION DES NOUVEAUX CLIENTS
//on recupere la liste des nouveaux clients
$sqlinsert = "SELECT *  from DB_LPG_GLOBAL.LPG_ALL_CUSTOMER as DB"
        . " where DB.ID_CUS NOT IN "
        . " (SELECT SL.ID_CUS from SL_TRACKING_SEARCH.LPG_ALL_CUSTOMER as SL where SL.COUNTRY_CUS = DB.COUNTRY_CUS)";
$reqinsert = $db->getCollection($sqlinsert);
$nbresults = count($reqinsert);
$requte="";
if ($nbresults > 0) {
    foreach ($reqinsert as $ajouterClient) {
        $sqlajouter = "INSERT INTO LPG_ALL_CUSTOMER "
                . "(`ID_CUS`, `NAME_CUS`, `NAME2_CUS`, `ADDRESS1_CUS`, `ADDRESS2_CUS`, `ZIP_CUS`, `CITY_CUS`, "
                . "`TEL_CUS`, `MAIL_CUS`, `COUNTRY_CUS`, `PASSWORD_CUS`, `TYPE_CUS`, `STRUCTURE_CUST`, `JOB_CUS`, "
                . "`WEBSITE_CUS`, `PAGEPERSO_CUS`, `LIPOMASSAGE_CUS`, `LIPOMODELAGE_CUS`, `ENDERMOLIFT_CUS`, `ENDERMOLIFT2_CUS`, "
                . "`HML_NIV2_CUS`, `H360_NIV2_CUS`, `ENDERMOTHERAPIE_CUS`, `CANCERDUSEIN_CUS`, `KMI_CUS`, `KMS_CUS`, `KM2I_CUS`, "
                . "`KM2S_CUS`, `ENDERMOLAB_CUS`, `INTEGRAL_CUS`, `ENDERMOLAB_B_CUS`, `INTEGRAL_B_CUS`, `ERGODRIVE_I_CUS`, `MYLPGP_CUS`, `LIFT_M6`, `LIPO_M6`, `LIFT_6`, "
                . "`OLD_CELLU_CUS`, `HUBER_CUS`, `SPINEFORCE_CUS`, `HML_CUS`, `H360_CUS`, `TYPES_HML_CUS`, `E6_CUS`, `R6_CUS`, "
                . "`MOBILIFT_CUS`, `MOBILIFT_PHYSIO_CUS`, `WELLBOX_CUS`, `COSMETIC_CUS`, `ENDERMOSPA_CORNER_CUS`, `ENDERMOSPA_FULL_CUS`, "
                . "`ENDERMOSPA_MEDI_CUS`, `CERTIFIED_QUALITY_CUS`, `MVF_CUS`, `ACTIVELIFE_CUS`, `FORMATION_PRO_CUS`, `CERTIFIED_QUALITY_2011_CUS`, "
                . "`LATITUDE_CUS`, `LONGITUDE_CUS`, `HIDDEN_CUS`, `LOGINDST_CUS`, `EMAIL_TABLET`, `ACCES_TABLET`, `REF_CUS`, `ID_CUS2`, `LISTE_FORMATIONS_CUS`, `ACTIF_SITES_CUS`,`LISTE_FORMATIONS2_CUS`,`LISTE_APPAREILS2_CUS`)";
        $sqlajouter .=' VALUES (' . $ajouterClient->ID_CUS . ',"' .  str_replace("\"","",$ajouterClient->NAME_CUS) . '","' . str_replace("\"","",$ajouterClient->NAME2_CUS) . '","' . str_replace("\"","",$ajouterClient->ADDRESS1_CUS) . '", '
                . '"'. str_replace("\"","",$ajouterClient->ADDRESS2_CUS) . '","' . $ajouterClient->ZIP_CUS . '","' . str_replace("\"","",$ajouterClient->CITY_CUS) . '","' . $ajouterClient->TEL_CUS . '","'
                . "" . $ajouterClient->MAIL_CUS . '","' . $ajouterClient->COUNTRY_CUS . '","' . $ajouterClient->PASSWORD_CUS . '","' . $ajouterClient->TYPE_CUS . '","'
                . "" . $ajouterClient->STRUCTURE_CUST . '","' . $ajouterClient->JOB_CUS . '","' . $ajouterClient->WEBSITE_CUS . '",';
        
        if($ajouterClient->PAGEPERSO_CUS){
            $fb=$ajouterClient->PAGEPERSO_CUS;
        }else{
            $fb=0;
        }
        
        $sqlajouter .= $fb . ","
                . "" . $ajouterClient->LIPOMASSAGE_CUS . "," . $ajouterClient->LIPOMODELAGE_CUS . "," . $ajouterClient->ENDERMOLIFT_CUS . "," . $ajouterClient->ENDERMOLIFT2_CUS . ","
                . "" . $ajouterClient->HML_NIV2_CUS . "," . $ajouterClient->H360_NIV2_CUS . "," . $ajouterClient->ENDERMOTHERAPIE_CUS . ","
                . "" . $ajouterClient->CANCERDUSEIN_CUS . "," . $ajouterClient->KMI_CUS . "," . $ajouterClient->KMS_CUS . "," . $ajouterClient->KM2I_CUS . ","
                . "" . $ajouterClient->KM2S_CUS . "," . $ajouterClient->ENDERMOLAB_CUS . "," . $ajouterClient->INTEGRAL_CUS . "," . $ajouterClient->ENDERMOLAB_B_CUS . "," . $ajouterClient->INTEGRAL_B_CUS . "," . $ajouterClient->ERGODRIVE_I_CUS . ","
                . "" . $ajouterClient->MYLPGP_CUS . "," . $ajouterClient->LIFT_M6 . "," . $ajouterClient->LIPO_M6 . "," . $ajouterClient->LIFT_6 . ","
                . "" . $ajouterClient->OLD_CELLU_CUS . ",";
        if ($ajouterClient->HUBER_CUS == null) {
            $sqlajouter.= 0;
        } else {
            $sqlajouter.= $ajouterClient->HUBER_CUS;
        }

        $sqlajouter.="," . $ajouterClient->SPINEFORCE_CUS . "," . $ajouterClient->HML_CUS . ","
                . "" . $ajouterClient->H360_CUS . ",";
        if($ajouterClient->TYPES_HML_CUS){
            $hml = $ajouterClient->TYPES_HML_CUS;
        }else{
            $hml=0;
        }
        $sqlajouter.= $hml . "," . $ajouterClient->E6_CUS . "," . $ajouterClient->R6_CUS . ","
                . "" . $ajouterClient->MOBILIFT_CUS . "," . $ajouterClient->MOBILIFT_PHYSIO_CUS . "," . $ajouterClient->WELLBOX_CUS . ",";
        
        
        if($ajouterClient->COSMETIC_CUS)
        {
            $cosm=1;
        } else{
            $cosm=0;
        }       
        $sqlajouter.= "" . $cosm . "," . $ajouterClient->ENDERMOSPA_CORNER_CUS . "," . $ajouterClient->ENDERMOSPA_FULL_CUS . ","
                . "" . $ajouterClient->ENDERMOSPA_MEDI_CUS . "," . $ajouterClient->CERTIFIED_QUALITY_CUS . "," . $ajouterClient->MVF_CUS . ",";
         if ($ajouterClient->ACTIVELIFE_CUS == null) {
            $sqlajouter.= 0 .",";
        } else {
            $sqlajouter.= $ajouterClient->ACTIVELIFE_CUS.",";
        }

        $sqlajouter .= $ajouterClient->FORMATION_PRO_CUS . ",";
        if ($ajouterClient->CERTIFIED_QUALITY_2011_CUS == null) {
            $sqlajouter.= 0;
        } else {
            $sqlajouter.= $ajouterClient->CERTIFIED_QUALITY_2011_CUS;
        }
        $sqlajouter.=","
                . "'" . $ajouterClient->LATITUDE_CUS . "','" . $ajouterClient->LONGITUDE_CUS . "'," . $ajouterClient->HIDDEN_CUS . ",'" . $ajouterClient->LOGINDST_CUS . "','"
                . "" . $ajouterClient->EMAIL_TABLET . "'," . $ajouterClient->ACCES_TABLET . "," . $ajouterClient->REF_CUS 
                . "," . $ajouterClient->ID_CUS2 
                . ",'" . $ajouterClient->LISTE_FORMATIONS_CUS 
                . "'," . $ajouterClient->ACTIF_SITES_CUS 
                . ",'" . $ajouterClient->LISTE_FORMATIONS2_CUS 
                . "','".$ajouterClient->LISTE_APPAREILS2_CUS."');";

        $info .= "requete : " . $sqlajouter."\n";
        $requte .=$sqlajouter;
        $resultat = $db->query($sqlajouter);

    }
}

$db->close();
//echo $nbresults;
//
////STOCKER VISITE DE LA PAGE
//$date = new DateTime(); //this returns the current date time
//$result = $date->format('Y-m-d-H-i-s');
//$file = '/var/www/vhosts/lpgsystems.com/www/webserv.lpgsystems.com/script-cron/files/scriptDateInsertCust' . $result . '.txt';
//$info .= "transfert date de fin de script :";
//$info .= "nombre d'insertion :" . $requte;
////
//file_put_contents($file, $info);
