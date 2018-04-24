<?php

class Connexion
{
  /**
   * Instance de la classe PDO
   *
   * @var PDO
   * @access private
   */ 
  private $PDOInstance = null;
 
   /**
   * Instance de la classe SPDO
   *
   * @var SPDO
   * @access private
   * @static
   */ 
  private static $instance = null;
 
  /**
   * Constante: nom d'utilisateur de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_USER = 'wblpg_estore';
 
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_HOST = '172.16.46.3';

  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_PASS = 'Zqk~y858';
 
  /**
   * Constante: nom de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_DTB = 'wblpg_estore_prod';
 
  /**
   * Constructeur
   *
   * @param void
   * @return void
   * @see PDO::__construct()
   * @access private
   */
  private function __construct()
  {
    $this->PDOInstance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);    
  }
 
   /**
    * Crée et retourne l'objet SPDO
    *
    * @access public
    * @static
    * @param void
    * @return SPDO $instance
    */
  public static function getInstance()
  {  

	if(is_null(self::$instance))
    {
      self::$instance = new Connexion();
    }
    return self::$instance;
  }
 
  /**
   * Exécute une requête SQL avec PDO
   *
   * @param string $query La requête SQL
   * @return PDOStatement Retourne l'objet PDOStatement
   */
  public function query($query)
  {
        $this->PDOInstance->query("SET NAMES UTF8");
      return $this->PDOInstance->query($query);
  }
}
?>