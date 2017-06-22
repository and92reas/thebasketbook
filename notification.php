<?php

class notification {

    
    public $nid;
    public $sid;
    public $sname;
    public $type;
    public $time_stamp;
    
    
    function __construct($nid,$sid,$sname,$type,$time_stamp) {
        $this->nid = $nid;
        $this->sid = $sid;
        $this->sname = $sname;
        $this->type = $type;
        $this->time_stamp = $time_stamp;
    }
    
    
    
    
}

?>

