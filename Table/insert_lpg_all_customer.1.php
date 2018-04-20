<?php

ini_set('memory_limit','-1'); // activé la mémoire complète disponible.
set_time_limit(500); // On augemente le time limit
date_default_timezone_set('Europe/Paris'); // Timezone Paris
$date = (new DateTime('NOW'))->format("D, d F Y, H:i:s");

// Créer une connexion
$conn1 = new mysqli('localhost', "root", "", "sl_tracking_search");
$conn2 = new mysqli('localhost', "root", "", "test");
// Vérifiez la connexion
if ($conn1->connect_error) {
    $msg = "Connection failed: " . $conn->connect_error;
} 
if ($conn2->connect_error) {
    $msg = "Connection failed: " . $conn->connect_error;
} 
// On set 4 Ville et 4 Code postale
$citys = array("Valence", "Paris", "Marseille", "Lyon");
$zipCodes = array("41000", "40126", "75008", "26100");
// On choisis une ville ou un code postale au hazard
$city =  $citys[rand(0, count($citys) - 1)];
$zipCode =  $zipCodes[rand(0, count($zipCodes) - 1)];
// Si on à une ville on check la base de donnee (extranet) avec le store locator (localhost)
if($city) {
    $testEx = "SELECT COUNT(*) as city FROM sl_tracking_search.lpg_all_customer as s WHERE s.CITY_CUS = '$city' AND s.REF_CUS = 1";
    $testSl = "SELECT COUNT(*) as city FROM test.lpg_all_customer as t WHERE t.CITY_CUS = '$city' AND t.REF_CUS = 1";
    $queryTestCityEx = mysqli_query($conn1, $testEx);
    $rowTestCityEx = mysqli_fetch_object($queryTestCityEx);
    
    $queryTestCitySl = mysqli_query($conn2, $testSl);
    $rowTestCitySl = mysqli_fetch_object($queryTestCitySl);
    $status = ($rowTestCityEx->city >= $rowTestCitySl->city ? true : false);
    if($status) {
        echo $city.'<br>';
        $msgCity = "Itegrity CITY_CUS : " . $city;
    } else {
        $msgCity = "No Integrity CITY_CUS : " . $city;
        $logCity  = $date . ' - ' .$msgCity.PHP_EOL.
        "-------------------------".PHP_EOL;
        file_put_contents('./logs.txt', $logCity, FILE_APPEND);
        return false;
    }
    $logCity  = $date . ' - ' .$msgCity.PHP_EOL.
        "-------------------------".PHP_EOL;
    file_put_contents('./logs.txt', $logCity, FILE_APPEND);
}
// Si on à un code postale on check la base de donnee (extranet) avec le store locator (localhost)
if($zipCode) {
    $testEx = "SELECT COUNT(*) as zip FROM sl_tracking_search.lpg_all_customer as s WHERE s.ZIP_CUS = '$zipCode' AND s.REF_CUS = 1";
    $testSl = "SELECT COUNT(*) as zip FROM test.lpg_all_customer as t WHERE t.ZIP_CUS = '$zipCode' AND t.REF_CUS = 1";
    $queryTestEx = mysqli_query($conn1, $testEx);
    $rowTestEx = mysqli_fetch_object($queryTestEx);
        
    $queryTestSl = mysqli_query($conn2, $testSl);
    $rowTestSl = mysqli_fetch_object($queryTestSl);
    $status = ($rowTestEx->zip >= $rowTestSl->zip ? true : false);
    if($status){
        echo $rowTestEx->zip . " + " . $rowTestSl->zip;
        $msgZip = "Itegrity ZIP_CUS1 : " . $zipCode;
    } else {
        //echo $rowTestEx->zip . " + " . $rowTestSl->zip;
        $msgZip = "No Integrity ZIP_CUS : " . $zipCode;
        $logZip  = $date . ' - ' .$msgZip.PHP_EOL.
        "-------------------------".PHP_EOL;
        file_put_contents('./logs.txt', $logZip, FILE_APPEND);
        return false;
    }
    $logZip  = $date . ' - ' .$msgZip.PHP_EOL.
        "-------------------------".PHP_EOL;
    file_put_contents('./logs.txt', $logZip, FILE_APPEND);
}
// On set les appareils et on cree un boucle
function creerlisteappareils($array){
    $listeappareils='(';
    foreach ($array as $uneformation) {
        if ($uneformation == end($array)) {
            $listeappareils.=" OR LISTE_APPAREILS2_CUS LIKE '%".$uneformation."%')";
        } elseif ($uneformation === reset($array)) {
            $listeappareils.=" LISTE_APPAREILS2_CUS LIKE '%".$uneformation."%' ";
        } else {
            $listeappareils.=" OR LISTE_APPAREILS2_CUS LIKE '%".$uneformation."%' ";
        }
    }
    return $listeappareils;
}
$arraylistealliance = [
    '102249500',
    '102249600',
    '102249700',
    '102249800',
    '102249900',
    '102250100',
    '102250200',
    '0102250300',
    '0102250400',
    '0102250500',
    '0102250600',
    '0102250700',
    '0102250800',
    '0102250000',
    '0102297800',
    '0102297900',
    '102298300',
    '102298600',
    '102299000',
    '102298200',
    '102298100',
    '102273600',
    '102275000',
    '102298500',
    '102298900',
    '102299200',
    '102299600',
    '102300400',
    '102300500',
    '102261100',
    '102261200',
    '102267000',
    '102267100',
    '102274100',
    '102298000',
    '102298400',
    '102298700',
    '102298800',
    '102299100',
    '102300100',
    '102300200',
    '102300300'
];
$listeformationalliance = creerlisteappareils($arraylistealliance);
// Si on à une ville on cherche si on à une liste des appareil et on le compare
if($city) {
    $testEx = "SELECT COUNT(*) as centre  FROM sl_tracking_search.lpg_all_customer as s WHERE s.CITY_CUS = '$city' AND s.REF_CUS = 1 AND " . $listeformationalliance;
    $testSl = "SELECT COUNT(*) as centre FROM test.lpg_all_customer as t WHERE t.CITY_CUS = '$city' AND t.REF_CUS = 1 AND " . $listeformationalliance;;
    $queryTestEx = mysqli_query($conn2, $testEx);
    $rowTestEx = mysqli_fetch_object($queryTestEx);
    $queryTestSl = mysqli_query($conn2, $testSl);
    $rowTestSl = mysqli_fetch_object($queryTestSl);
    $status = ($rowTestEx->centre >= $rowTestSl->centre ? true : false);
    if($status) {
        echo 'centre<br>';
        $msgApp = "Itegrity Centre";
    } else {
        $msgApp = "No Integrity CENTER";
        $logApp  = $date . ' - ' .$msgApp.PHP_EOL.
        "-------------------------".PHP_EOL;
        file_put_contents('./logs.txt', $logApp, FILE_APPEND);
        return false;
    }
    $logApp  = $date . ' - ' .$msgApp.PHP_EOL.
        "-------------------------".PHP_EOL;
    file_put_contents('./logs.txt', $logApp, FILE_APPEND);
}
// Si on à une ville on cherche si on à une soins et on le compare
if($city) {
    $testEx = "SELECT COUNT(*) as soins  FROM sl_tracking_search.lpg_all_customer as s WHERE s.CITY_CUS = '$city' AND s.REF_CUS = 1 AND " . $listeformationalliance . "AND  (
        COUNTRY_CUS = 'FR'
        AND ( ENDERMOLIFT2_CUS = 1 
            OR LISTE_FORMATIONS2_CUS LIKE '%102159700%')
        AND ( MOBILIFT_CUS = 1 
            OR LISTE_APPAREILS2_CUS LIKE '%102296300%' 
            OR ENDERMOLAB_B_CUS = 1 
            OR INTEGRAL_B_CUS = 1 
            OR LISTE_APPAREILS2_CUS LIKE '%0001017849%' 
            OR MOBILIFT_PHYSIO_CUS = 1 
            OR ENDERMOLAB_CUS = 1 
            OR INTEGRAL_CUS = 1) 
        )";
        $testSl = "SELECT COUNT(*) as soins  FROM test.lpg_all_customer as t WHERE t.CITY_CUS = '$city' AND t.REF_CUS = 1 AND " . $listeformationalliance . "AND  (
            COUNTRY_CUS = 'FR'
            AND ( ENDERMOLIFT2_CUS = 1 
                OR LISTE_FORMATIONS2_CUS LIKE '%102159700%')
            AND ( MOBILIFT_CUS = 1 
                OR LISTE_APPAREILS2_CUS LIKE '%102296300%' 
                OR ENDERMOLAB_B_CUS = 1 
                OR INTEGRAL_B_CUS = 1 
                OR LISTE_APPAREILS2_CUS LIKE '%0001017849%' 
                OR MOBILIFT_PHYSIO_CUS = 1 
                OR ENDERMOLAB_CUS = 1 
                OR INTEGRAL_CUS = 1) 
            )";
    $queryTestEx = mysqli_query($conn2, $testEx);
    $rowTestEx = mysqli_fetch_object($queryTestEx);
    $queryTestSl = mysqli_query($conn2, $testSl);
    $rowTestSl = mysqli_fetch_object($queryTestSl);
    $status = ($rowTestEx->soins >= $rowTestSl->soins ? true : false);
    if($status) {
        $msgSoins = "Itegrity Soins Visage";
    } else {
        $msgSoins = "No Integrity Soins Visage";
        $logSoins  = $date . ' - ' .$msgSoins.PHP_EOL.
        "-------------------------".PHP_EOL;
        file_put_contents('./logs.txt', $logSoins, FILE_APPEND);
        return false;
    }
    $logSoins  = $date . ' - ' .$msgSoins.PHP_EOL.
        "-------------------------".PHP_EOL;
    file_put_contents('./logs.txt', $logSoins, FILE_APPEND);
}
if($status) {
    require('dumpStoreLocator.php');
} else {
    $msgSoins = "Une error se produit avant le damping de la bdd";
        $logSoins  = $date . ' - ' .$msgSoins.PHP_EOL.
        "-------------------------".PHP_EOL;
        file_put_contents('./logs.txt', $logSoins, FILE_APPEND);
        return false;
}
//require('dumpStoreLocator.php');
/*
$sql = "SELECT * FROM sl_tracking_search.lpg_all_customer as s";
$result = $conn1->query($sql);
mysqli_query($conn2, "TRUNCATE TABLE `lpg_all_customer`");

// prepare and bind
$stmt = $conn2->prepare(
    "INSERT INTO lpg_all_customer 
        (`ID_CUS_FICHE`,
        `ID_CUS`, 
        `NAME_CUS`, 
        `NAME2_CUS`, 
        `ADDRESS1_CUS`, 
        `ADDRESS2_CUS`, 
        `ZIP_CUS`, 
        `CITY_CUS`,
        `TEL_CUS`,
        `MAIL_CUS`,
        `COUNTRY_CUS`, 
        `PASSWORD_CUS`, 
        `TYPE_CUS`, 
        `STRUCTURE_CUST`, 
        `JOB_CUS`,
        `WEBSITE_CUS`, 
        `PAGEPERSO_CUS`, 
        `LIPOMASSAGE_CUS`, 
        `LIPOMODELAGE_CUS`, 
        `ENDERMOLIFT_CUS`, 
        `ENDERMOLIFT2_CUS`,
        `HML_NIV2_CUS`, 
        `H360_NIV2_CUS`, 
        `ENDERMOTHERAPIE_CUS`, 
        `CANCERDUSEIN_CUS`, 
        `KMI_CUS`, 
        `KMS_CUS`, 
        `KM2I_CUS`,
        `KM2S_CUS`, 
        `ENDERMOLAB_CUS`, 
        `INTEGRAL_CUS`, 
        `ENDERMOLAB_B_CUS`, 
        `INTEGRAL_B_CUS`, 
        `ERGODRIVE_I_CUS`, 
        `MYLPGP_CUS`, 
        `LIFT_M6`, 
        `LIPO_M6`, 
        `LIFT_6`, 
        `OLD_CELLU_CUS`,
        `HUBER_CUS`, 
        `SPINEFORCE_CUS`, 
        `HML_CUS`, 
        `H360_CUS`, 
        `TYPES_HML_CUS`, 
        `E6_CUS`, 
        `R6_CUS`, 
        `MOBILIFT_CUS`, 
        `MOBILIFT_PHYSIO_CUS`, 
        `WELLBOX_CUS`, 
        `COSMETIC_CUS`, 
        `ENDERMOSPA_CORNER_CUS`, 
        `ENDERMOSPA_FULL_CUS`, 
        `ENDERMOSPA_MEDI_CUS`, 
        `CERTIFIED_QUALITY_CUS`, 
        `MVF_CUS`, 
        `ACTIVELIFE_CUS`, 
        `FORMATION_PRO_CUS`, 
        `CERTIFIED_QUALITY_2011_CUS`, 
        `LATITUDE_CUS`, 
        `LONGITUDE_CUS`, 
        `HIDDEN_CUS`, 
        `LOGINDST_CUS`, 
        `EMAIL_TABLET`, 
        `ACCES_TABLET`, 
        `REF_CUS`, 
        `ID_CUS2`, 
        `LISTE_FORMATIONS_CUS`,
        `ACTIF_SITES_CUS`,
        `LISTE_FORMATIONS2_CUS`,
        `LISTE_APPAREILS2_CUS`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "iissssssssssssssiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiississiiisiss", 
            $ID_CUS_FICHE,
            $ID_CUS, 
            $NAME_CUS, 
            $NAME2_CUS, 
            $ADDRESS1_CUS, 
            $ADDRESS2_CUS, 
            $ZIP_CUS, 
            $CITY_CUS, 
            $TEL_CUS, 
            $MAIL_CUS, 
            $COUNTRY_CUS, 
            $PASSWORD_CUS, 
            $TYPE_CUS,
            $STRUCTURE_CUST,
            $JOB_CUS,
            $WEBSITE_CUS,
            $PAGEPERSO_CUS, 
            $LIPOMASSAGE_CUS,
            $LIPOMODELAGE_CUS, 
            $ENDERMOLIFT_CUS, 
            $ENDERMOLIFT2_CUS,
            $HML_NIV2_CUS, 
            $H360_NIV2_CUS, 
            $ENDERMOTHERAPIE_CUS, 
            $CANCERDUSEIN_CUS, 
            $KMI_CUS, 
            $KMS_CUS, 
            $KM2I_CUS,
            $KM2S_CUS, 
            $ENDERMOLAB_CUS, 
            $INTEGRAL_CUS, 
            $ENDERMOLAB_B_CUS, 
            $INTEGRAL_B_CUS, 
            $ERGODRIVE_I_CUS, 
            $MYLPGP_CUS, 
            $LIFT_M6, 
            $LIPO_M6, 
            $LIFT_6, 
            $OLD_CELLU_CUS,
            $HUBER_CUS, 
            $SPINEFORCE_CUS, 
            $HML_CUS, 
            $H360_CUS, 
            $TYPES_HML_CUS, 
            $E6_CUS, 
            $R6_CUS, 
            $MOBILIFT_CUS, 
            $MOBILIFT_PHYSIO_CUS, 
            $WELLBOX_CUS, 
            $COSMETIC_CUS, 
            $ENDERMOSPA_CORNER_CUS, 
            $ENDERMOSPA_FULL_CUS, 
            $ENDERMOSPA_MEDI_CUS, 
            $CERTIFIED_QUALITY_CUS, 
            $MVF_CUS, 
            $ACTIVELIFE_CUS, 
            $FORMATION_PRO_CUS, 
            $CERTIFIED_QUALITY_2011_CUS, 
            $LATITUDE_CUS, 
            $LONGITUDE_CUS, 
            $HIDDEN_CUS, 
            $LOGINDST_CUS, 
            $EMAIL_TABLET, 
            $ACCES_TABLET, 
            $REF_CUS, 
            $ID_CUS2, 
            $LISTE_FORMATIONS_CUS,
            $ACTIF_SITES_CUS,
            $LISTE_FORMATIONS2_CUS,
            $LISTE_APPAREILS2_CUS);
            
if ($result->num_rows > 0) {
    // output data of each row
    foreach ($result as $ajouterClient) {
        $ID_CUS_FICHE = $ajouterClient['ID_CUS_FICHE'];
        $ID_CUS = $ajouterClient['ID_CUS'];
        $NAME_CUS = $ajouterClient['NAME_CUS']; 
        $NAME2_CUS = $ajouterClient['NAME2_CUS']; 
        $ADDRESS1_CUS = $ajouterClient['ADDRESS1_CUS']; 
        $ADDRESS2_CUS = $ajouterClient['ADDRESS2_CUS']; 
        $ZIP_CUS = $ajouterClient['ZIP_CUS']; 
        $CITY_CUS = $ajouterClient['CITY_CUS'];
        $TEL_CUS = $ajouterClient['TEL_CUS'];
        $MAIL_CUS = $ajouterClient['MAIL_CUS'];
        $COUNTRY_CUS = $ajouterClient['COUNTRY_CUS']; 
        $PASSWORD_CUS = $ajouterClient['PASSWORD_CUS']; 
        $TYPE_CUS = $ajouterClient['TYPE_CUS']; 
        $STRUCTURE_CUST = $ajouterClient['STRUCTURE_CUST']; 
        $JOB_CUS = $ajouterClient['JOB_CUS'];
        $WEBSITE_CUS = $ajouterClient['WEBSITE_CUS']; 
        $PAGEPERSO_CUS = $ajouterClient['PAGEPERSO_CUS'] ? $ajouterClient['PAGEPERSO_CUS'] : "0"; 
        $LIPOMASSAGE_CUS = $ajouterClient['LIPOMASSAGE_CUS']; 
        $LIPOMODELAGE_CUS = $ajouterClient['LIPOMODELAGE_CUS']; 
        $ENDERMOLIFT_CUS = $ajouterClient['ENDERMOLIFT_CUS']; 
        $ENDERMOLIFT2_CUS = $ajouterClient['ENDERMOLIFT2_CUS'];
        $HML_NIV2_CUS = $ajouterClient['HML_NIV2_CUS']; 
        $H360_NIV2_CUS = $ajouterClient['H360_NIV2_CUS']; 
        $ENDERMOTHERAPIE_CUS = $ajouterClient['ENDERMOTHERAPIE_CUS']; 
        $CANCERDUSEIN_CUS = $ajouterClient['CANCERDUSEIN_CUS']; 
        $KMI_CUS = $ajouterClient['KMI_CUS']; 
        $KMS_CUS = $ajouterClient['KMS_CUS']; 
        $KM2I_CUS = $ajouterClient['KM2I_CUS'];
        $KM2S_CUS = $ajouterClient['KM2S_CUS']; 
        $ENDERMOLAB_CUS = $ajouterClient['ENDERMOLAB_CUS']; 
        $INTEGRAL_CUS = $ajouterClient['INTEGRAL_CUS']; 
        $ENDERMOLAB_B_CUS = $ajouterClient['ENDERMOLAB_B_CUS']; 
        $INTEGRAL_B_CUS = $ajouterClient['INTEGRAL_B_CUS']; 
        $ERGODRIVE_I_CUS = $ajouterClient['ERGODRIVE_I_CUS']; 
        $MYLPGP_CUS = $ajouterClient['MYLPGP_CUS']; 
        $LIFT_M6 = $ajouterClient['LIFT_M6']; 
        $LIPO_M6 = $ajouterClient['LIPO_M6']; 
        $LIFT_6 = $ajouterClient['LIFT_6']; 
        $OLD_CELLU_CUS = $ajouterClient['OLD_CELLU_CUS'];
        $HUBER_CUS = $ajouterClient['HUBER_CUS'] ? $ajouterClient['HUBER_CUS'] : 0; 
        $SPINEFORCE_CUS = $ajouterClient['SPINEFORCE_CUS']; 
        $HML_CUS = $ajouterClient['HML_CUS']; 
        $H360_CUS = $ajouterClient['H360_CUS']; 
        $TYPES_HML_CUS = $ajouterClient['TYPES_HML_CUS'] ? $ajouterClient['TYPES_HML_CUS'] : 0; 
        $E6_CUS = $ajouterClient['E6_CUS']; 
        $R6_CUS = $ajouterClient['R6_CUS']; 
        $MOBILIFT_CUS = $ajouterClient['MOBILIFT_CUS']; 
        $MOBILIFT_PHYSIO_CUS = $ajouterClient['MOBILIFT_PHYSIO_CUS']; 
        $WELLBOX_CUS = $ajouterClient['WELLBOX_CUS']; 
        $COSMETIC_CUS = $ajouterClient['COSMETIC_CUS'] ? 1 : 0; 
        $ENDERMOSPA_CORNER_CUS = $ajouterClient['ENDERMOSPA_CORNER_CUS']; 
        $ENDERMOSPA_FULL_CUS = $ajouterClient['ENDERMOSPA_FULL_CUS']; 
        $ENDERMOSPA_MEDI_CUS = $ajouterClient['ENDERMOSPA_MEDI_CUS']; 
        $CERTIFIED_QUALITY_CUS = $ajouterClient['CERTIFIED_QUALITY_CUS']; 
        $MVF_CUS = $ajouterClient['MVF_CUS']; 
        $ACTIVELIFE_CUS = ($ajouterClient['ACTIVELIFE_CUS'] == null) ? "0," : $ajouterClient['ACTIVELIFE_CUS'].","; 
        $FORMATION_PRO_CUS = $ajouterClient['FORMATION_PRO_CUS']; 
        $CERTIFIED_QUALITY_2011_CUS = ($ajouterClient['CERTIFIED_QUALITY_2011_CUS'] == null) ? 0 : $ajouterClient['CERTIFIED_QUALITY_2011_CUS']; 
        $LATITUDE_CUS = $ajouterClient['LATITUDE_CUS']; 
        $LONGITUDE_CUS = $ajouterClient['LONGITUDE_CUS']; 
        $HIDDEN_CUS = $ajouterClient['HIDDEN_CUS']; 
        $LOGINDST_CUS = $ajouterClient['LOGINDST_CUS']; 
        $EMAIL_TABLET = $ajouterClient['EMAIL_TABLET']; 
        $ACCES_TABLET = $ajouterClient['ACCES_TABLET']; 
        $REF_CUS = $ajouterClient['REF_CUS']; 
        $ID_CUS2 = $ajouterClient['ID_CUS2']; 
        $LISTE_FORMATIONS_CUS = $ajouterClient['LISTE_FORMATIONS_CUS'];
        $ACTIF_SITES_CUS = $ajouterClient['ACTIF_SITES_CUS'];
        $LISTE_FORMATIONS2_CUS = $ajouterClient['LISTE_FORMATIONS2_CUS'];
        $LISTE_APPAREILS2_CUS = $ajouterClient['LISTE_APPAREILS2_CUS'];
        
        $stmt->execute();
    }
    $msg = "New records created successfully";
} else {
    $msg = "0 results";
}

$log  = $date . ' - ' .$msg.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.

file_put_contents('./logs.txt', $log, FILE_APPEND);
mysqli_close($conn1);
mysqli_close($conn2);
*/
 
