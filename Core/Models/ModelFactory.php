<?php
namespace MVC\Core\Models;

use MVC\Core\Utils;

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
		if(Utils::validateClass($name)) {
			try {
				return $name($this->databaseFactory->getDatabaseInstance());
			} catch (\Exception $e) {
				// Language to be included
				echo "Exception Occured: ";
				var_dump($e);
			}
		}
	}
}
