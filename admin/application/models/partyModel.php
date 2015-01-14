<?php

/**
 * Handles all state request
 */
class partyModel extends Controller{

    private $db ;
    private $table = 'kyc_parties' ;
    private $lib  ;
    private $uploadPath = "public/uploads/" ;

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
     * Fetch all parties
     * @return array
     */
    public function fetchAllParties(){
        $q = $this->db->query("SELECT * FROM ".$this->table);
        $data = array();
        while($r = $q->fetch_assoc()){
            if($r && is_array($r)){
                $data[] = $r ;
            }
        }
        return $data ;
    }


    /**
     * Add a new party
     * @param $fullname
     * @param $acronym
     * @param $logo
     * @internal param $name
     * @return mixed
     */
    public function addParty($fullname,$acronym,$logo){
        $fullname = strtolower( $this->lib->sanitizeStr($fullname) ) ;
        $acronym = strtolower( $this->lib->sanitizeStr($acronym) ) ;
        $result = array("status"=>false) ;

        /* Try to upload image first */
        $imgFileName =  $this->lib->rand(10);
        $image = new Upload($logo['logo']);
        $image->file_new_name_body = $imgFileName ;
        if ($image->uploaded) {
            $image->Process($this->uploadPath);
            if ($image->processed) {
                /* if file has been uploaded, save new entry in database */
                $imgFileName .= '.'.$image->file_dst_name_ext ;
                $set = "fullname='".$fullname."', acronym='".$acronym."', logo='".$imgFileName."'" ;
                $result = $this->db->dbINSERT($set,$this->table);

                if($result['status']==false){
                    // If database insert fails, delete uploaded image
                    unlink($this->uploadPath.$imgFileName) ;
                }else{
                    $result['logo'] = $imgFileName ; // Send image filename
                    $result['fullname'] = $fullname ;
                    $result['acronym'] = $acronym ;
                }

            }else{
                $result['result'] = $image->error ;
            }
        }else{
            $result['result'] = $image->error ;
        }

        return $result ;
    }


    /**
     * Remove a party from the database
     * @param $filename
     * @internal param $sid
     * @return mixed
     */
    public function removeParty($filename){
        $filename = $this->lib->sanitizeStr($filename);
        $r = $this->db->dbDELETE("logo='".$filename."'",$this->table) ;
        if($r['status'] == true){
            if(file_exists($this->uploadPath.$filename)){
                unlink($this->uploadPath.$filename);
            }
        }
        return $r ;
    }


}