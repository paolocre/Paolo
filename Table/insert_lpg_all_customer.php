<?php

ini_set('memory_limit','-1'); // activé la mémoire complète disponible.
set_time_limit(500);

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
        $PAGEPERSO_CUS = $ajouterClient['PAGEPERSO_CUS'] ?? $ajouterClient['PAGEPERSO_CUS'] ?? "0"; 
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
        $HUBER_CUS = $ajouterClient['HUBER_CUS'] ?? $ajouterClient['HUBER_CUS'] ?? 0; 
        $SPINEFORCE_CUS = $ajouterClient['SPINEFORCE_CUS']; 
        $HML_CUS = $ajouterClient['HML_CUS']; 
        $H360_CUS = $ajouterClient['H360_CUS']; 
        $TYPES_HML_CUS = $ajouterClient['TYPES_HML_CUS'] ?? $ajouterClient['TYPES_HML_CUS'] ?? 0; 
        $E6_CUS = $ajouterClient['E6_CUS']; 
        $R6_CUS = $ajouterClient['R6_CUS']; 
        $MOBILIFT_CUS = $ajouterClient['MOBILIFT_CUS']; 
        $MOBILIFT_PHYSIO_CUS = $ajouterClient['MOBILIFT_PHYSIO_CUS']; 
        $WELLBOX_CUS = $ajouterClient['WELLBOX_CUS']; 
        $COSMETIC_CUS = $ajouterClient['COSMETIC_CUS'] ?? 1 ?? 0; 
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
$log  = date("F j, Y, g:i a") . ' - ' .$msg.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./logs.txt', $log, FILE_APPEND);
mysqli_close($conn1);
mysqli_close($conn2);
