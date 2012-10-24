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
		/*foreach ($return as $key => $value) {
			$count = count($return[$key]['foe']);
			$total = $return[$key]['total'];
			$return[$key]['1b3_percent'] = ($total-$count) / $total * 100;
			//$return[$key]['1b3_percent'] .= '%';
		}*/
		 return updatePercents($return);
		 //return $return;
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
			//d($value);
			//d($key);
			//d($count);
			//d($total);
			//d(($total-$count) / $total * 100);
			$b[$key]['1b3_percent'] = ($total-$count) / $total * 100;
			//d($b[$key]['1b3_percent']);
			//$results[$key]['1b3_percent'] .= '%';
		}
		return $b;
	}

	//d($winningNumbers);

	$test = new CombinationTest;
	$pTest = new CombinationPreliminarTest;
	$perf = new performance;
	$b = array();

	$perf->start_timer('p_test_1b3');
		$wresults = sort_cRd_cRf($winningNumbers);
		$results = updatePercents(add_arrays($wresults, genNums(100)));
		$results2 = updatePercents(add_arrays($results, genNums(100)));
		$results3 = updatePercents(add_arrays($results2, genNums(100)));
	$perf->end_timer('p_test_1b3');

	d($perf->timeToReadable($perf->timers['p_test_1b3']['total']));

	echo "<ol>";
	ksort($results3);
	$ptotal = 0;
	$petotal = 0;
	foreach ($results3 as $key => $value) {
		$percent = @number_format($wresults[$key]['1b3_percent'], 4);
		$percent1 = @number_format($results[$key]['1b3_percent'], 4);
		$percent2 = @number_format($results2[$key]['1b3_percent'], 4);
		$percent3 = @number_format($results3[$key]['1b3_percent'], 4);
		//$percent = $wresults[$key]['1b3_percent'];
		//$percent1 = $results[$key]['1b3_percent'];
		//$percent2 = $results2[$key]['1b3_percent'];
		//$percent3 = $results3[$key]['1b3_percent'];
		if($results3[$key]['foe'][0] != 'DNE') {
			$ptotal += $percent * percentOfcRd_cRf($key) * 100;
			$petotal += $percent3 * percentOfcRd_cRf($key) * 100;;
			echo "<li><span style='width:100px;display:inline-block'>$key</span>: <span style='color:006699'>$percent%</span>&nbsp;&nbsp;&nbsp; <span style='color:006699'>$percent1%</span>&nbsp;&nbsp;&nbsp; <span style='color:006699'>$percent2%</span>&nbsp;&nbsp;&nbsp; <span style='color:006699'>$percent3%</span> of the {$wresults[$key]['total']} combinations FOE repeated.</li>";
			//echo "<li><span style='width:100px;display:inline-block'>$key</span>: <span style='color:006699'>$percent%</span>&nbsp;&nbsp;&nbsp; <span style='color:006699'>$percent1%</span>&nbsp;&nbsp;&nbsp; of the {$wresults[$key]['total']} combinations FOE repeated.</li>";
		}
	}
	echo "</ol>";

	//$ptotal = @number_format($ptotal, 4, ',', '');
	//$petotal = @number_format($petotal, 4, ',', '');

	echo "<p>Starting percentage: $ptotal% - after 3 years, $petotal%</p>";

	//d($winningNumbers);
	d($wresults);
	//d($results);
	//d($results2);
	//d($results3);

	function percentOfcRd_cRf($cRd_cRf) {
		$t = 500630.860;
		switch ($cRd_cRf) {
			case '111111-21111':
				return 453.6/$t;
				break;
			case '21111-111111':
				return 2268.0/$t;
				break;
			case '21111-21111':
				return 6350.4/$t;
				break;
			case '21111-2211':
				return 2948.4/$t;
				break;
			case '21111-3111':
				return 1209.6/$t;
				break;
			case '21111-321':
				return 475.2/$t;
				break;
			case '2211-111111':
				return 3402/$t;
				break;
			case '2211-21111':
				return 8845.2/$t;
				break;
			case '2211-2211':
				return 3855.6/$t;
				break;
			case '2211-3111':
				return 1360.8/$t;
				break;
			case '2211-321':
				return 518.4/$t;
				break;
			case '222-21111':
				return 1512/$t;
				break;
			case '3111-111111':
				return 3628.8/$t;
				break;
			case '3111-21111':
				return 1360.8/$t;
				break;
			case '3111-2211':
				return 504/$t;
				break;
			case '3111-3111':
				return 907.2/$t;
				break;
			case '321-111111':
				return 1512/$t;
				break;
			case '321-21111':
				return 3326.4/$t;
				break;
			case '321-2211':
				return 1209.6/$t;
				break;
			case '411-21111':
				return 680.4/$t;			
			default:
				return 0;
				break;
		}
	}