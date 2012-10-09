<?php
	
	require_once('Class_CombinationTest.php');

	class CombinationPreliminarTest extends CombinationTest {
		/*
		 * @param1 Array of Combinations to check inside
		 * @param2 Array of Conbinations to compare against 
		 * @return Bool - does the combination pass the test
		 */
		public function p_test_1b1($sampleData, $list, $threshold = 5) {
			$data = array();
			foreach ($sampleData as $k => $combination) {
				//d($combination);
				foreach ($list as $j => $value) {
					//d($value);
					$return = $this->numElementsEqual($combination, $value);
					//d($return);
					if($return['num'] >= $threshold) {
						if(!is_array(@$data[$return['subComb']])) {
							$data[$return['subComb']] = array('total'=>0, 'combinations'=>array());
						}
						if(!in_array($combination->id, $data[$return['subComb']]['combinations'])) {
							$data[$return['subComb']]['combinations'][] = $combination->id;
						}
						if(!in_array($value->id, $data[$return['subComb']]['combinations'])) {
							$data[$return['subComb']]['combinations'][] = $value->id;
						}
						$data[$return['subComb']]['total']++;
					}
				}
			}
			return $data;
		}

		public function p_test_1b2($sampleData, $list, $threshold = 4) {
			$data = array();
			foreach ($sampleData as $k => $combination) {
				foreach ($list as $j => $value) {
					$return = $this->numElementsEqual($combination, $value);
					if(($return['num'] == $threshold)&&($value->cRd == $combination->cRd)&&($value->cRf == $combination->cRf)) {
						if(!is_array(@$data[$return['subComb']])) {
							$data[$return['subComb']] = array('total'=>0, 'cRd'=>$value->cRd, 'cRf'=>$value->cRf, 'combinations'=>array());
						}
						if(!in_array($combination->id, $data[$return['subComb']]['combinations'])) {
							$data[$return['subComb']]['combinations'][] = $combination->id;
						}
						if(!in_array($value->id, $data[$return['subComb']]['combinations'])) {
							$data[$return['subComb']]['combinations'][] = $value->id;
						}
						$data[$return['subComb']]['total']++;
					}
				}
			}
			return $data;
		}

		public function p_test_1b3($sampleData) {
			$return = array();	
			foreach ($sampleData as $k => $combination) {
				$cRd_cRf = $combination->cRd_cRf;
				if(!array_key_exists($cRd_cRf, $return)) {
					$return[$cRd_cRf] = array('total'=>0, '1b3_percent'=> 0, 'FOEs'=>array());
				}
				//if(!in_array($combination->foe, $return[$cRd_cRf]['FOEs'])) {
				if(!array_key_exists($combination->foe, $return[$cRd_cRf]['FOEs'])) {
					$return[$cRd_cRf]['FOEs'][$combination->foe] = array();
				}
				/*if(!array_key_exists($combination->foe, $return[$cRd_cRf]['FOEs'])) {
					$return[$cRd_cRf]['FOEs'][$combination->foe][] = $combination->id;
				}*/
				$return[$cRd_cRf]['FOEs'][$combination->foe][] = $combination->id;
				$return[$cRd_cRf]['total']++;
			}
			return $this->updatePercents($return);
		}



		public function updatePercents(&$b){		
			foreach ($b as $key => $value) {
				$count = count($value['FOEs']);
				$total = $value['total'];
				$b[$key]['1b3_percent'] = ($total-$count) / $total * 100;
			}
			return $b;
		}
	}