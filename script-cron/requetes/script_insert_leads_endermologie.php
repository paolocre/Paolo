<?php

//liste des sites endermo
$arraysite = array('fr' => '49',
    'en' => '42',
    'es' => '53',
    'nl' => '56',
    'it' => '59',
    'ru' => '62',
    'tr' => '65',
    'ar' => '69',
    'us' => '72',
    'de' => '75',
    'zh' => '78'
);

//if($_GET['selectSite']=="endermologie"){

require ('Connexion_ENDERMOLOGIE.php');
require ('Connexion_boleads.php');


foreach($arraysite as $key => $unsite){
    $selectope = $unsite;

;
$date =     date("Y-m-d");    
    
$requeteleadssites = "SELECT d.lead_id,d.field_number as field_number, d.value,f.date_created "
        . "FROM eNen9fYZ3_" . $selectope . "_rg_lead_detail d,eNen9fYZ3_" . $selectope . "_rg_lead f,  eNen9fYZ3_" . $selectope . "_rg_form fo  "
        . "WHERE fo.id = f.form_id and f.id = d.lead_id and fo.title in ('Contactez-nous') "
        . " and DATE_FORMAT(f.date_created,'%Y-%m-%d') like  '".$date."' "
        . "order by d.lead_id,field_number asc";

var_dump($requeteleadssites);

$reqliste = Connexion_ENDERMOLOGIE::getInstance()->query($requeteleadssites);

if ($reqliste != null && isset($reqliste) && $reqliste!=" " && count($reqliste) > 0 && !empty($reqliste)) {

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
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","endermologie");';
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
            if ($valeur['field_number'] == '2')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '20')
                $type_client = $valeur['value'];
            if ($valeur['field_number'] == '13')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '8.6')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '8.3')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '9')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '21.5' || $valeur['field_number'] == '15.5' || $valeur['field_number'] == '22.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '21.3' || $valeur['field_number'] == '22.3' || $valeur['field_number'] == '15.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '25' || $valeur['field_number'] == '16' || $valeur['field_number'] == '17')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '26' || $valeur['field_number'] == '18')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '12' || $valeur['field_number'] == '19')
                $sujet = $valeur['value'];

            if ($valeur['field_number'] == '17')
                $profession = $valeur['value'];
            if ($valeur['date_created'])
                $date_created = $valeur['date_created'];
        }else {
            if ($valeur['field_number'] == '2')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '20')
                $type_client = $valeur['value'];
            if ($valeur['field_number'] == '13')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '8.6')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '8.3')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '9')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '21.5' || $valeur['field_number'] == '15.5' || $valeur['field_number'] == '22.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '21.3' || $valeur['field_number'] == '22.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '25' || $valeur['field_number'] == '16')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '26' || $valeur['field_number'] == '18')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '12' || $valeur['field_number'] == '19')
                $sujet = $valeur['value'];

            if ($valeur['field_number'] == '17')
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
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","endermologie");';
    var_dump($requeteinsertion);
    Connexion_boleads::getInstance()->query($requeteinsertion);
         
    }
}
//EXPORT FORMILAIRE CELLU M6
$requeteleadssites = "SELECT d.lead_id,d.field_number as field_number, d.value,f.date_created "
        . "FROM eNen9fYZ3_" . $selectope . "_rg_lead_detail d,eNen9fYZ3_" . $selectope . "_rg_lead f,  eNen9fYZ3_" . $selectope . "_rg_form fo  "
        . "WHERE fo.id = f.form_id and f.id = d.lead_id and fo.title in ('Cellu M6') "
        . " and DATE_FORMAT(f.date_created,'%Y-%m-%d') like  '".date("Y-m-d")."' "
        . "order by d.lead_id,field_number asc";

var_dump($requeteleadssites);

$reqliste1 = Connexion_ENDERMOLOGIE::getInstance()->query($requeteleadssites);

if ($reqliste1 != null && isset($reqliste1) && $reqliste1!=" " && count($reqliste1) > 0 && !empty($reqliste1)) {

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

    foreach ($reqliste1 as $ligne => $valeur) {

        // si on change de contact 
        if ($stockidchamp != $valeur['lead_id'] && $stockidchamp != "") {
            $requeteinsertion .='INSERT INTO leads_lpg '
                    . ' (`type_client`, `civilite`, `nom`, `prenom`, `email`, `code_postal`, '
                    . ' `ville`, `telephone`, `pays`, `profession`, `sujet`, `message`, `date_created`, '
                    . '`site_origine`) VALUES ("' . $type_client . '","' . $civilite . '","' . $nom . '",'
                    . '"' . $prenom . '","' . $email . '","' . $code_postal . '","' . $ville . '",'
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes ($message) . '","' . $date_created . '","endermologie");';
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
            if ($valeur['field_number'] == '2')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '20')
                $type_client = $valeur['value'];
            if ($valeur['field_number'] == '13')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '8.6')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '8.3')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '9')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '21.5' || $valeur['field_number'] == '15.5' || $valeur['field_number'] == '22.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '21.3' || $valeur['field_number'] == '22.3' || $valeur['field_number'] == '15.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '17')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '18')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '12' || $valeur['field_number'] == '19')
                $sujet = $valeur['value'];

            if ($valeur['field_number'] == '14')
                $profession = $valeur['value'];
            if ($valeur['date_created'])
                $date_created = $valeur['date_created'];
        }else {
            if ($valeur['field_number'] == '2')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '20')
                $type_client = $valeur['value'];
            if ($valeur['field_number'] == '13')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '8.6')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '8.3')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '9')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '21.5' || $valeur['field_number'] == '15.5' || $valeur['field_number'] == '22.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '21.3' || $valeur['field_number'] == '22.3' || $valeur['field_number'] == '15.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '17')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '18')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '12' || $valeur['field_number'] == '19')
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
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","endermologie");';
    var_dump($requeteinsertion);
    Connexion_boleads::getInstance()->query($requeteinsertion);
         
    }
}

//EXPORT FORMULAIRE MOBILIFT
$requeteleadssites = "SELECT d.lead_id,d.field_number as field_number, d.value,f.date_created "
        . "FROM eNen9fYZ3_" . $selectope . "_rg_lead_detail d,eNen9fYZ3_" . $selectope . "_rg_lead f,  eNen9fYZ3_" . $selectope . "_rg_form fo  "
        . "WHERE fo.id = f.form_id and f.id = d.lead_id and fo.title in ('Mobilift M6®') "
        . " and DATE_FORMAT(f.date_created,'%Y-%m-%d') like  '".date("Y-m-d")."' "
        . "order by d.lead_id,field_number asc";

var_dump($requeteleadssites);

$reqliste2 = Connexion_ENDERMOLOGIE::getInstance()->query($requeteleadssites);

if ($reqliste2 != null && isset($reqliste2) && $reqliste2!=" " && count($reqliste2) > 0 && !empty($reqliste2)) {

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

    foreach ($reqliste2 as $ligne => $valeur) {

        // si on change de contact 
        if ($stockidchamp != $valeur['lead_id'] && $stockidchamp != "") {
            $requeteinsertion .='INSERT INTO leads_lpg '
                    . ' (`type_client`, `civilite`, `nom`, `prenom`, `email`, `code_postal`, '
                    . ' `ville`, `telephone`, `pays`, `profession`, `sujet`, `message`, `date_created`, '
                    . '`site_origine`) VALUES ("' . $type_client . '","' . $civilite . '","' . $nom . '",'
                    . '"' . $prenom . '","' . $email . '","' . $code_postal . '","' . $ville . '",'
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","endermologie");';
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
            if ($valeur['field_number'] == '2')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '12')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '25.6')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '25.3')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '9')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '24.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '24.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '23')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '26')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '13')
                $profession = $valeur['value'];
            if ($valeur['field_number'] == '14') {
                $sujet = $valeur['value'];
            };
            if ($valeur['date_created'])
                $date_created = $valeur['date_created'];
        }else {
            if ($valeur['field_number'] == '2')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '12')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '25.6')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '25.3')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '9')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '24.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '24.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '23')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '26')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '13')
                $profession = $valeur['value'];
            if ($valeur['field_number'] == '14') {
                $sujet = $valeur['value'];
            };
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
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","endermologie");';
    var_dump($requeteinsertion);
    Connexion_boleads::getInstance()->query($requeteinsertion);
         
    }
}

//EXPORT FORMULAIRE Formation Contact occasion & Formation Inscription
$requeteleadssites = "SELECT d.lead_id,d.field_number as field_number, d.value,f.date_created "
        . "FROM eNen9fYZ3_" . $selectope . "_rg_lead_detail d,eNen9fYZ3_" . $selectope . "_rg_lead f,  eNen9fYZ3_" . $selectope . "_rg_form fo  "
        . "WHERE fo.id = f.form_id and f.id = d.lead_id and fo.title in ('Formation Inscription','Contact occasion') "
        . " and DATE_FORMAT(f.date_created,'%Y-%m-%d')  like  '".date("Y-m-d")."' "
        . "order by d.lead_id,field_number asc";

var_dump($requeteleadssites);

$reqliste3 = Connexion_ENDERMOLOGIE::getInstance()->query($requeteleadssites);

//echo("test".$reqliste);
if ($reqliste3 != null && isset($reqliste3) && $reqliste3 != "" && count($reqliste3) != 0 && !empty($reqliste3) && $reqliste3 !=false) {
    
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

    foreach ($reqliste3 as $ligne => $valeur) {

        // si on change de contact 
        if ($stockidchamp != $valeur['lead_id'] && $stockidchamp != "") {
            if (!$sujet) {
                $sujet = "Formation";
            };
            $requeteinsertion .='INSERT INTO leads_lpg '
                    . ' (`type_client`, `civilite`, `nom`, `prenom`, `email`, `code_postal`, '
                    . ' `ville`, `telephone`, `pays`, `profession`, `sujet`, `message`, `date_created`, '
                    . '`site_origine`) VALUES ("' . $type_client . '","' . $civilite . '","' . $nom . '",'
                    . '"' . $prenom . '","' . $email . '","' . $code_postal . '","' . $ville . '",'
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","endermologie");';
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
            if ($valeur['field_number'] == '3')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '11' || $valeur['field_number'] == '13')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '1.3')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '1.6')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '5')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '13.5' || $valeur['field_number'] == '14.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '13.3' || $valeur['field_number'] == '14.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '6')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '18' || $valeur['field_number'] == '16')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '10')
                $profession = $valeur['value'];
            if ($valeur['field_number'] == '15') {
                $sujet = $valeur['value'];
            };
            if ($valeur['date_created'])
                $date_created = $valeur['date_created'];
        }else {
            if ($valeur['field_number'] == '3')
                $message = $valeur['value'];
            if ($valeur['field_number'] == '11' || $valeur['field_number'] == '13')
                $civilite = $valeur['value'];
            if ($valeur['field_number'] == '1.3')
                $nom = $valeur['value'];
            if ($valeur['field_number'] == '1.6')
                $prenom = $valeur['value'];
            if ($valeur['field_number'] == '5')
                $email = $valeur['value'];
            if ($valeur['field_number'] == '13.5' || $valeur['field_number'] == '14.5')
                $code_postal = $valeur['value'];
            if ($valeur['field_number'] == '13.3' || $valeur['field_number'] == '14.3')
                $ville = $valeur['value'];
            if ($valeur['field_number'] == '6')
                $telephone = $valeur['value'];
            if ($valeur['field_number'] == '18' || $valeur['field_number'] == '16')
                $pays = $valeur['value'];
            if ($valeur['field_number'] == '10')
                $profession = $valeur['value'];
            if ($valeur['field_number'] == '15') {
                $sujet = $valeur['value'];
            };
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
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","endermologie");';
    var_dump($requeteinsertion);
    Connexion_boleads::getInstance()->query($requeteinsertion);
         
    }
    
}
}
