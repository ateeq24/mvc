<?php
/**
 * An auterloader grabbed from the PSR-4 compliance example
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @method load
 * @param string $class The fully-qualified class name.
 * @return void
 */
if(!file_exists('config.php'))
  // Language to be included
  throw new Exception("unable to find config.php", 1);
  
require_once 'config.php';
function load ($class) {

    // project-specific namespace prefix
    $prefix = 'MVC';

    // base directory for the namespace prefix
    $base_dir = dirname(__FILE__);

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        // echo 'MVC - Including Class: ' . $class . "<br>\n";
        require_once $file;
    }
};

$classes = array(
  'MVC\App\Controllers\StudentController',
  'MVC\App\Model\StudentModel',
  'MVC\App\Model\Metadata\StudentMetdata',
  'MVC\App\Views\Generic\Add',
  'MVC\App\Views\Layouts\Ajax',
  'MVC\App\Views\Student\Default',
  'MVC\App\Views\Student\Delete',
  'MVC\App\Views\Student\Edit',
  'MVC\App\Views\Student\List',
  'MVC\Core\Request',
  'MVC\Core\Utils',
  'MVC\Core\Router',
  'MVC\Core\Controllers\BaseController',
  'MVC\Core\Controllers\ControllerFactory',
  'MVC\Core\Controllers\ControllerInterface',
  'MVC\Core\Models\BaseModel',
  'MVC\Core\Models\ModelFactory',
  'MVC\Core\Models\ModelInterface',
  'MVC\Core\Models\Database\Database',
  'MVC\Core\Models\Database\Drivers\Mysql\MysqlDriver',
  'MVC\Core\Views\ViewManager',
);

foreach ($classes as $class) {
  load($class);
}
