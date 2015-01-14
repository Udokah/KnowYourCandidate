<?php
/**
 * KYA
 * Class: aspirantModel.php
 * Author: @thisisudo
 * Date: 11/16/14
 * Time: 1:05 PM
 */

class aspirantModel {

    private $db ;
    private $table = 'kyc_aspirants' ;
    private $statesTable = 'kyc_states' ;
    private $partiesTable = 'kyc_parties' ;
    private $lib  ;
    private $uploadPath = "public/uploads/aspirants" ;
    private $return = array("status"=>false,"result"=>null);

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
     * remove an aspirant
     * @param $aid
     * @return array
     */
    public function remove($aid){
        $aid = $this->lib->sanitizeStr($aid) ;
        $delete = $this->db->dbDELETE("aid='".$aid."'",$this->table);
        return $delete;
    }


    /**
     * Get all the data for a particular aspirant
     * @param $aid
     * @return array
     */
    public function aspirantData($aid){
        $aid = $this->lib->sanitizeStr($aid) ;
        $qry = $this->db->dbSELECT("*","aid='".$aid."'",$this->table);
        if($qry['status'] == true){
            $aspirant = $qry['result'];
            $state = $this->db->dbSELECT('name',"sid='".$aspirant['state']."'",$this->statesTable);
            $aspirant['state'] = $state['result']['name'];
            $party = $this->db->dbSELECT('fullname,acronym,logo',"pid='".$aspirant['party']."'",$this->partiesTable);
            $aspirant['party'] = new ArrToObj($party['result']) ;
            $this->return['status'] = true ;
            $this->return['result'] = $aspirant ;
        }else{
            $this->return['result'] = $qry['result'] ;
        }
        return $this->return;
    }


    /**
     * fetch all aspirants
     * @param string $type
     * @param string $state
     * @internal param string $sid
     * @return array
     */
    public function fetchAll($type='',$state=''){
        $array = array() ;
        $queryStr = "SELECT aid, fullname, TIMESTAMPDIFF(YEAR, birthday, CURRENT_DATE) AS age, state, profile,picture,party,achievments,type,education FROM ".$this->table ;

        if($type == 'gubernatorial'){
            $queryStr .= " WHERE type='".$type."' AND state='".$state."'";
        }else if($type == 'presidential'){
            $queryStr .= " WHERE type='".$type."'";
        }

        $select = $this->db->query($queryStr);

        while($r = $select->fetch_assoc()){
            $r['nameUrl'] = self::GenerateUrl($r['fullname']);
            // get state
            $state = $this->db->dbSELECT('name',"sid='".$r['state']."'",$this->statesTable);
            if($state['status'] == true){
                $r['state'] = $state['result']['name'] ;
            }else{
                $r['state'] = 'not found' ;
            }

            // get party
            $party = $this->db->dbSELECT('fullname,acronym,logo',"pid='".$r['party']."'",$this->partiesTable);
            if($party['status'] == true){
                $party['result']['acronym'] = strtoupper($party['result']['acronym']) ;
                $r['party'] = $party['result'] ;
            }else{
                $r['party'] = 'not found' ;
            }

            $array[] = $r ;
        }

        if(count($array) > 0){
            $this->return['status'] = true ;
            $this->return['result'] = $array ;
        }
        return $this->return ;
    }


    /**
     * Create a new aspirant
     * @param $data
     * @return array
     */
    public function createNew($data){
        $array = $this->lib->sanitizeStr($data) ;
        /* create sql query from array */
        $dataSet = array() ;
        foreach($array as $key => $value){
            $dataSet[] = $key."='".$value."'" ;
        }
        $set = implode(" , ",$dataSet);
        $insert = $this->db->dbINSERT($set,$this->table);
        if($insert['status'] == true){
            $this->return['status'] = true ;
        }else{
            $this->return['result'] = 'Sql error: '.$insert['result'] ;
        }
        return $this->return ;
    }


    /**
     * Upload a new picture for an aspirant
     * @param $picture
     * @return array
     */
    public function setPicture($picture){
        $newFileName = sha1($this->lib->rand(10)); /* new file name */
        $image = new Upload($picture);
        $image->dir_auto_chmod = true;
        $image->file_new_name_body = $newFileName ;
        $image->allowed = array('image/*');
        $image->image_convert = 'jpg';
        if ($image->uploaded){
            $image->Process($this->uploadPath);
            if ($image->processed){
                $this->return['status'] = true ;
                $this->return['result'] = $newFileName.'.jpg' ;
            }else{
                $this->return['result'] = $image->error;
            }
        }else{
            $this->return['result'] = $image->error;
        }
        return $this->return;
    }

    private function GenerateUrl ($s) {
    //Convert accented characters, and remove parentheses and apostrophes
    $from = explode (',', "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,(,),[,],'");
    $to = explode (',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,,,,,,');
    //Do the replacements, and convert all other non-alphanumeric characters to spaces
    $s = preg_replace ('~[^\w\d]+~', '-', str_replace ($from, $to, trim ($s)));
    //Remove a - at the beginning or end and make lowercase
    return strtolower (preg_replace ('/^-/', '', preg_replace ('/-$/', '', $s)));
}

} 