<?php

/**
 * Handles all state request
 */
class Party extends Controller{

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
        $this->model = new partyModel();
        $array = $this->model->fetchAllParties();
        $this->sendResponse($array);
    }

    public function add(){
        $this->verifyRequiredParams('fullname,acronym');
        $fullname = $_POST['fullname'] ;
        $acronym = $_POST['acronym'] ;
        $logo = $_FILES ;
        $this->model = new partyModel();
        $result = $this->model->addParty($fullname,$acronym,$logo);
        $this->sendResponse($result);
    }

    public function remove($partyLogo){
        $this->model = new partyModel();
        $result = $this->model->removeParty($partyLogo);
        $this->sendResponse($result);
    }

}


