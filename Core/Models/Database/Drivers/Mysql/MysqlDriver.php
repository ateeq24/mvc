<?php
namespace MVC\Core\Models\Database\Drivers\Mysql;

/**
 * MySQLDriver to get connection with db
 *
 * @author Ateeq Ur Rehman <ateeq.rehman@rolustech.net>
 */

class MysqlDriver
{
	function _construct() {}

	/**
    * Connects to mysql database
    *
    * @method connect
    * @param string $host e.g. localhost
    * @param string $db db name
    * @param string $user username
    * @param string $pass password
    * @param string $port
    * @param string $charset
    * @return object $pdo PDO object
    */
	public function connect ( $host, $db, $user, $pass, $port = "3306", $charset= "utf8mb4") {
		$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
		$options = [
		    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
		    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
		    \PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
		    $pdo = new \PDO($dsn, $user, $pass, $options);
			return $pdo;
		} catch (\PDOException $e) {
		    throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
	}


    /**
    * Prepare a select statement and return it as a string
    *
    * @method select
    * @param string $table
    * @param array $selecFields e.g. ['id', 'name']
    * @param array $where e.g. ['id' => ['=', '123']]
    * @param array $orderby e.g. ['id' => 'ASC', 'name' => 'DESC']
    * @return string $query select statement
    */
	public function select ($table, $selecFields, $where = [], $orderby = [])
	{
		$query = "SELECT ";
		$query .= ( is_array($selecFields) && !empty($selecFields) ) ? implode(', ', $selecFields) . ' ' : '* ';
		$query .= "FROM $table WHERE ";

		$i = 0;
		$numItems = count($where);
		foreach ($where as $key => $value) {
			if($numItems != 1 && ++$i === $numItems)
				$query .= "AND $key=:$key ";
			else
				$query .= "$key " . $value[0] . " :$key "; // e.g. id = :id
		}
		if (!empty($orderby)) {
			$query .= "ORDER BY ";
			$i = 0;
			$numItems = count($orderby);
			foreach ($orderby as $key => $value) {
				if(++$i === $numItems)
					$query .= "$key $value ";
				else
					$query .= "$key $value, ";
			}
		}
		echo $query . " <br>\n";
		return $query;
	}

    /**
    * Prepare a insert statement and return it
    *
    * @method insert
    * @param string $table
    * @param array $values number of values to be inserted
    * @param array $fields e.g. ['id', 'name']
    * @return string $query insert statement
    */
	public function insert ($table, $numValues, $fields = [])
	{
		$query = "INSERT INTO $table ";
		$query .= ( is_array($fields) && !empty($fields) ) ? "(" implode(', ', $fields) . ") " : "";
		$query .= "VALUES (";
		$i = 0;
		while ($i < $numValues-1) {
			$query .= "?,";
			$i++;
		}
		$query .= "?) ";
		echo $query . " <br>\n";
		return $query;
	}
}
