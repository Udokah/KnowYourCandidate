<?php
/**
 * KYA
 * Class: aspirant.php
 * Author: @thisisudo
 * Date: 11/16/14
 * Time: 1:02 PM
 */

class Aspirant extends Controller{

    private $model ;

    public function index($aid){
        $this->authenticate() ;
        $this->model = new aspirantModel();
        $array = $this->model->aspirantData($aid);
        $this->sendResponse($array);
    }


    /**
     * Fetch Presidential aspirants
     */
    public function presidential(){
        $this->model = new aspirantModel();
        $array = $this->model->fetchAll('presidential');
        $this->sendResponse($array['result']);
    }

    public function gubernatorial($state){
        $this->model = new aspirantModel();
        $array = $this->model->fetchAll('gubernatorial',$state);
        $this->sendResponse($array['result']);
    }

    /**
     * set a new picture
     */
    public function picture(){
        $this->authenticate() ;
        if(isset($_FILES['picture'])){
            $this->model = new aspirantModel();
            $array = $this->model->setPicture($_FILES['picture']);
            $this->sendResponse($array);
        }
    }

    /**
     * create a new aspirant
     */
    public function create(){
        $this->authenticate() ;
        $this->verifyRequiredParams("picture,fullname,birthday,state,profile,education,party,type,achievments") ;
        $aspirant = new aspirantModel();
        $result = $aspirant->createNew($_POST);
        parent::sendResponse($result);
    }

    /**
     * remove an aspirant
     * @param $aid
     */
    public function remove($aid){
        $this->authenticate() ;
        $aspirant = new aspirantModel();
        $result = $aspirant->remove($aid);
        parent::sendResponse($result);
    }

} 