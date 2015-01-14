<?php
 /**
     * Database class
     * Handles all database transactions 
     */

class Database extends MySQLi {

  const DB_USERNAME = DB_USER ;
  const DB_PASSWORD = DB_PASS ;
  const DB_HOST = DB_HOST ;
  const DB_NAME = DB_NAME ;

  private $selectables = array() ;
  private $updateables = array();
  private $table ;
  private $whereClause ;
  private $limit ; 
  private $query ;

  public $errorMsg ;
  public $hasError  = true ;
  public $data ;


   /**
     * create connection with the database
     */
  public function __construct(){
    parent :: __construct( database::DB_HOST , database::DB_USERNAME , database::DB_PASSWORD , database::DB_NAME );
    if(mysqli_connect_error())
    {
      die("Database connection error! (" . mysqli_connect_errno() . ") ");
    }
  }


  public function select(){
    $this->selectables = func_get_args() ;
    return $this ;
  }

  public function update($table){
    $this->table = $table ;
    return $this ;
  }

  public function insertInto($table){
    $this->table = $table ;
    return $this ;
  }

  public function deletefrom($table){
    $this->table = $table ;
    return $this ;
  }

  public function set($arrays){
    $pair =  array() ;
    foreach ($arrays as $key => $value) {
      $pair[]  =  " $key='".$value."' " ;
    }
    $this->updateables = $pair ;
    return $this ;
  }

  public function from($table){
    $this->table = $table ;
    return $this ;
  }

  public function where($clause){
    $this->whereClause = $clause ;
    return $this ;
  }

  public function limit($limit){
    $this->limit = $limit ;
    return $this ;
  }


    /**
     * builds the query and execute it
     * @param $a
     * @internal param string $action sql action either SELECT,UPDATE,DELETE,INSERT
     * @return object $return contains data , error , error-message
     */
   public function run($a){
    $action = strtolower($a) ;

                    // IF Select
                    if($action == 'select'){
                      $this->query = "SELECT ". join(",", $this->selectables). " FROM {$this->table}" ;
                    if (!empty($this->whereClause)){
                      $this->query .=  " WHERE {$this->whereClause} " ;
                    }
                    if(!empty($this->limit)){
                      $this->query .=  " LIMIT {$this->limit}" ;
                    }
                  }

              // IF UPDATE
                elseif($action == 'update'){
                        $this->query = "UPDATE {$this->table} SET  ". join(",", $this->updateables)  ;
                        if (!empty($this->whereClause)){
                              $this->query .=  " WHERE {$this->whereClause}" ;
                            }
                 }

                 // IF INSERT
                elseif($action == 'insert'){
                        $this->query = "INSERT INTO {$this->table} SET  ". join(",", $this->updateables)  ;
                 }

                 // IF delete
                    elseif($action == 'delete'){
                      $this->query = "DELETE FROM {$this->table}" ;
                    if (!empty($this->whereClause)){
                      $this->query .= " WHERE {$this->whereClause}" ;
                    }
                  }

                  /// Run the query now
                  /// Do this for select queries
                  if( $action == 'select' ){
                    $q = $this->query($this->query);
                    //print_r($this->query) ;
                    //exit();
                    $res = $q->fetch_assoc();
                    if($res){
                      $this->hasError = false ;
                      $this->data = $res ;
                    }else{
                      $this->errorMsg = $this->error ;
                    }
                  }
                  //// Do this for other queries
                  else{
                    if( $this->query($this->query) ){
                          $this->hasError = false ;
                    }else{
                          $this->errorMsg = $this->error ;
                    }

                  }

                  ///Return the array object of query result
                  $returnarray = array();
                  $returnarray['hasError'] = $this->hasError ;
                  $returnarray['errorMsg'] = $this->error ;
                  if(is_array($this->data)){
                    $returnarray['data'] =   new ArrToObj($this->data)  ;
                  }else{
                    $returnarray['data'] =  $this->data  ;
                  }                 

                  $return = $this->data = new ArrToObj($returnarray) ; 
                  unset($returnarray) ;
                  return  $return ;
          } // End of run method

}