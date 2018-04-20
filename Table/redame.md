# STORE LOCATOR

## Fichier :

* storeLocatorTest.php 
* dumpStoreLocator.php
* importSQL.php
* importSQL.php

## Documentation  

Les instruction pour vérifier la bdd du **store locator** et de la répliquer dans une environnement de production

### storeLocatorTest.php 

On teste la connexion à la base de données (extranet)
On test les requetés SQL sur 4 critères : Ville ; code Postale ; Liste appareils ; Soins Visage.
On choisit au hasard une ville ou un code postal de la manière suivante :
``` 
// On set 4 Ville et 4 Code postale
$citys = array("Valence", "Paris", "Marseille", "Lyon");
$zipCodes = array("41000", "40126", "75008", "26100");
```

1.	Si on à une ville on compare les résultats entre la bdd extranet et la bdd local pour vérifier si les réponses si sont égale ou superior on considère que la réponse est correcte, on procède au second test autrement on arrête le process et on écrit un log d’erreur.


2.	Si le premier test est réussi et on à une code postal on compare les résultats entre la bdd extranet et la bdd local pour vérifier si les réponses si sont égale ou superior on considère que la réponse est correcte, on procède au seconde test autrement on arrête le process et on écrit un log d’erreur.


3.	Si le second test est réussi on teste les centre de la ville choisi si ont des appareils et on compare les résultats entre la bdd extranet et la bdd local pour vérifier si les réponses si sont égale ou superior on considère que la réponse est correcte, on procède au seconde test autrement on arrête le process et on écrit un log d’erreur.


4.	Si le troisième test est réussi on teste si il y à des centre SOINS VISAGE de la ville choisi si et on compare les résultats entre la bdd extranet et la bdd local pour vérifier si les réponses si sont égale ou superior on considère que la réponse est correcte, on procède au seconde test autrement on arrête le process et on écrit un log d’erreur.
Réponse négative on arrête le processus et on écrit l’erreur dans le fichier log.


### dumpStoreLocator.php

What things you need to install the software and how to install them

```
$storeLocator_dumper = Shuttle_Dumper::create(array(
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db_name' => 'sl_tracking_search',
        'include_tables' => array('lpg_all_customer', 'lpg_all_facebook', 'lpg_all_facebook_horaires', 'lpg_all_facebook_img'), // only include those tables
    ));

```
Réponse positive on lance le fichier dumpStoreLocator.php pour crée un backup de la bdd dans le dossier bkp/ et on efface les ancienne fichier de plus de 48h.
Réponse négative on arrête le processus et on écrit l’erreur dans le fichier log.

### importSQL.php

Reponse positive on lance un DROP TABLE dans la bdd locale 

## dumper.php

Il fournit une interface commune pour écrire des données dans des fichiers SQL.

### Version

0.1

## Authors

* **Paolo Cremaschi** - *LPG*

