<?php
require_once "autoload.php";
use MVC\Core\Models\Database\Database;

// echo "URL: " . $_GET["url"] . "<br>\n";

$database = new Database();
$database->insert("students", ["abcdef", "abcdef@rolustech.com"], ["name", "email"]);
$database->select("students", ["id", "name", "email"], ["id" => ["in", [1,2,3] ], "OR", "name" => ["LIKE", "%mark%" ] ], ["id" => "ASC", "email" => "ASC", "name" => "DESC"]);
