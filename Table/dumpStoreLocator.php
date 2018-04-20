<?php 
include ('dumper.php');
ini_set('memory_limit','-1'); // activé la mémoire complète disponible.
try {
	$storeLocator_dumper = Shuttle_Dumper::create(array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db_name' => 'sl_tracking_search',
		'include_tables' => array('lpg_all_customer', 'lpg_all_facebook', 'lpg_all_facebook_horaires', 'lpg_all_facebook_img'), // only include those tables
	));
	$folderName = 'log';
	if (file_exists($folderName)) {
		//echo "toto";
		foreach (new DirectoryIterator($folderName) as $fileInfo) {
			if ($fileInfo->isDot()) {
			continue;
			}
			//var_dump($fileInfo);
			if ($fileInfo->isFile() && time() - $fileInfo->getCTime() >= 2*24*60*60) {
				unlink($fileInfo->getRealPath());
			}
		}
	}
	$storeLocator_dumper->dump('log/storeLocator-' . date("F-j-Y") . '.sql');
	$msg = 'dump database avec succès';

	
} catch(Shuttle_Exception $e) {
	$msg = "Couldn't dump database: " . $e->getMessage();
}

$log  = date("F j, Y, g:i a") . ' - ' .$msg.PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./logs.txt', $log, FILE_APPEND);

require('importSQL.php');
