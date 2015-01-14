<?php

/**
 * Handles all state request
 */
class States extends Controller{

    private $model ;

    /**
     * If this construct is enabled
     * External, Curl and Cross-domain request
     * to this controller will be disabled.
     */
    public function __construct(){
            $this->authenticate() ;
    }

    public function index(){
        $this->model = new stateModel();
        $array = $this->model->fetchAllStates();
        $this->sendResponse($array);
    }

    public function add($state){
        $this->model = new stateModel();
        $result = $this->model->addState($state);
        $this->sendResponse($result);
    }

    public function remove($name){
        $this->model = new stateModel();
        $result = $this->model->removeState($name);
        $this->sendResponse($result);
    }

}


