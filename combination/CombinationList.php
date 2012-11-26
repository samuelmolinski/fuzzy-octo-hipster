<?php

	require_once('Combination.php');

	/*
		intented to be used for saving lists of combinations
	*/
	class CombinationList {
		public $list = array(); //should be a array of strings, each 12 char in length
		public $date = '';
		public $userId = NULL;
		public $groupId = NULL;

		// Init
		public function CombinationList($list = NULL) {
			//print_r($list);
			if(NULL != $list) {
				$this->add($list);
			}
		}

		public function add($list) {

			//print_r("thn list ");
			//print_r($list);
			//print_r("\n");

			if(is_array($list)){
				foreach ($list as $k => $arr) {
					$this->add($arr);
				}
				return true;	
			} elseif("CombinationList" == @get_class($list)) {
				$this->list = array_merge($this->list, $list->list);
				return true;	
			} elseif(("CombinationStatistics" == @get_class($list))||("Combination" == @get_class($list))){
				$this->addCombination($list);
				return true;	
			} elseif (is_string($list)) {
				$this->addString($list);
				return true;	
			} else {
				print_r('<p>$list is not acceptable</p>');
				return false;
			}
		}

		public function addString($string, $delimiter = ','){
			if (is_string($string)."\n") {
				// lets assume a comma seperated list with possible spaces or with hyphens ie "01-02-24-35-46-58"
				// this should also handle single combinations
				//print_r("sting list\n");
				$l = str_replace('-', '', $string);
				$l = explode($delimiter, $l);
					//print_r($l);
				foreach ($l as $k => $str) {
					$str = trim($str);
					//print_r("sub str ".$str."\n");
					//print_r("strlen ".strlen($str)."\n");
					if(12 == strlen($str)) {
						//print_r("= ".$str."\n");
						$this->list[] = $str;
					} elseif(12 < strlen($str)) {

						//print_r("> ".$str."\n");
						$this->addString($str, ' ');
					}
				}
				return true;
			}
			return false;
		}	

		public function addCombination($C){
			$this->list[] = $C->id;
			return true;
		}

		// Convert the list to Combinations and return the array()
		public function toCombinations() {
			$temp = array();
			foreach ($this->list as $k => $id) {
				$temp[] = new CombinationStatistics($id);
			}
			return $temp;
		}

		// Convert the list to Combinations and return the array()
		public function toList() {
			return $this->list;
		}

	    public function onlyUnique(){
	        return $this->list = array_unique($this->list);
	    }
	}