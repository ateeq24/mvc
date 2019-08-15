<?php
namespace MVC\Core\Models\Database\Drivers\MySqli;

/**
 * MySQLDriver to get connection with db
 *
 * @author Ateeq Ur Rehman <ateeq.rehman@rolustech.net>
 * @since  2.5
 */
class MySQLDriver
{

    $servername = env('DB_HOST');
    $username = env('DB_USERNAME');
    $password = env('DB_PASSWORD');

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo "Connected successfully";
}
