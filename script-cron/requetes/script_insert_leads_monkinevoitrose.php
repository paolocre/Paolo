<?php

require ('Connexion_MONKINEVOITROSE.php');
require ('Connexion_boleads.php');




$date = date("Y-m-d");

//$date = "2017-12-28";

$requeteleadssites = "SELECT
DATE_FORMAT(FROM_UNIXTIME(submit_time), '%Y-%m-%d  %H:%i:%s') AS Submitted,
MAX(IF(field_name='your-name', field_value, NULL )) AS 'Name',
MAX(IF(field_name='your-message', field_value, NULL )) AS 'Message',
MAX(IF(field_name='your-email', field_value, NULL )) AS 'Email',
MAX(IF(field_name='your-subject', field_value, NULL )) AS 'Sujet'
FROM wp_LPG_cf7dbplugin_submits
WHERE form_name='Contact'
and DATE_FORMAT(FROM_UNIXTIME(submit_time),'%Y-%m-%d')  like  '".$date."' 
GROUP BY submit_time
ORDER BY submit_time DESC";

//var_dump($requeteleadssites);

$reqliste = Connexion_MONKINEVOITROSE::getInstance()->query($requeteleadssites);

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

    foreach ($reqliste as $key=>$valeur) {

        $message = $valeur['Message'];
        $nom = $valeur['Name'];
        $email = $valeur['Email'];
        $sujet = $valeur['Sujet'];
        $date_created = $valeur['Submitted'];
        $requeteinsertion ='INSERT INTO leads_lpg '
                . ' ( `nom`,`email`,`pays`, `sujet`, `message`, `date_created`, '
                . '`site_origine`) VALUES ("' . $nom . '","' . $email . '","France","' . htmlspecialchars($sujet) . '","' . htmlspecialchars(addslashes($message)) . '","' . $date_created . '","monkinevoitrose");';
        
        var_dump($requeteinsertion);
        Connexion_boleads::getInstance()->query($requeteinsertion);
    }
}


