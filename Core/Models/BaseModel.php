<?php
namespace MVC\Core\Models;

/**
 * BaseModel from which application classes (e.g. student) can inherit from
 *
 * Functions are intentionally given odd names 
 * to differentiate from DB functions
 * I believe this will pose banana-gorilla problem in the future
 *
*/
class BaseModel
{
	$table;

	function __construct()
	{
		$this->database = new Database();
		$this->table = "base";
	}

	public function erase ($where = []) {
		$this->database->delete($this->table, $where );
	}

	public function add ($data, $columns = []) {
		$this->database->insert($this->table, $data, $columns);
	}

	public function revise ($columns, $data, $where = [] ) {
		$this->database->update($this->table, $columns, $data, $where );
	}

	public function fetch ($columns, $where = [], $order = [] ) {
		$select = $this->database->select($this->table, $columns, $where, $order);
		return $select;
	}
}
