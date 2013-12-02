<?php

	require_once('Combination.php');

	/*
		intented to be used for saving lists of combinations
	*/
	class CombinationList {
		public $list = array(); //should be a array of strings, each 12 char in length
		public $date = '';
		public $classType = 'CombinationStatistics';
		//public $userId = NULL;
		//public $groupId = NULL;

		// Init
		public function CombinationList($list = NULL) {
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
			} elseif(("CombinationStatistics" == @get_class($list))||("Combination" == @get_class($list))||("LF_Combination" == @get_class($list))) {
				$this->classType = get_class($list);
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
					if('LF_Combination' == $this->classType){
						if(30 == strlen($str)) {
							//print_r("= ".$str."\n");
							$this->list[] = $str;
						} elseif(30 < strlen($str)) {

							//print_r("> ".$str."\n");
							$this->addString($str, ' ');
						}
					} else {						
						if(12 == strlen($str)) {
							//print_r("= ".$str."\n");
							$this->list[] = $str;
						} elseif(12 < strlen($str)) {

							//print_r("> ".$str."\n");
							$this->addString($str, ' ');
						}
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
				$temp[] = new $this->classType($id);
			}
			//d($temp);
			return $temp;
		}

		// Convert the list to Combinations and return the array()
		public function toList() {
			return $this->list;
		}

	    public function onlyUnique(){
	        return $this->list = array_unique($this->list);
	    }

	    public function printListTable($CombinationToCheck=NULL, $perGroup = 30){
	    	
			$combs = $this->toCombinations();
			$results =  array();
			$totalCombs = count($combs);
			$count = 0;
			$tables = '<table class="table table-striped CombinationsSet '.$this->classType.'"><tbody>';

	    	if(NULL != $CombinationToCheck){
	    		if($this->classType != 'LF_Combination') {
	    			$results =  array(array(),array(),array(),array(),array(),array(),array());
	    		} else {
	    			$results =  array(array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array(),array());

	    		}
				foreach ($combs as $k => $c) {
					$count++;
					if((0 == ($count-1)%$perGroup)&&(0 != $count-1)){
						$tables .= '</tbody></table><table class="table table-striped CombinationsSet '.$this->classType.'"><tbody>';					
					}
					$matching = 0;
					foreach ($c->d as $key => $N) {
						if(0 != $key){
							if(in_array($N, $CombinationToCheck->d)) {
								$matching++;
								$str .= '-<span class="match">'.$N->n.'</span>';
							} else {
								$str .= '-'.$N->n;
							}
						} else {
							if(in_array($N, $CombinationToCheck->d)) {
								$matching++;
								$str = '<span class="match">'.$N->n.'</span>';
							} else {
								$str = $N->n;
							}
						}
					}
					if($matching){
						$results[$matching][] = $str;
						$matched = "<td class='comb matching$matching'>$str</td>";
					} else {
						$results[0][] = $str;
						$matched = "<td class='comb'>$str</td>";
					}
					$tables .= "<tr><td>$count</td>$matched</tr>";
				}
			} else {
				foreach ($combs as $k => $c) {
					$count++;					
					if((0 == ($count-1)%$perGroup)&&(0 != $count-1)){
						$tables .= '</tbody></table><table class="table table-striped CombinationsSet '.$this->classType.'"><tbody>';					
					}
					$tables .= "<tr><td>$count</td><td>".$c->print_id()."</td></tr>";
				}
			}
			$tables .= '</tbody></table>';
			return array('table'=>$tables,'results'=>$results);
	    }

	    public function sort_CRD_CRF(){
	    	$sort = array(0,0,0,0,0,0);
	    	$sub = array(
	    		array('321'=>0,'3111'=>0,'222_111111'=>0),
	    		array('321'=>0,'3111'=>0,'222_111111'=>0),
	    		array('321'=>0,'3111'=>0,'222_111111'=>0),
	    		array('321'=>0,'3111'=>0,'222_111111'=>0),
	    		array('321'=>0,'3111'=>0,'222_111111'=>0),
	    		array('321'=>0,'3111'=>0,'222_111111'=>0)
    		);
	    	$groups_2_2 = Yii::app()->params['cRd_cRf_groups'];


			Yii::trace(CVarDumper::dumpAsString($groups_2_2),'sort_CRD_CRF $groups_2_2');
			foreach ($this->list as $key => $Cstring) {

            	//echo Yii::trace(CVarDumper::dumpAsString($groups_2_2),'combination $Cstring');
				$C = new CombinationStatistics($Cstring);
				foreach ($groups_2_2 as $key => $group) {
					Yii::trace(CVarDumper::dumpAsString("key $key"),'$key');
					if(in_array($C->cRd_cRf, $group)){
						$sort[$key]++;
						Yii::trace(CVarDumper::dumpAsString("Accepted"),'Accepted');
						
						if($C->cRd == '321'){
							$sub[$key]['321']++; 
						}
						if($C->cRd == '3111'){
							$sub[$key]['3111']++; 
						}
						if(($C->cRd == '222')||($C->cRd == '111111')) {
							$sub[$key]['222_111111']++;
						}
						break;
					}

					if($key > 4) {
						Yii::trace(CVarDumper::dumpAsString($C->cRd_cRf),'moreThan5');
					}
				}
			}

					Yii::trace(CVarDumper::dumpAsString(count($this->list)),'count($this->list)');
			return array($sort, $sub);
	    }

	}