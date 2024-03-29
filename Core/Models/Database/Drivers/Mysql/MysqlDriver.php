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
    * Prepare a where clause
    *
    * @method prepareWhereClause
    * @param array $where e.g. ['id' => ['in', [1,2,3] ], 'name' => ['=', "mark" ] ] will give "WHERE id IN (???) AND name = ?"
    * @return string $query where statement
    */
	public function prepareWhereClause ($where = [])
	{
		$query = "WHERE ";
		foreach ($where as $key => $value) {
			$questionmarks = is_array($value[1]) ? str_repeat("?,", count($value[1])-1) . "?" : "?";
			if (is_string($value) && trim(strtolower($value)) == "and")
				$query .= "AND ";
			elseif (is_string($value) && trim(strtolower($value)) == "or")
				$query .= "OR ";
			elseif ( $value[0] == "<>" || $value[0] == "!=" || strtolower($value[0]) == "not in" )
				$query .= "`$key` NOT IN ($questionmarks) ";
			elseif ($value[0] == "=" || strtolower($value[0]) == "in" )
				$query .= "`$key` IN ($questionmarks) ";
			else
				$query .= "`$key` $value[0] ? "; // e.g. id = ?
		}
		return $query;
	}

    /**
    * Prepare ORDER BY clause
    *
    * @method prepareOrderByClause
	* @param array $orderby e.g. ['id' => 'ASC', 'name' => 'DESC'] will give "ORDER BY id ASC, name DESC
    * @return string $query order by statement
    */
	public function prepareOrderByClause ($orderby = [])
	{
		if (!empty($orderby)) {
			$query = "ORDER BY ";
			$i = 0;
			$numItems = count($orderby);
			foreach ($orderby as $key => $value) {
				if(++$i === $numItems)
					$query .= "`$key` $value ";
				else
					$query .= "`$key` $value, ";
			}
		}
		return $query;
	}

    /**
    * Prepare a select statement and return it as a string
    *
    * @method select
    * @param string $table
    * @param array $selectFields e.g. ['id', 'name']
    * @param array $where e.g. ['id' => ['=', '123']]
    * @param array $orderby e.g. ['id' => 'ASC', 'name' => 'DESC']
    * @return string $query select statement
    */
	public function select ($table, $selectFields, $where = [], $orderby = [])
	{
		$query = "SELECT ";
		if (is_array($selectFields) && !empty($selectFields)) {
			$i = 0;
			while ($i < count($selectFields)-1) {
				$query .= "`" . $selectFields[$i] . "`, ";
				$i++;
			}
			$query .= "`" . $selectFields[$i] . "` ";
		}
		else
			$query .= '* ';
		$query .= "FROM `$table` ";
		$query .= !empty($where) ? $this->prepareWhereClause($where) : "";
		$query .= !empty($orderby) ? $this->prepareOrderByClause($orderby) : "";
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
		$query = "INSERT INTO `$table` ";
		$query .= ( is_array($fields) && !empty($fields) ) ? "(" . implode(', ', $fields) . ") " : "";
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

    /**
    * Prepare an update statement and return it as a string, data is not required here
    *
    * @method update
    * @param string $table
    * @param array $updateFields e.g. ['id', 'name']
    * @param array $where e.g. ['id' => ['=', '123']]
    * @return string $query update statement
    */
	public function update ($table, $updateFields, $where = [])
	{
		$query = "UPDATE `$table` SET ";
		if (!is_array($updateFields) || empty($updateFields)) {
			throw new Exception("A valid array of fields is reuired to update...", 1);
		}
		$i = 0;
		while ($i < count($updateFields)-1) {
			$query .= "`" . $updateFields[$i] . "`=?, ";
			$i++;
		}
		$query .= "`" . $updateFields[$i] . "`=? ";
		$query .= !empty($where) ? $this->prepareWhereClause($where) : "";
		echo $query . " <br>\n";
		return $query;
	}

    /**
    * Prepare a delete statement and return it as a string
    *
    * @method delete
    * @param string $table
    * @param array $where e.g. ['id' => ['=', '123']]
    * @return string $query delete statement
    */
	public function delete ($table, $where = [])
	{
		$query = "DELETE FROM `$table` ";
		echo print_r($where, 1);
		$query .= !empty($where) ? $this->prepareWhereClause($where) : "";
		echo $query . " <br>\n";
		return $query;
	}
}
