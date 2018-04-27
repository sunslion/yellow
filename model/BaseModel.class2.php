<?php
defined('_VALID') or die('Restricted Access!');
class BaseModel
{
    protected $conn,$conf;
    function __construct($conf = array()){
        var_dump(1);
        $this->conf = $conf;
        var_dump($conf);
        $dbFactory = new DB_Factory();
        var_dump($dbFactory);
        $this->conn = $dbFactory->createObj('AdoDB', $this->conf);
        var_dump(  $this->conn );
        register_shutdown_function(array($this,'closeMysqlLink'));
        
        exit;
    }
    function closeMysqlLink(){
        if($this->conn){
            $this->conn->close();
            return true;
        }
        return false;
    }
}