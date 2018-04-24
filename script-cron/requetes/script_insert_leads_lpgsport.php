<?php

//liste des sites sport
$arraysite = array('fr' => '',
    'en' => '3_'
);

//if($_GET['selectSite']=="endermologie"){

require ('Connexion_LPGSPORT.php');
require ('Connexion_boleads.php');

foreach($arraysite as $key => $unsite){
    $selectope = $unsite;

$date =    date("Y-m-d");
$requeteleadssites = "SELECT d.lead_id,d.field_number as field_number, d.value,f.date_created "
        . "FROM J96FQVw_" . $selectope . "rg_lead_detail d,J96FQVw_" . $selectope . "rg_lead f,  J96FQVw_" . $selectope . "rg_form fo  "
        . "WHERE fo.id = f.form_id and f.id = d.lead_id and fo.title in ('Contactez-nous') "
        . " and DATE_FORMAT(f.date_created,'%Y-%m-%d')  like  '".$date."' "
        . "order by d.lead_id,field_number asc";

var_dump($requeteleadssites);

$reqliste = Connexion_LPGSPORT::getInstance()->query($requeteleadssites);

if ($reqliste != null) {

    $comptage = 0;
    $stockidchamp = "";
    $requeteinsertion = "";
    $id_lead = "";
    $type_client = "";
    $civilite = "";
    $nom = "";
    $prenom = "";
    $email = "";
    $code_postal = "";
    $ville = "";
    $telephone = "";
    $pays = "";
    $profession = "";
    $sujet = "";
    $message = "";
    $date_created = "";
    $site_origine = "";

    foreach ($reqliste as $ligne => $valeur) {

        // si on change de contact 
        if ($stockidchamp != $valeur['lead_id'] && $stockidchamp != "") {
            $requeteinsertion .='INSERT INTO leads_lpg '
                    . ' (`type_client`, `civilite`, `nom`, `prenom`, `email`, `code_postal`, '
                    . ' `ville`, `telephone`, `pays`, `profession`, `sujet`, `message`, `date_created`, '
                    . '`site_origine`) VALUES ("' . $type_client . '","' . $civilite . '","' . $nom . '",'
                    . '"' . $prenom . '","' . $email . '","' . $code_postal . '","' . $ville . '",'
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","LPG SPORT");';
            $type_client = "";
            $civilite = "";
            $nom = "";
            $prenom = "";
            $email = "";
            $code_postal = "";
            $ville = "";
            $telephone = "";
            $pays = "";
            $profession = "";
            $sujet = "";
            $message = "";
            $date_created = "";
            if ($valeur['field_number'] == '8')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '17')
                $type_client = $valeur['value'];
            if ($valeur['field_number'] == '2')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '12')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '11')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '4')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '19'||$valeur['field_number'] == '15')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '20'|| $valeur['field_number'] == '16')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '21'||$valeur['field_number'] == '5')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '22'|| $valeur['field_number'] == '6')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '7'||$valeur['field_number'] == '18')
                $sujet = $valeur['value'];

            if ($valeur['field_number'] == '14')
                $profession = $valeur['value'];
            if ($valeur['date_created'])
                $date_created = $valeur['date_created'];
        }else {
          if ($valeur['field_number'] == '8')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '17')
                $type_client = $valeur['value'];
            if ($valeur['field_number'] == '2')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '12')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '11')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '4')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '19'||$valeur['field_number'] == '15')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '20'|| $valeur['field_number'] == '16')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '21'||$valeur['field_number'] == '5')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '22'|| $valeur['field_number'] == '6')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '7'||$valeur['field_number'] == '18')
                $sujet = $valeur['value'];

            if ($valeur['field_number'] == '14')
                $profession = $valeur['value'];
            if ($valeur['date_created'])
                $date_created = $valeur['date_created'];
        }
        $stockidchamp = $valeur['lead_id'];
    }
        if($email){
   $requeteinsertion .='INSERT INTO leads_lpg '
                    . ' (`type_client`, `civilite`, `nom`, `prenom`, `email`, `code_postal`, '
                    . ' `ville`, `telephone`, `pays`, `profession`, `sujet`, `message`, `date_created`, '
                    . '`site_origine`) VALUES ("' . $type_client . '","' . $civilite . '","' . $nom . '",'
                    . '"' . $prenom . '","' . $email . '","' . $code_postal . '","' . $ville . '",'
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","LPG SPORT");';

    var_dump($requeteinsertion);
    Connexion_boleads::getInstance()->query($requeteinsertion);
        }
}
}