<?php

/**
 *  Service Class
 *  handles all services usally ajax calls
 */

class Service extends Controller{

    private $model ;

    /**
     *  ACTION called with Ajax
     * Authenticate user Login
     * @param username [varname] [description]
     */
    public function login(){
        $this->authenticate() ;
        $this->verifyRequiredParams("username,password") ;
        $this->model = new adminModel() ;
    	$login = $this->model->Login( $_POST['username'] , $_POST['password'] ) ;
        $this->sendResponse($login) ;
    }

    /**
     * Logout user
     */
    public function logout(){
                $this->model = new adminModel() ;
                $this->model->clearSessions() ;
                header("Location: ". URL . "/pages/login") ;
    }

     /**
      * Create a new admin user
      */
    public function createNewadmin(){
        $this->authenticate() ;
        $this->verifyRequiredParams("username,password") ;
                         $this->model = new adminModel() ;               
    	     $result = $this->model->createUser( $_POST['username'] , $_POST['password'] ) ;
                         $this->sendResponse($result) ;
    }

    

}
