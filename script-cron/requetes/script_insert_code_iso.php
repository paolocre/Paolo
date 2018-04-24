<?php

//liste des sites MEDICAL

require ('Connexion_boleads.php');

    

//autres sites
$requetecodeiso = "update `leads_lpg` l, `pays` p set l.code_iso = p.code_iso where l.pays =p.pays and l.code_iso = '' and l.site_origine != 'medical'";


//lpg medical
$requetecodeisomedical = "update `leads_lpg` set code_iso = UPPER(pays) where code_iso = '' and site_origine = 'medical' ";



Connexion_boleads::getInstance()->query($requetecodeiso);
Connexion_boleads::getInstance()->query($requetecodeisomedical);

