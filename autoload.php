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

if(file_exists('./env.php')) {
    include './env.php';
}

if(!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

function load ($class) {
    echo 'MVC - Including Class: ' . $class . "\n";

    // project-specific namespace prefix
    $prefix = 'MVC';

    // base directory for the namespace prefix
    $base_dir = dirname(dirname(__FILE__));

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
        require $file;
    }
};

echo 'MVC - Initating Autoloader' . "\n";
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
  'MVC\Core\Controllers\BaseController',
  'MVC\Core\Controllers\ControllerFactory',
  'MVC\Core\Controllers\ControllerInterface',
  'MVC\Core\Models\BaseModel',
  'MVC\Core\Models\ModelFactory',
  'MVC\Core\Models\ModelInterface',
  'MVC\Core\Models\Database\Database',
  'MVC\Core\Models\Database\Drivers\MySqli\MySQLDriver',
  'MVC\Core\Views\ViewManager',
);

foreach ($classes as $class) {
  load($class);
}
echo 'RT MVC - Autoloader Completed' . "\n";
