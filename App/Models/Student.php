<?php

namespace MVC\App\Model;

use MVC\App\Model\Metadata\StudentMetdata;

/**
 * StudentModel
 */
class StudentModel extends StudentMetdata
{

	function __construct($name = '', $program = '', $semester = 1)
	{
		$this->id = md5(uniqid(rand(), true));
		$this->name = $name;
		$this->program = $program;
		$this->semester = $semester;
	}
}
