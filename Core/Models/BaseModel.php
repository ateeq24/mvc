<?php
namespace MVC\Core\Models;

class BaseModel
{

	function __construct()
	{
		$database = new Database();
	}

	public function delete ($where = []) {
		$this->database->delete($this->table, $where );
	}
$database->insert("students", ["t-hanks", "hanks@abc.com"], ["name", "email"]);

$update = $database->update("students", ["email"], ["mark@shah.com"], ["id" => ["in", [1] ], "OR", "email" => ["LIKE", "%abcd.com%" ] ] );
$select = $database->select("students", ["id", "name", "email"], ["id" => ["in", [1,2,3] ], "OR", "name" => ["LIKE", "%ai%" ] ], ["id" => "ASC", "email" => "ASC", "name" => "DESC"]);
echo print_r($select, 1);
}
