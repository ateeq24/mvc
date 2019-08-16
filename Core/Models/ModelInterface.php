<?php
namespace MVC\Core\Models;

Interface ModelInterface
{
    /**
    * This function will save a record
    *
    * @method save
    * @return boolean
    */
	public function save();

    /**
    * This function will return record against an ID
    *
    * @method getById
    * @param String $args
    * @return Object
    */
	public function getById($id);

    /**
    * This function will return all records
    *
    * @method getAll
    * @return Array
    */
	public function getAll();

    /**
    * This function will delete a record
    *
    * @method delete
    * @return boolean
    */
	public function delete();

    /**
    * This function will create a new record
    *
    * @method create
    * @param array $args
    * @return boolean
    */
	public function create(array $data);
}
