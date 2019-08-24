<?php
require_once "autoload.php";
use MVC\Core\Models\Database\Database;

// echo "URL: " . $_GET["url"] . "<br>\n";

$database = new Database();
// $database->insert("students", ["tahir", "tahir@subhani.com"], ["name", "email"]);
$update = $database->update("students", ["name"], ["Sufyan Shah"], ["id" => ["in", [1] ], "OR", "name" => ["LIKE", "%ufya%" ] ] );
$select = $database->select("students", ["id", "name", "email"], ["id" => ["in", [1,2,3] ], "OR", "name" => ["LIKE", "%ufya%" ] ], ["id" => "ASC", "email" => "ASC", "name" => "DESC"]);
echo print_r($select, 1);
