<?php
defined('_VALID') or die('Restricted Access!');
class BaseModel
{
    protected $conn,$conf;
    function __construct($conf = array()){
        $this->conf = $conf;
        $dbFactory = new DB_Factory();
        $this->conn = $dbFactory->createObj('AdoDB', $this->conf);
        register_shutdown_function(array($this,'closeMysqlLink'));
    }
    function closeMysqlLink(){
        if($this->conn){
            $this->conn->close();
            return true;
        }
        return false;
    }
}