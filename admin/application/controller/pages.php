<?php

/**
 * Class Pages
 */


class Pages extends Controller{

    private $View ;

    public function index(){
        $this->View = new View() ;
        $this->View->setTitle("Dashboard") ;
        $this->View->setBody("dashboard.php") ;
        $model = new aspirantModel();
        $aspirants = $model->fetchAll();
        $this->View->setVar('aspirants',$aspirants['result']) ;
        $this->View->setnavBar(true) ;
        $this->View->isRestricted(true) ;
        $this->View->renderView() ;
    }

    public function states(){
                $this->View = new View() ;
                $this->View->setTitle("states") ;
                $this->View->setBody("all_states.php") ;
                $this->View->setnavBar(true) ;
                $this->View->isRestricted(true) ;
        $stateModel = new stateModel();
        $this->View->setVar('states',$stateModel->fetchAllStates());
        $this->View->renderView() ;
    }


     public function parties(){
                $this->View = new View() ;
                $this->View->setTitle("Political parties") ;
                $this->View->setBody("parties.php") ;
                $this->View->setnavBar(true) ;
                $this->View->isRestricted(true) ;
                $this->View->setScript(array("jquery.form.min.js")) ;
         $party = new partyModel();
         $this->View->setVar('parties',$party->fetchAllParties());
                $this->View->renderView() ;
    }

    public function new_aspirant(){
        $this->View = new View() ;
        $this->View->setnavBar(true) ;
        $this->View->setBody("new_aspirant.php") ;
        $this->View->setTitle("New Aspirant") ;
        $this->View->setExtCss(array("http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/smoothness/jquery-ui.css")) ;
        $this->View->setScript(array("jquery-ui.min.js","jquery.form.min.js"));
        $states = new stateModel();
        $parities = new partyModel();
        $this->View->setVar('states',$states->fetchAllStates());
        $this->View->setVar('parties',$parities->fetchAllParties());
        $this->View->renderView() ;
    }

    public function view_aspirant($aid){
        $this->View = new View() ;
        $this->View->setTitle("View Aspirant") ;
        $this->View->setBody("view_profile.php") ;
        $this->View->setnavBar(true) ;
        $this->View->isRestricted(true) ;
        $model = new aspirantModel();
        $data = $model->aspirantData($aid);
        $this->View->setVar('aspirant',$data['result']);
        $this->View->renderView() ;
    }

    public function settings(){
                $this->View = new View() ;
                $this->View->setTitle("settings") ;
                $this->View->setBody("settings.php") ;
                $this->View->setnavBar(true) ;
                $this->View->isRestricted(true) ;  
                $this->View->renderView() ;
    }

    public function login(){
                $this->View = new View() ;
                $this->View->setTitle("Login") ;
                $this->View->setBody("login.php") ;
                $this->View->setnavBar(false) ;
                $this->View->setCss(array("login.css")) ;
                $this->View->isRestricted(false) ;   // Does not require login
                $this->View->renderView() ;
    }

}
