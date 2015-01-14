<?php
 /**
     * Admin class
     */

class adminModel {
    
    private $db ;
    private $table = 'kyc_admin' ;
    private $lib  ;

    /**
     * Every model needs a database connection, passed to the model
     * Create a new instance of the database
     */
    function __construct() {
        $this->lib = new Library() ;

        try {
            $this->db = new Database() ;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     *  Create secure password with hash encryption
     *  @param String  $password password to encrypt
     *  @return String $hash hashed password
     */
    private function hashPassword($password){
        $cost = 10;
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        // Prefix information about the hash so PHP knows how to verify it later.
       // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
       $salt = sprintf("$2a$%02d$", $cost) . $salt;

       // Hash the password with the salt
        $hash = crypt($password, $salt);

        return $hash ;
    }

    /**
     *  Create a new Admin user
     *  @param string $username 
     *  @param string $password
     *  @return array msg/status of the operation
     */
    public function createUser($username, $password){
        $result = array("error" => true , "msg" => "account creation failed ") ;        
        if ( !$this->userExists($username) ) { // Username does not exist
                  $usr = $this->lib->sanitizeStr( $username ) ;
                  $psw = $this->hashPassword( $this->lib->sanitizeStr($password) ) ;
                  $qry = $this->db->insertInto($this->table)
                                                   ->set( array("username" => $usr , "password" => $psw ) ) 
                                                   ->run("insert") ;
                                         if( !$qry->hasError ){ // if not successful
                                                $result['error'] = false ;
                                         }else{
                                            $result['msg'] .= $qry->errorMsg ;
                                         }
        }else{
            $result['msg'] = "username is not available" ;
        }
        return $result ;        
    }

    /**
     * Check if user with the username already exists
     */
    public function userExists($username){
        $ret = true ;
        $usr = $this->lib->sanitizeStr( $username ) ;
        $qry = $this->db->select('username')
                                         ->from($this->table)
                                         ->where(" username='" . $usr . "' ")
                                         ->run('select') ;
                                         if( $qry->hasError ){ // if not successful
                                                $ret = false ;
                                         }

                return $ret ;
    }

    /**
     * Set Login Session
     * @param array $uid  
     */
    public function setLoginSession($uid){
        $qry = $this->db->select('username,password')
                                    ->from($this->table)
                                    ->where(" uid='$uid' ")
                                    ->run('select') ;
            $user_browser = $_SERVER['HTTP_USER_AGENT'] ;
            $token = hash('sha512',  $qry->data->password . $user_browser) ;
            $_SESSION['LoggedIn'] = array("username" => $qry->data->username , "login_token" => $token ) ;
            // Update token in database
            //$this->db->update($this->table)->set( array("token" => $token ) )->where("uid='$uid'") ;
    }

    /**
     *  Check if a user is loggedin
     *  @return boolean true/false
     */
    public function isLoggedIn(){
        $ret = false ;
        if (isset($_SESSION['LoggedIn'])) {
            //list($key , $token) = $_SESSION['LoggedIn'] ;
            $username = $this->lib->sanitizeStr(  $_SESSION['LoggedIn']['username'] ) ;
            $login_token = $this->lib->sanitizeStr( $_SESSION['LoggedIn']['login_token'] ) ;
            $qry = $this->db->select('password')
                                    ->from($this->table)
                                    ->where(" username='$username' ")
                                    ->run('select') ;
                                    if( !$qry->hasError ){ // if successful
                                        $user_browser = $_SERVER['HTTP_USER_AGENT'] ;
                                        $token = hash('sha512',  $qry->data->password . $user_browser) ;
                                        if( $login_token == $token ){
                                            $ret = true ;
                                        }
                                        
                                    }
        }
        return $ret ;
    }

    /**
     * clear all sessions
     * @internal param array $uid
     */
    public function clearSessions(){
        if (isset($_SESSION['LoggedIn'])) {
            $_SESSION['LoggedIn'] = "" ;
            unset($_SESSION['LoggedIn']) ;
        }        
    }


    /**
     *  Change password
     * @param string $old_password 
     * @param string $new_password 
     * @param string $uid 
     * @return object  status/msg
     */
    public function changePassword( $old_password, $new_password , $uid ){
         $res = array("status" => false) ;
         $pswd = sha1($old_password) ;
         // Check if old password is valid
         $q = $this->db->select('password')
                                    ->from($this->table)
                                    ->where("password='$pswd' AND uid='$uid' ")
                                    ->run('select') ;
                     if( !$q->hasError ){ // if successful
                        /// change the password
            $qry = $this->db->update($this->table)
                                            ->set( array("password" => sha1($new_password)  ) )
                                            ->where("uid='$uid'")
                                            ->run('update') ;
                        if( !$qry->hasError ){ // if successful
                        $res['status'] = true ;
                        $res['msg'] = 'your new password has been saved';
                        }
                        else{
                            $res['msg'] = 'password change failed' ;
                        }
                     }else{
                            $res['msg'] = 'Old password is invalid' ;
                        }
               return new ArrToObj($res) ;
    }


   /**
     * login a user
     * @param string $username  
     * @param string $password
     * @return string $result if true it returns the uid of the user
     */
    public function Login($username,$password){
        $Result['status'] = false ;
        $pswd = $this->lib->sanitizeStr( $password );
        $user = $this->lib->sanitizeStr( $username );
        $qry = $this->db->select('uid,password')->from($this->table)
                                ->where("username='$user' ")->run('select') ;
            if( !$qry->hasError ){
                if ( crypt($pswd, $qry->data->password ) === $qry->data->password ) {
                       $this->setLoginSession( $qry->data->uid  ) ;
                       $Result['status'] = true ;
                }                       
        }
        return $Result ;
    }



}
