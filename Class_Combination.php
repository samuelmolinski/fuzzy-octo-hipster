<?php

class Combination {
	private $id;
	public $d = array();

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
    }
}