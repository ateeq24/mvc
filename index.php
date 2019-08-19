<?php
require_once 'autoload.php';
use MVC\Core\Models\Database\Database;

echo "URL: " . $_GET['url'] . "<br>\n";

$database = new Database();
$database->connect();
$database->select("students", ["id", "name", "email"], ["id" => ["=", 1]], ["email" => "ASC"]);
