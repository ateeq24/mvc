<?php
namespace MVC\Core\Controllers;
use MVC\Core\Views\ViewManager;

trait CRUD {

	/**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function read($id)
    {
        //if $id is "all" or empty
        if ($id == "all" or empty($id)) {
            //then show all
            $objs = $this->model->all();
            //if array is empty
            if (count($objs) <= 0) {
                return $this->view->render("list", ['none'=>'Nothing to show!']);
            }
            return $this->view->render("list", ['all' => $objs]);

        }
        $obj= $this->model->findById($id);
        if (count($obj) <= 0) {
            return $this->view->render("list", ['none'=>'Nothing to show!']);
        }
        return $this->view->render("view", ['object'=>$obj]);
    }
}
