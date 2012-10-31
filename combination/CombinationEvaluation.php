<?php
	
	require_once('Combination.php');
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
			if($c1 != $c2) {
				foreach ($c2->d as $key => $value) {
					if(in_array($value, $c1->d)) {
						$num++;
						$subComb .= $value;
					}
				}
			}
			if(($c1 == $c2)||($num==6)) {
				return array('num'=>-1,'subComb'=>$subComb);
			}
				return array('num'=>$num,'subComb'=>$subComb);
		}

		public function generateRandCombs($num) {
			$return = array();
			for ($i=0; $i < $num; $i++) { 
				$temp = $this->randCombination();
				$return[] = $temp;
			}
			return $return;
		}

		public function randCombination() {
			$comb = array();
			for ($i=0; $i < 6; $i++) { 
				$next = FALSE;
				do {
					$r = (string)mt_rand(1,60);
					if($r < 10) {$r = '0'.$r;}
					if (!in_array($r, $comb)){
						$comb[] = $r;
						$next = TRUE;
					}
				} while (!$next);
			}			
			$c = new CombinationStatistics($comb);
			return $c;
		}
	}