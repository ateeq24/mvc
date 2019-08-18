<?php
namespace MVC\Core\Models;

use \Exception;

class ModelFactory
{

	function __construct()
	{

	}

    /**
    * This function will return model class against a name
    *
    * @method getById
    * @param String $args
    * @return Object
    */
	public function getModel($name) 
	{
		if (!class_exists($name)) {
			// Language to be included
			throw new \Exception("Class: $name not found...", 1);
		}
		if (array_key_exists('MVC\Core\Models\BaseModel', class_parents($name)) 
			&& array_key_exists('MVC\Core\Models\ModelInterface', class_implements($name)) ) {
			// Language to be included
			throw new \Exception("Class: $name is not a valid class...", 1);
		}
		try {
			return $name($this->databaseFactory->getDatabaseInstance());
		} catch (\Exception $e) {
			// Language to be included
			echo "Exception Occured: ";
			var_dump($e);
		}
	}
}
