<?php

// activé la mémoire complète disponible.
ini_set('memory_limit','-1'); 
// Décommentez cette ligne ci-dessous pour une base de données plus grande pour permettre au script de s'exécuter longtemps
set_time_limit(0);
//echo $ftp;
// database file path
$filename = $ftp.'.sql';
// MySQL host
$mysql_host = 'localhost';
// MySQL username
$mysql_username = 'root';
// MySQL password
$mysql_password = '';
// Database name
$mysql_database = 'test';

// Connect to MySQL server
$connection = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_database);

if (mysqli_connect_errno()) {
	$msg = "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    $tables = array();
    $result = $connection->query("SHOW TABLES");
    while($row = $result->fetch_row()){
        $tables[] = $row[0];
    }
    foreach($tables as $table){
        $return = $connection->query("DROP TABLE $table");
    }
        
// Temporary variable, used to store current query
$templine = '';

// Read in entire file
$fp = fopen('bkp/' . $filename, 'r');

// Loop through each line
while (($line = fgets($fp)) !== false) {
	// Skip it if it's a comment
	if (substr($line, 0, 2) == '--' || $line == '')
		continue;

	// Add this line to the current segment
	$templine .= $line;

	// If it has a semicolon at the end, it's the end of the query
	if (substr(trim($line), -1, 1) == ';') {
		// Perform the query
		if(!mysqli_query($connection, $templine)){
			print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($connection) . '<br /><br />');
		}
		// Reset temp variable to empty
		$templine = '';
	}
}

mysqli_close($connection);
fclose($fp);

$msg = "Database imported successfully";
}
$log  = date("F j, Y, g:i a") . ' - ' .$msg.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./logs.txt', $log, FILE_APPEND);
