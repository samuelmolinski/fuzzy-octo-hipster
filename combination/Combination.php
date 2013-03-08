<?php

require_once("Number.php");

class Combination {
	public $id; 
	public $d = array();

    public function Combination($d = NULL) {

        if (is_array($d) && (count($d) == 6)) {
            $this->set_d($d);
            $this->order_d();
            $this->gen_id();
        } else if (is_string($d)&&(12 == strlen($d))){
            $ds = array();
            for ($i=0; $i < 12; $i=$i+2) {
                $sub = substr($d, $i, 2);
                $ds[] = new Number($sub);
            }
            $this->set_d($ds);
            $this->order_d();
            $this->gen_id();
        }
    }

	public function __set($name, $value) {
    	switch($name){
    		case 'id':
    			$this->gen_id();
    			break;
    	}
    } 

    public function __get($name) {
        switch($name){
            case 'id':
                return $this->id;
                break;
        }
    }

    public function set_d($arr) {
        $ds = array();
        if(@$arr[0]->n) {
            $ds = $arr;
        } else {
            foreach ($arr as $k => $n) {
                $ds[] = new Number((int)$n);
            }
        }        
        $this->d = $ds;
    }

    public function gen_id() {
        $id = '';
        foreach($this->d as $k=>$N){
            $id = $id.$N->n;
        }
        $this->id = (string)$id;
    }

    public function order_d(){
        //order d by ascending values
        sort($this->d);
    }

    public function print_id() {
        $d = $this->id;

        //return $d[0].$d[1].'-'.$d[2].$d[3].'-'.$d[4].$d[5].'-'.$d[6].$d[7].'-'.$d[8].$d[9].'-'.$d[10].$d[11];
        return $this->d[0]->n.'-'.$this->d[1]->n.'-'.$this->d[2]->n.'-'.$this->d[3]->n.'-'.$this->d[4]->n.'-'.$this->d[5]->n;

    }
}