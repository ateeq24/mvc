<?php
namespace MVC\Core\Models\Database;

use MVC\Core\Models\Database\MySql\MySqlDriver;
use \Exception;

class Database
{
	private $db;
	private $servername;
    private $username;
    private $password;

	function __construct()
	{
		$this->db = $GLOBALS['env_config']['DB'];
		$this->servername = $GLOBALS['env_config']['DB_HOST'];
		$this->username = $GLOBALS['env_config']['DB_USERNAME'];
		$this->password = $GLOBALS['env_config']['DB_PASSWORD'];
	}

	public function connect()
	{
		if (!$GLOBALS['env_config']["DB"] ) {
			// Language to be included
			throw new \Exception("DB is not configured in config.php", 1);
		}
		$dbDriverClass = "MVC\\Core\\Models\\Database\\Drivers\\" . ucfirst($GLOBALS['env_config']["DB"]) ."\\" . ucfirst($GLOBALS['env_config']["DB"]) . "Driver";
		if (!class_exists($dbDriverClass)) {
			// Language to be included
			throw new \Exception("Not a valid db in config..." . $dbDriverClass, 1);
		}
		$dbCon = new $dbDriverClass();
		$dbCon->connect($this->servername, $this->username, $this->password);
	}
}
