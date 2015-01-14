<?php
/**
 * Created by PhpStorm.
 * User: ud
 * Date: 11/7/14
 * Time: 4:14 PM
 */

class stateModel {

    private $db ;
    private $table = 'kyc_states' ;
    private $lib  ;

    /**
     * Every model needs a database connection, passed to the model
     * Create a new instance of the database
     */
    public function __construct() {
        $this->lib = new Library() ;

        try {
            $this->db = new DatabaseModel() ;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }


    /**
     * Fetch all states
     * @return array
     */
    public function fetchAllStates(){
        $q = $this->db->query("SELECT * FROM ".$this->table);
        $data = array();
        while($r = $q->fetch_assoc()){
            if($r && is_array($r)){
            $data[] = array("sid"=>$r['sid'] , "name"=>$r['name']) ;
            }
        }
        return $data ;
    }


    /**
     * Add a new state
     * @param $name
     * @return mixed
     */
    public function addState($name){
        $name = strtolower( $this->lib->sanitizeStr($name) ) ;
        $bool = array() ;
        /* check if state exists before */
        $check = $this->db->dbSELECT('name',"name='".$name."'",$this->table);
        if( $check['status'] == true ){
            $bool['status'] = false ;
            $bool['result'] = 'This state has already been added';
        }else{
            $bool = $this->db->dbINSERT("name='".$name."'",$this->table);
        }
        return $bool ;
    }


    /**
     * Remove a state from the database
     * @param $name
     * @internal param $sid
     * @return mixed
     */
    public function removeState($name){
        $sid = $this->lib->sanitizeStr($name);
        $r = $this->db->dbDELETE("name='".$name."'",$this->table) ;
        return $r ;
    }



} 