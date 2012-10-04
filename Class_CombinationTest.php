<?php
	
	require_once('Class_Combination.php');
	//require_once('Class_CombinationStatistics.php');

	class CombinationTest {
		/*
		 * @param1 Combination for to check inside
		 * @param2 Array of Conbinations to compare against 
		 * @return Bool - does the combination pass the test
		 */
		public function test_1b1($combination, $list) {
			foreach ($list as $key => $value) {
				$num = $this->numElementsEqual($combination, $value);
				if($num >=5) {
					return FALSE;
				}
			}
			return TRUE;
		}
		/*
		 * @param1 Combination for to check inside
		 * @param2 Combination 
		 * @return int equal to the number of occuring numbers both Combinations
		 */
		public function numElementsEqual($c1, $c2) {
			$num = 0;
			$subComb = '';
			//d($c1);
			//d($c2);
			if($c1 != $c2) {
				foreach ($c2->d as $key => $value) {
				//d($c2->d);
				//d($value);
					if(in_array($value, $c1->d)) {
						$num++;
						$subComb .= $value;
						//d('in_array');
					}
				}
			}
			//d($num);
			//if both values are equal or the sets of combinations are equal
			if(($c1 == $c2)||($num==6)) {
				return array('num'=>-1,'subComb'=>$subComb);
			}
				return array('num'=>$num,'subComb'=>$subComb);
		}
	}