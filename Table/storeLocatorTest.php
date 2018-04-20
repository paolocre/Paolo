<?php

ini_set('memory_limit','-1'); // activé la mémoire complète disponible.
set_time_limit(500); // On augemente le time limit
date_default_timezone_set('Europe/Paris'); // Timezone Paris
$date = (new DateTime('NOW'))->format("D, d F Y, H:i:s");

// Créer une connexion
$conn1 = new mysqli('localhost', "root", "", "sl_tracking_search");
$conn2 = new mysqli('localhost', "root", "", "test");
// Vérifiez la connexion
if ($conn1->connect_errno) {
    
    $msg = "Connection failed to extranet : " . $conn1->connect_error;
    $log  = $date . ' - ' .$msg.PHP_EOL.
        "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./logs.txt', $log, FILE_APPEND);
    exit;
} 
if ($conn2->connect_errno) {
    $msg = "Connection failed localhost : " . $conn2->connect_error;
    $log  = $date . ' - ' .$msg.PHP_EOL.
        "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./logs.txt', $log, FILE_APPEND);
    exit;
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
        $msgCity = "La requête de la recherche par ville est correcte  : Ville ( " . $city . " )";
    } else {
        $msgCity = "Il y a une erreur dans la requête de recherche par ville : ville ( " . $city . " )";
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
        $msgZip = "La requête de la recherche par code postale est correcte  : code postale ( " . $zipCode . " )";
    } else {
        $msgZip = "Il y a une erreur dans la requête de recherche par code postale : code postale ( " . $zipCode . " )";
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
        $msgApp = "La requête de la recherche par liste des appareils est correcte";
    } else {
        $msgApp = "Il y a une erreur dans la requête de recherche par liste des appareils";
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
        $msgSoins = "La recherche Soins Visage est correcte";
    } else {
        $msgSoins = "Il y a une erreur dans la recherche Soins Visage";
        $logSoins  = $date . ' - ' .$msgSoins.PHP_EOL.
        "-------------------------".PHP_EOL;
        file_put_contents('./logs.txt', $logSoins, FILE_APPEND);
        return false;
    }
    $logSoins  = $date . ' - ' .$msgSoins.PHP_EOL.
        "-------------------------".PHP_EOL;
    file_put_contents('./logs.txt', $logSoins, FILE_APPEND);
}

// Si stauts est TRUE on dump la bdd
if($status) {
    require('dumpStoreLocator.php');
} else {
    $msgSoins = "Une error se produit avant le damping de la bdd";
    $logSoins  = $date . ' - ' .$msgSoins.PHP_EOL.
        "-------------------------".PHP_EOL;
    file_put_contents('./logs.txt', $logSoins, FILE_APPEND);
    return false;
}