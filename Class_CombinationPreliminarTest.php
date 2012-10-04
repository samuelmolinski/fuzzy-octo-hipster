<?php
	
	require_once('Class_CombinationTest.php');

	class CombinationPreliminarTest extends CombinationTest {
		/*
		 * @param1 Array of Combinations to check inside
		 * @param2 Array of Conbinations to compare against 
		 * @return Bool - does the combination pass the test
		 */
		public function p_test_1b1($sampleData, $list) {
			$data = array();
			foreach ($sampleData as $k => $combination) {
				//d($combination);
				foreach ($list as $j => $value) {
					//d($value);
					$return = $this->numElementsEqual($combination, $value);
					//d($return);
					if($return['num'] > 3) {
						if(!is_array(@$data[$return['subComb']])) {
							$data[$return['subComb']] = array('total'=>0);
						}
						//d($return['subComb']);
						$data[$return['subComb']]['total']++;
					}
				}
			}
			return $data;
		}

		public function p_test_1b2() {

		}
	}