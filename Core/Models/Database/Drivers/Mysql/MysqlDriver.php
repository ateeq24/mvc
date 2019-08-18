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
	public function connect($servername, $username, $password) {
	    // Create connection
	    $conn = new \mysqli($servername, $username, $password);

	    // Check connection
	    if ($conn->connect_error) {
	    	// Language to be included
	        die("Connection failed: " . $conn->connect_error);
	    }
	    // Language to be included
	    echo "Connected successfully<br>\n";
	}
}
