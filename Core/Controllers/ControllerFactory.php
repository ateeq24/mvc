<?php
namespace MVC\Core\Controllers;
use MVC\Core\Utils;
/**
 * ControllerFactory
 */
class ControllerFactory
{

	function __construct()
	{

	}

    /**
    * This function will return controller class against a name
    *
    * @method getController
    * @param String $name
    * @return Object
    */
	public function getController ($name)
	{
		if (Utils::validateClass($name)) {
			return $name ($this->databaseFactory->getDatabaseInstance());
		}
	}
}
