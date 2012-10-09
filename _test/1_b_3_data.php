<h1>Test 1.b.3</h1>
<?php 
	
	set_time_limit(0);
	
	require_once('../m_toolbox/m_toolbox.php');
	require_once('../Class_Performance.php');
	//require_once('Class_Combination.php');
	require_once('../Class_CombinationWinning.php');
	require_once('../Class_CombinationStatistics.php');
	//require_once('Class_CombinationTest.php');
	require_once('../Class_CombinationPreliminarTest.php');

	$megaSc = mLoadXml('d_megasc.htm');
	$megaSc = $megaSc->body->table->xpath('tr');
	array_shift($megaSc);

	$winningNumbers = array();
	foreach($megaSc as $k=>$combination) {
		$d = array();
		//d($combination);
		//d($c);
		//$c->date = (string)$combination->td[1];
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

	function sort_cRd_cRf($variable) {
		$return = array();
		foreach ($variable as $key => $value) {
			$cRd_cRf = $value->cRd_cRf;
			if(!array_key_exists($cRd_cRf, $return)) {
				$return[$cRd_cRf] = array('total'=>0, '1b3_percent'=> 0, 'foe'=>array());
			}
			if(!in_array($value->foe, $return[$cRd_cRf]['foe'])) {
				$return[$cRd_cRf]['foe'][] = $value->foe;
			}
			$return[$cRd_cRf]['total']++;
		}
		return updatePercents($return);
	}

	function add_arrays($b, $a){
		foreach ($a as $k => $v) {
			if(array_key_exists($k, $b)){
				foreach ($v['foe'] as $j => $foe) {
					if(!in_array($foe, $b[$k]['foe'])) {
						$b[$k]['foe'][] = $foe;
					} 
					$b[$k]['total']++;
				}
			} else {
				$b[$k] = $v; 
			}
		}
		//d($b);
		return updatePercents($b);
	}

	function genNums($limit) {
		$b = array();
		for ($i=0; $i < $limit; $i++) {
			$rc = CombinationTest::randCombination();

			$cRd_cRf = $rc->cRd.'-'.$rc->cRf;
			if(!array_key_exists($cRd_cRf, $b)) {
				$b[$cRd_cRf] = array('total'=>0, '1b3_percent'=> 0, 'foe'=>array());
			}
			if(!in_array($rc->foe, $b[$cRd_cRf]['foe'])) {
				$b[$cRd_cRf]['foe'][] = $rc->foe;
			}
			$b[$cRd_cRf]['total']++;
			unset($rc);
		}

		return updatePercents($b);
	}

	function updatePercents(&$b){		
		foreach ($b as $key => $value) {
			$count = count($value['foe']);
			$total = $value['total'];
			$b[$key]['1b3_percent'] = ($total-$count) / $total * 100;
		}
		return $b;
	}

	$test = new CombinationTest;
	$pTest = new CombinationPreliminarTest;
	$perf = new performance;
	$b = array();

	$perf->start_timer('p_test_1b3');
		$wresults = $pTest->p_test_1b3($winningNumbers);
	$perf->end_timer('p_test_1b3');

	echo "<ol>";
	foreach ($wresults as $cRd_cRf => $value) {
		if(!array_key_exists('DNE', $wresults[$cRd_cRf]['FOEs'])) {
			$temp = array();
			foreach ($wresults[$cRd_cRf]['FOEs'] as $k => $foe) {
				if(count($foe) > 1){
					$temp[$k] = $foe;
				}
			}
			if(!empty($temp)) {
				$factor =  getFOEfactor($cRd_cRf);
				echo "<li><span style='color:#006699'>$cRd_cRf</span> - ($factor) The following FOEs of this cDd-cDf pair repeated:<ol>";
				foreach ($temp as $j => $v) {
					echo "<li><span style='color:#660066'>$j</span>: <ul>";
					foreach ($v as $l => $f) {
						echo "<li>$f</li>";
					}
					echo "</ul></li>";
				}
				echo "</ol></li>";
			}
		}
	}
	echo "</ol>";

	//d($wresults);

	function getFOEfactor($cRd_cRf) {
		$t = 500630.860;
		switch ($cRd_cRf) {
			case '111111-21111':
				return "1111 of 21111";
				break;
			case '21111-111111':
				return "22-cDf";
				break;
			case '21111-21111':
				return "1111-1111";
				break;
			case '21111-2211':
				return "cDf";
				break;
			case '21111-3111':
				return "cDf";
				break;
			case '21111-321':
				return "1111-3";
				break;
			case '2211-111111':
				return "22-111111";
				break;
			case '2211-21111':
				return "22-11111";
				break;
			case '2211-2211':
				return "cDf";
				break;
			case '2211-3111':
				return "cDf";
				break;
			case '2211-321':
				return "22-3";
				break;
			case '222-21111':
				return "11111 of cDf";
				break;
			case '3111-111111':
				return "3-cDf";
				break;
			case '3111-21111':
				return "cDf";
				break;
			case '3111-2211':
				return "cDf";
				break;
			case '3111-3111':
				return "111 of cDf";
				break;
			case '321-111111':
				return "cDf";
				break;
			case '321-21111':
				return "cDf";
				break;
			case '321-2211':
				return "cDf";
				break;
			case '411-21111':
				return "1111 of cDf";			
			default:
				return 0;
				break;
		}
	}