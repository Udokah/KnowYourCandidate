<?php

class Error extends Controller{

    public function notFound(){
    	$this->View = new View() ;
                $this->View->setTitle("404 Page was not found") ;
                $this->View->setBody("error.php") ;
                $this->View->isRestricted(false) ;   // Does not require login
                $this->View->renderView() ;
    }

    public function notLoggedIn(){
               $this->View = new View() ;
                $this->View->setTitle("Login required") ;
                $this->View->setBody("error-login.php") ;
                $this->View->isRestricted(false) ;   // Does not require login
                $this->View->renderView() ;
    }


}
