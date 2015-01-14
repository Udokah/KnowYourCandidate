<?php
/**
 * My custom library of various functions
 *
 * @author UDcreate
 */

class Library {

  /**
     * Is usually called by cleanUP method
     * Sanitize all inputs 
     * @param string $input 
     * @return string $output
     */
  private function cleanIt($input){ 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
    $output = preg_replace($search, '', $input);
    return $output;
  }

    /**
     * Sanitize arrays and strings , calls private function cleanIt()
     * @param string $input 
     * @return string $output
     */
  public function sanitizeStr($input) {
   $link = mysqli_connect( DB_HOST , DB_USER , DB_PASS , DB_NAME );
      $output = '' ;

    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = $this->sanitizeStr($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = $this->cleanIt($input);
        $output = mysqli_real_escape_string($link,$input);
    }
        return $output;
    }

   /**
     * generate random strings
     * @param string $length of string to be generated  
     * @return string $string random string
     */
      public function rand($length){
          $return = '' ;
          $characters = array(
              "A","B","C","D","E","F","G","H","J","K","L","M",
              "N","P","Q","R","S","T","U","V","W","X","Y","Z",
              "1","2","3","4","5","6","7","8","9","0");
          $keys = array();
          while(count($keys) < $length) {
              $x = mt_rand(0, count($characters));
              if(!in_array($x, $keys)) {
                  $keys[] = $x ;
              }
          }
          $random_chars = implode("",$keys) ;
          if(strlen($random_chars) < $length){
              $random_chars .= mt_rand(0, count($characters));
          }
          $string = substr($random_chars, 0, $length);
          $strArr = str_split($string);
          foreach($strArr as $k){
              $return .= $characters[$k] ;
          }
          return $return ;
       }
}