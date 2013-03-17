<?php

require_once("Number.php");

class Combination {
    public $id; 
    public $d = array();

    public function Combination($d = NULL) {

        if (is_array($d)) {
            $this->set_d($d);
            $this->order_d();
            $this->gen_id();
        } else if (is_string($d)){
            $ds = array();
            for ($i=0; $i < strlen($d); $i=$i+2) {
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
        $print = '';
        $count = count($this->d);
        for ($i=0; $i < $count-1; $i++) { 
            $print .= $this->d[$i]->n.'-';
        }
        return $print.$this->d[$count-1]->n;
    }
}