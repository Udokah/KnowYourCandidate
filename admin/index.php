<?php
session_start() ;

/**
 * A simple tool to visualize electoral aspirants data
 *
 * @author Nkwocha Udoka K
 * @link http://www.udonline.net
 */


// load application config (error reporting etc.)
require 'application/config/config.php';

require 'application/inc/functions.php' ;/* load required functions */

// load application class
function __autoload($class) {
    $lib = 'application/libs/' . $class . '.php' ;
    $model = 'application/models/' . $class . '.php' ;
    $core = 'application/core/' . $class . '.php' ;
    if(file_exists($core)){
        include_once($core) ;
    }else if(file_exists($lib)){
        include_once($lib) ;
    }else if(file_exists($model)){
        include_once($model) ;
    }
}

$lib = new Library () ;

// start the application
$app = new Application();



