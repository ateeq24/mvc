<?php

namespace MVC\Core;

/**
 * Utilities to be used application-wide
 */
class Utils
{
	public static function validateClass ($name)
	{
		if (!class_exists($name)) {
			// Language to be included
			throw new \Exception("Class: $name not found...", 1);
		}
		if (!array_key_exists('MVC\Core\Models\BaseModel', class_parents($name)) 
			|| !array_key_exists('MVC\Core\Models\ModelInterface', class_implements($name)) ) {
			// Language to be included
			throw new \Exception("Class: $name is not a valid class...", 1);
		}
		return true;
		// return ( class_exists($name)
		// && array_key_exists('MVC\Core\Models\BaseModel', class_parents($name) ) 
		// 	&& array_key_exists('MVC\Core\Models\ModelInterface', class_implements($name) ) ) ? true : false;
	}
}
