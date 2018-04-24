<?php
$arraylistealliance =['102249500','102249600','102249700','102249800','102249900',
'102250100','102250200','0102250300','0102250400','0102250500','0102250600','0102250700','0102250800',
'0102250000','0102297800','0102297900','102298300','102298600','102299000','102298200','102298100',
'102273600','102275000','102298500','102298900','102299200','102299600','102300400','102300500','102261100','102261200',
'102267000','102267100','102274100','102298000','102298400','102298700','102298800','102299100','102300100','102300200','102300300'];
$arraylistealliancevisage =['102298200','102249600','102298300','102249700','102299000','102250100','0102250300',
'0102250400','0102250700','0102250800','0102250000','0102297900','102298600','102298100',
'102261100','102261200','102267000','102267100','102274100','102298000','102298400',
'102298700','102298800','102299100','102300100','102300200','102300300'];

$arraylistemobilift=['0001016985','0001017916','0102015900','0102032300','0102142700','0102207300','0101910400','0101964700',
'0001017917',  '0001018515','0102230600'];

$conn1 = new mysqli('localhost', "root", "", "sl_tracking_search");
// Vérifiez la connexion
if ($conn1->connect_errno) {
    
    $msg = "Connection failed to extranet : " . $conn1->connect_error;
    $log  = $date . ' - ' .$msg.PHP_EOL.
        "-------------------------".PHP_EOL;
    //Save string to log, use FILE_APPEND to append.
    file_put_contents('./logs.txt', $log, FILE_APPEND);
    exit;
} 

//liste appareills alliance
$comptagealliance = creerlisteappareilsX($arraylistealliance);
$listeformationalliance = creerlisteappareils($arraylistealliance);
$listeformationalliancevisage = creerlisteappareils($arraylistealliancevisage);
$listeappareilsmobilift = creerlisteappareils($arraylistemobilift);

function remplacerformations($objetaremplacer,$objetderemplacement,$objet,$separateur){
    return " replace( ".$objetaremplacer.", ".$objetderemplacement.", '".$objet."')". $separateur."";
}

function creerlisteappareils($array){
    $listeappareils='(';
    foreach ($array as $uneformation){
        if ($uneformation == end($array)) {
            $listeappareils.=" or lpg.listeAppareils2Cus like '%".$uneformation."%')";
        }elseif($uneformation === reset($array)){
             $listeappareils.=" lpg.listeAppareils2Cus like '%".$uneformation."%' ";
        }else{
            $listeappareils.=" or lpg.listeAppareils2Cus like '%".$uneformation."%' ";
        }        }
    return $listeappareils;
}
function creerlisteappareilsX($array){
    $listeappareils=''; 
    foreach ($array as $uneformation){
        if ($uneformation === end($array)) {
            $listeappareils = remplacerformations($listeappareils,"'".$uneformation."'",'',"");
        }elseif($uneformation === reset($array)){
            $listeappareils = remplacerformations("lpg.listeAppareils2Cus","'".$uneformation."'",'',"");
        }else{
            $listeappareils = remplacerformations($listeappareils,"'".$uneformation."'","",'');
        }
    }
    return $listeappareils;
}
$city = 'Valence';
$testEx = "SELECT * 
    (case
        WHEN (
            (LENGTH(s.LISTEAPPAREILS28CUS) - LENGTH ('$comptagealliance')>17 )
            AND (s.CERTIFIED_QUALITY_CUS = 1 OR s.FORMATION_PRO_CUS = 1) AND (s.COSMETIC_CUS  = 1)
        )
        THEN 0
        WHEN (
            (LENGTH(s.LISTEAPPAREILS28CUS) - LENGTH ('$comptagealliance')>17 )
            AND (s.CERTIFIED_QUALITY_CUS = 1 OR s.FORMATION_PRO_CUS = 1)
        )
        THEN 1
        WHEN '$listeformationalliance'
        THEN 2
        WHEN (s.ENDERMOSPA_FULL_CUS = 1 OR s.ENDERMOSPA_CORNER_CUS = 1) 
        THEN 1       
        WHEN  (s.COUNTRY_CUS != 'FR' AND ( s.MOBILIFT_CUS = 1 OR s.MOBILIFT_PHYSIO_CUS = 1 
            OR s.ENDERMOLIFT2_CUS = 1 AND (s.ENDERMOLAB_B_CUS = 1 OR s.INTEGRAL_B_CUS = 1 OR s.ENDERMOLAB_CUS = 1 OR s.INTEGRAL_CUS = 1 OR s.OLD_CELLU_CUS = 1) ))
        THEN 2
        ELSE 4
    end
    ) AS endermo
    FROM sl_tracking_search.lpg_all_customer as s WHERE s.CITY_CUS = '$city' AND s.REF_CUS = 1";

print_r($comptagealliance);
$queryTestEx = mysqli_query($conn1, $testEx);
$rowTestEx = mysqli_fetch_object($queryTestEx);
var_dump($rowTestEx);