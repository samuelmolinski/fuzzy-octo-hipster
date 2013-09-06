<h1>Test 4N</h1>
<?php 
	
	set_time_limit(0);
	
	require_once('../../m_toolbox/m_toolbox.php');
	require_once('../Performance.php');
	require_once('../CombinationStatistics.php');
	require_once('../CombinationWinning.php');
	require_once('../CombinationEvaluation.php');
	require_once('../CombinationPreliminarEvaluation.php');

	$megaSc = mLoadXml('../D_MEGA.htm');
	$megaSc = $megaSc->body->table->xpath('tr');
	array_shift($megaSc);

	$winningNumbers = array();
	foreach($megaSc as $k=>$combination) {
		$d = array();
		$d[] = (string)$combination->td[2];
		$d[] = (string)$combination->td[3];
		$d[] = (string)$combination->td[4];
		$d[] = (string)$combination->td[5];
		$d[] = (string)$combination->td[6];
		$d[] = (string)$combination->td[7];
		$c = new CombinationStatistics($d);
		$winningNumbers[] = $c;
		unset($c);
	}

	//d($winningNumbers);

	usort($winningNumbers, 'cmp_func');

	function cmp_func($A, $B) {
		$a = $A->id;
		$b = $B->id;
		return strcmp($a, $b);
	}

	//d($winningNumbers);

	$test = new CombinationTest;
	$pTest = new CombinationPreliminarTest;
	$perf = new performance;

	$data = array();
	foreach ($winningNumbers as $k => $combination) {
		//d($combination);
		//$combination = $winningNumbers[0];
		//d($combination);
		foreach ($winningNumbers as $j => $value) {
			//d($value->id);
			if($combination != $value){
				$return = numElementsEqual($combination, $value);
				//d($return);
				if($return['num'] >= 4) {
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
	}

	$total = count($winningNumbers);
	$totalOccurance = 0;

	foreach($data as $k=>$v) {
		$totalOccurance += ($v['total']);
	}
	$percent = $totalOccurance/$total *100;
	//d($perf->timers['p_test_1b1']['total']/$total);
	echo "The following 4N were found in the current drawn lottery tickets:";
	echo "<ol>";
	foreach ($data as $key => $value) {
		$count = count($value['combinations']);
		echo "<li>$key: was found $count times in the following cominations:<ul>";
		foreach ($value['combinations'] as $key => $value) {
			echo "<li>$value</li>";
		}
		echo "</ul></li>";
	}
	echo "</ol>";

	//d($data);

function numElementsEqual($c1, $c2) {
	$return = array('num'=>0, 'subComb'=>'');
	$num = 0;
	if($c1 != $c2) {
		foreach ($c2->d as $key => $value) {
			if(in_array($value, $c1->d)) {
				$return['num']++;
				if($return['subComb'] == ''){
					$return['subComb'] = $value->n;
				} else {
					$return['subComb'] .= '-'.$value->n;
				}
			}
		}
	} else {
		$return['num'] = 6;
	}
	return $return;
}
?>