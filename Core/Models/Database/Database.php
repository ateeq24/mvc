<?php
namespace MVC\Core\Models\Database;

use MVC\Core\Models\Database\MySql\MySqlDriver;
use \Exception;

/**
* Database abstraction class which will perform sql queries through platfrom drivers
*
*/
class Database
{
	private $db_instance;
	private $db_name;
	private $host;
    private $user;
    private $pass;
    private $port;
    private $pdo;
    private $driver;
    private $charset;

	function __construct()
	{
		$this->db_instance = $GLOBALS['env_config']['DB_INSTANCE'];
		$this->db_name 	   = $GLOBALS['env_config']['DB_NAME'];
		$this->host 	   = $GLOBALS['env_config']['DB_HOST'];
		$this->user 	   = $GLOBALS['env_config']['DB_USER'];
		$this->pass 	   = $GLOBALS['env_config']['DB_PASS'] ?? "";
		$this->port 	   = $GLOBALS['env_config']['DB_PORT'] ?? "3306";
		$this->charset 	   = $GLOBALS['env_config']['DB_CHARSET'] ?? "utf8mb4" ;
	}

    /**
    * Connects to the database
    *
    * @method connect
    * @return PDO object
    */
	public function connect()
	{
		if (!$this->getDriver()) {
			return false;
		}
		$dbCon = new $this->driver();
		$this->pdo = $dbCon->connect($this->host, $this->db_name, $this->user, $this->pass, $this->port, $this->charset);
	}

    /**
    * Connects to the database
    *
    * @method getDriver
    * @return boolean
    */
	public function getDriver()
	{
		if (!$this->db_instance ) {
			// Language to be included
			throw new \Exception("DB_INSTANCE is not configured in config.php", 1);
		}
		$driver = "MVC\\Core\\Models\\Database\\Drivers\\" . ucfirst($this->db_instance) ."\\" . ucfirst($this->db_instance) . "Driver";
		if (!class_exists($driver)) {
			// Language to be included
			throw new \Exception("DB_INSTANCE: " . $this->db_instance . " in config.php is not a valid one...", 1);
		}
		$this->driver = new $driver();
		return true;
	}

    /**
    * Select values from db
    *
    * @method select
    * @return object etc. mysqli object after connection
    */
	public function select()
	{
	}
}
