<?php

	require_once('Combination.php');

	/*
		intented to be used for saving lists of combinations
	*/
	class CombinationList {
		public $list = array();
		public $date = '';
		public $userId = NULL;
		public $groupId = NULL;

		// Init
		public function CombinationList($list = NULL) {
			if(NULL != $list) {
				$this->add($list);
			}
		}

		public function add($list) {
			if(is_array($list)){
				// Is it objects or strings
				if(("CombinationStatistics" == get_class($list[0]))||("Combination" == get_class($list[0]))){
					//d('class');
					foreach ($list as $k => $C) {
						$this->list[] = $C->id;
					}
					return true;
				} elseif(is_string($list[0])){
					d('sting');
					// lets assume the incoming string is right
					$this->list = $list;
					return true;
				} else {
					echo("<p>array type is strange</p>");
					d($list);
					return false;
				}
			} elseif (is_string($list)) {
				// lets assume a comma seperated list with possible spaces or with hyphens ie "01-02-24-35-46-58"
				// this should also handle single combinations
				$l = str_replace('-', '', $list);
				$l = explode(',', $l);
				foreach ($l as $k => $c) {
					$c = trim($c);
					if(12 == strlen($c)) {
						$this->list[] = $c;
					}
				}
				return true;
			} else {
				return false;
			}
		}
		

		// Convert the list to Combinations and return the array()
		public function toCombinations() {
			$temp = array();
			foreach ($this->list as $k => $id) {
				$temp[] = new Combination($id);
			}
			return $temp;
		}

		// Convert the list to Combinations and return the array()
		public function toList() {
			return $this->list;
		}
	}