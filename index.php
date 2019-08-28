<?php
require_once "autoload.php";
use MVC\Core\Models\Database\Database;
use MVC\Core\Router;

// echo "URL: " . $_GET["url"] . "<br>\n";

/*$database = new Database();
$database->insert("students", ["t-hanks", "hanks@abc.com"], ["name", "email"]);
$update = $database->delete("students", ["id" => ["in", [6] ], "OR", "email" => ["LIKE", "%ufya%" ] ] );
$update = $database->update("students", ["email"], ["mark@shah.com"], ["id" => ["in", [1] ], "OR", "email" => ["LIKE", "%abcd.com%" ] ] );
$select = $database->select("students", ["id", "name", "email"], ["id" => ["in", [1,2,3] ], "OR", "name" => ["LIKE", "%ai%" ] ], ["id" => "ASC", "email" => "ASC", "name" => "DESC"]);
echo print_r($select, 1);*/
Router::getInstance();
