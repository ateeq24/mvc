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
	/**
	 * e.g. mysql, pgsql
	 */
	private $db_instance;

	/**
	 * e.g. database name
	 */
	private $db_name;

	/**
	 * e.g. localhost
	 */
	private $host;
    private $user;
    private $pass;
    private $port;

	/**
	 * Driver class according to config.php
	 */

    private $driver;
	/**
	 * PDO object which will be set by calling relevant driver
	 */
    private $pdo;
    private $charset;


	/**
	 * Constructor
	 *
	 * sets class variables from config
	 */
	function __construct ()
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
    * Connects to the database through relevant driver
    *
    * @method connect
    * @return PDO object
    */
	public function connect ()
	{
		if (!$this->getDriver()) {
			return false;
		}
		$this->pdo = $this->driver->connect($this->host, $this->db_name, $this->user, $this->pass, $this->port, $this->charset);
	}

    /**
    * Returns relevan griver according to config
    *
    * @method getDriver
    * @return boolean
    */
	public function getDriver ()
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
    * Select values from db using relevant driver
    *
    * @method select
    * @param string $table
    * @param array $selecFields e.g. ['id', 'name']
    * @param array $where e.g. ['id' => ['=', '123']]
    * @param array $orderby e.g. ['id' => 'ASC', 'name' => 'DESC']
    * @return array $result result of select statement
    */
	public function select ($table, $selecFields, $where = [], $orderby = [])
	{
		if (!$this->pdo) {
			$this->connect();
		}
		$select = $this->driver->select($table, $selecFields, $where, $orderby);
		$stmt = $this->pdo->prepare($select);
		foreach ($where as $key => $value) {
			$pdo_vals = [$key => $value[1]];
		}
		$stmt->execute($pdo_vals);
		$result = $stmt->fetch();
		echo( print_r($result, 1));
		return $result;
	}

    /**
    * Create a new record in db using relevant driver
    *
    * @method insert
    * @return object etc. mysqli object after connection
    */
	public function insert ($table, $values, $fields = [])
	{
		if (empty($values)) {
			// Language to be included
			throw new \Exception("Nothing to insert", 1);
		}
		if (!$this->pdo) {
			$this->connect();
		}
		$insert = $this->driver->insert($table, count($values), $fields);
		foreach ($values as $value)
		{
			$stmt->execute([$name]);
		}
		$pdo->commit();
		$stmt = $this->pdo->prepare($insert);
		$stmt->execute($pdo_vals);
		$user = $stmt->fetch();
		echo( print_r($user, 1));
	}
}
