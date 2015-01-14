<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller{

    /**
     * Verifying required params posted or not
     */
    protected function verifyRequiredParams($req_fields) {

        $error = false;
        $error_fields = "";
        $request_params = array();

        $request_params = $_REQUEST ;
        $required_fields = explode(",",$req_fields) ;

        foreach ($required_fields as $field) {
            if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0 ) {
                $error = true;
                $error_fields .= $field . ', ';
            }
        }

        if ($error) {
            // Required field(s) are missing or empty
            // echo error json and stop the app
            $response = array();
            $response["status"] = false;
            $response["result"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
            $this->sendResponse($response,200);
            exit() ;
        }
    }


    /**
     * This should authenticate all request
     * to the api, will block all
     * Curl, cross-domain requests
     */
    public function authenticate(){
        /* request from the same server don't have a HTTP_ORIGIN header */
        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            $response = array();
            if($_SERVER['HTTP_ORIGIN'] !== 'http://'.$_SERVER['SERVER_NAME']){
            $response["status"] = false ;
            $response["result"] = "Request from server " . $_SERVER['HTTP_ORIGIN'] . " is not allowed";
            $this->sendResponse($response,401);
            exit();
            }
        }

    }


    /**
     * Send out json response
     * @param $response
     * @param int $statusCode
     */
    public function sendResponse($response,$statusCode=200){
        	$js = json_encode($response) ;
            http_response_code($statusCode);
        	header('Content-type: application/json');
        	echo $js ;
   	 }

    

    
}
