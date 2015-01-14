<?php

/**
 * View Class
 * Handles and generates all views
 */

class View{

    public $title ;
    private $description ;
    private $cssLinks = array() ;
    private $scriptLinks = array() ;
    private $extCss = array();
	public $body ;
    public $url = URL ;
    public $cssPath = '/public/css/' ;
    private $scriptPath = '/public/js/' ;
    public $navBar = "" ;
    private $viewsPath = "application/views" ;
    private $navbarTemp = "application/views/_templates/navbar.php" ;
    private $header = "application/views/_templates/header.php" ;
    private $footer = "application/views/_templates/footer.php" ;
    private $isRestricted = true ;  // If user has to be logged in to view the page
    private $isLoggedin ;   // is the user logged in
    private $OUTPUT ;

    protected $dataArr = array();
    protected $data ;
    private $requestToken ;

	private $properties = array();
	
	function __get($property){
	return $this->properties[$property];
	}
	
	function __set($property, $value){
	$this->properties[$property]=$value;
	}

	public function setTitle($title){
		$this->title = $title ;
	}

	public function setDesc($desc){
		$this->description = $desc ;
	}

    public function setScript($jsfile){
        $array = array() ;
        foreach ($jsfile as $file) {
            $array[] = '<script type="text/javascript" src="'. $this->url . $this->scriptPath . $file .'"></script>' ;
            //$array[] = file_get_contents('.'.$this->scriptPath . $file ) ;
        }
        $this->scriptLinks = implode("\n", $array) ;
    }

    public function getScripts(){
        if(!is_array($this->scriptLinks)){
            return $this->scriptLinks ;
        }
        return null;
    }

    public function setExtCss($links){
        $array = array() ;
        foreach ($links as $link) {
            $array[] = '<link rel="stylesheet" type="text/css" href="' . $link .'">' ;
        }
        $this->extCss = implode("\n", $array) ;
    }

    public function getExtCss(){
        if(!is_array($this->extCss)){
            return $this->extCss ;
        }
        return null;
    }

	public function setCss($css){
		$array = array() ;
		foreach ($css as $file) {
			$array[] = '<link rel="stylesheet" type="text/css" href="' . $this->url . $this->cssPath . $file .'">' ;
		}
		$this->cssLinks = implode("\n", $array) ;
	}

    public function getCssLinks(){
        if(!is_array($this->cssLinks)){
            return $this->cssLinks ;
        }
        return null;
    }

	public function setnavBar($boolean){
		if($boolean == true ){
		            $this->navBar = $this->loadExecfile($this->navbarTemp) ;
	                     }
	}

	public function setBody($file){		
		$this->body = $this->viewsPath . "/" . $file ;
	}

    /** Set variable to be available in view
     * @param $variable
     * @param $value
     */
    public function setVar($variable,$value){
        $this->dataArr[$variable] = $value;
    }


    public function isRestricted($boolean){
		$this->isRestricted = $boolean ;
	}


	public function getnavBar(){
		return $this->navBar ;
	}

	private function loadExecfile($file){
	                 ob_start();
        /** @noinspection PhpIncludeInspection */
        include $file ;
                                    $out = ob_get_contents();
                                    ob_end_clean();
                                    return $out ;
	}

	private function getLoginStatus(){
		$adminUser = new adminModel() ;
		$this->isLoggedin = $adminUser->isLoggedIn() ;
	}

	public function renderView(){
		if( $this->isRestricted == true ){ 
			$this->getLoginStatus() ;
			if( $this->isLoggedin == true ){
                $this->printPage();
			}else{
				header("Location: " . URL . "/error/notLoggedIn") ; 
			}			
		}else{
			$this->printPage();
		}
    }

        public function printPage(){
            foreach($this->dataArr as $key => $value){
                $this->$key = $value ;
            }
            $this->OUTPUT .= $this->loadExecfile($this->header) ;
            $this->OUTPUT .= $this->loadExecfile($this->body) ;
            $this->OUTPUT .= $this->loadExecfile($this->footer) ;
            echo $this->OUTPUT ;
        }



	
}