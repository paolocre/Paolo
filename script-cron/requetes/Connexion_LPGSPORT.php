<?php

class Connexion_LPGSPORT
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
  const DEFAULT_SQL_USER = 'weblpg_sport';
 
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_HOST = '172.16.46.1';
 
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_PASS = 'ftd727#QHG643=';
 
  /**
   * Constante: nom de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_DTB = 'weblpg_sport';
 
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
      self::$instance = new Connexion_LPGSPORT();
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
   public function getFieldsName ($tableName) {
           $recordset = $this->PDOInstance->query("SHOW COLUMNS FROM $tableName");
           $fields = $recordset->fetchAll(PDO::FETCH_ASSOC);
           foreach ($fields as $field) {
                   $fieldNames[] = $field['Field'];
           }
           return $fieldNames;
   }
}
?>