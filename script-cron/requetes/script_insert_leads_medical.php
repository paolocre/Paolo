<?php

//liste des sites MEDICAL
$arraysite = array('fr' => '9',
    'en' => '5',
    'nl' => '4' 
);

require ('Connexion_MEDICAL.php');
require ('Connexion_boleads.php');

foreach ($arraysite as $key => $unsite){
$selectope = $unsite;
    

$date =      date("Y-m-d");   

$requeteleadssites = "SELECT d.post_id,d.meta_key,d.meta_value,f.post_date "
        . "FROM lpg_" . $selectope . "_posts f,lpg_" . $selectope . "_postmeta d "
        . "WHERE f.ID = d.post_id and  f.post_type in ('contact') "
        . " and DATE_FORMAT(f.post_date,'%Y-%m-%d')  like  '".$date."' "
        . "order by d.post_id asc";

var_dump($requeteleadssites);

$reqliste = Connexion_MEDICAL::getInstance()->query($requeteleadssites);

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
        if ($stockidchamp != $valeur['post_id'] && $stockidchamp != "") {
            $requeteinsertion .='INSERT INTO leads_lpg '
                    . ' (`type_client`, `civilite`, `nom`, `prenom`, `email`, `code_postal`, '
                    . ' `ville`, `telephone`, `pays`, `profession`, `sujet`, `message`, `date_created`, '
                    . '`site_origine`) VALUES ("' . $type_client . '","' . $civilite . '","' . $nom . '",'
                    . '"' . $prenom . '","' . $email . '","' . $code_postal . '","' . $ville . '",'
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","medical");';
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
            if ($valeur['meta_key'] == 'message')
                $message = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'contact_type')
                $type_client = $valeur['value'];
            if ($valeur['meta_key'] == 'sex')
                $civilite = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'lastname')
                $nom = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'firstname')
                $prenom = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'email')
                $email =$valeur['meta_value'];
            if ($valeur['meta_key'] == 'cp' )
                $code_postal = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'town' )
                $ville = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'phone' )
                $telephone =$valeur['meta_value'];
            if ($valeur['meta_key'] == 'country' )
                $pays = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'subject' )
                $sujet = $valeur['meta_value'];

            if ($valeur['meta_key'] == 'job')
                $profession = $valeur['meta_value'];
            if ($valeur['post_date'])
                $date_created = $valeur['post_date'];
        }else {
                  if ($valeur['meta_key'] == 'message')
                $message = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'contact_type')
                $type_client = $valeur['value'];
            if ($valeur['meta_key'] == 'sex')
                $civilite = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'lastname')
                $nom = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'firstname')
                $prenom = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'email')
                $email =$valeur['meta_value'];
            if ($valeur['meta_key'] == 'cp' )
                $code_postal = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'town' )
                $ville = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'phone' )
                $telephone =$valeur['meta_value'];
            if ($valeur['meta_key'] == 'country' )
                $pays = $valeur['meta_value'];
            if ($valeur['meta_key'] == 'subject' )
                $sujet = $valeur['meta_value'];

            if ($valeur['meta_key'] == 'job')
                $profession = $valeur['meta_value'];
            if ($valeur['post_date'])
                $date_created = $valeur['post_date'];
        }
        $stockidchamp = $valeur['post_id'];
    }
    if($email){
       $requeteinsertion .='INSERT INTO leads_lpg '
                    . ' (`type_client`, `civilite`, `nom`, `prenom`, `email`, `code_postal`, '
                    . ' `ville`, `telephone`, `pays`, `profession`, `sujet`, `message`, `date_created`, '
                    . '`site_origine`) VALUES ("' . $type_client . '","' . $civilite . '","' . $nom . '",'
                    . '"' . $prenom . '","' . $email . '","' . $code_postal . '","' . $ville . '",'
                    . '"' . $telephone . '","' . $pays . '","' . $profession . '","' . $sujet . '","' . addslashes($message) . '","' . $date_created . '","medical");';

    var_dump($requeteinsertion);
    Connexion_boleads::getInstance()->query($requeteinsertion);
    }
}
}