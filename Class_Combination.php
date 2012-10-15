<?php

class Combination {
	public $id;
	public $d = array();

    public function Combination($d = NULL) {
        if (is_array($d) && (count($d) == 6)) {
            $this->set_d($d);
            $this->order_d();
            $this->gen_id();
        }
    }

	public function __set($name, $value)
    {
    	switch($name){
    		case 'id':
    			$this->gen_id();
    			break;
    	}
    } 

    public function __get($name)
    {
        switch($name){
            case 'id':
                return $this->id;
                break;
        }
    }

    public function set_d($arr) {
        $this->d = $arr;
    }

    public function gen_id() {
        $id = '';
        foreach($this->d as $k=>$d){
            $id = $id.$d;
        }
        $this->id = (string)$id;
    }

    public function order_d(){
        //order d by ascending values
        sort($this->d);
    }

    public function print_id() {
        $d = $this->id;

        return $d[0].$d[1].'-'.$d[2].$d[3].'-'.$d[4].$d[5].'-'.$d[6].$d[7].'-'.$d[8].$d[9].'-'.$d[10].$d[11];

    }
}