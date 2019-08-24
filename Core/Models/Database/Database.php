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
		if (!$this->pdo || !$this->driver) {
			$this->connect();
		}
		try {
			$select = $this->driver->select($table, $selecFields, $where, $orderby);
			$stmt = $this->pdo->prepare($select);
			$data = $this->getPlaceholderData($where);
			echo print_r($data);
			$stmt->execute($data);
			$result = $stmt->fetchAll();
			return $result;
		} catch (\Exception $e) {
			// Language to be included
			echo "Exception Occured: ";
			var_dump($e);
		}

	}

    /**
    * Select values from db using relevant driver
    *
    * @method getPlaceholderData
    * @param array $phData placeholder data
    * @example ["id" => ["in", [1,2,3] ], "OR", "name" => ["LIKE", "%mark%" ] ]
    * @return array $result result of select statement
    */
    public function getPlaceholderData($phData)
    {

        $data = null;
        if (count($phData) > 0) {
            $data = [];
            $size = count($phData);
            foreach ($phData as $key => $value) {
                //if its a logical operator
                if ( (--$size)%2 != 0 )
                    continue;
				if (is_array($value[1]))
					foreach ($value[1] as $val)
	                	$data[] = $val;
	            else
            		$data[] = $value[1];
            }
        }

        return $data;
    }

    /**
    * Create a new record in db using relevant driver
    *
    * @method insert
    * @return boolean whether insertion is successful
    */
	public function insert ($table, $values, $fields = [])
	{
		if (empty($values)) {
			// Language to be included
			throw new \Exception("Nothing to insert...", 1);
		}
		if (!$this->pdo || !$this->driver) {
			$this->connect();
		}
		try {
			$insert = $this->driver->insert($table, count($values), $fields);
			$stmt = $this->pdo->prepare($insert);
			$stmt->execute($values);
			return true;
		} catch (\Exception $e) {
			// Language to be included
			echo "Exception Occured: ";
			var_dump($e);
		}
	}

    /**
    * Update values in db using relevant driver
    *
    * @method update
    * @param string $table
    * @param array $updateFields e.g. ['id', 'name']
    * @param array $data e.g. ['123', 'Mark']
    * @param array $where e.g. ['id' => ['=', '123']]
    * @return bool whether update is successful
    */
	public function update ($table, $updateFields, $data, $where = [])
	{
		if (!$this->pdo || !$this->driver) {
			$this->connect();
		}
		try {
			$update = $this->driver->update($table, $updateFields, $where);
			$stmt = $this->pdo->prepare($update);
			$data = array_merge($data, $this->getPlaceholderData($where) );
			$stmt->execute($data);
			return true;
		} catch (\Exception $e) {
			// Language to be included
			echo "Exception Occured: ";
			var_dump($e);
		}
	}
}
