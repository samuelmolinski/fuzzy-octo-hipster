<h1>Test 1.b.1</h1>
<?php 
	
	set_time_limit(0);
	
	require_once('../../m_toolbox/m_toolbox.php');
	require_once('../Performance.php');
	require_once('../CombinationStatistics.php');
	require_once('../CombinationWinning.php');
	require_once('../CombinationEvaluation.php');
	require_once('../CombinationPreliminarEvaluation.php');

	$megaSc = mLoadXml('dd_megasc.htm');
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

	d($winningNumbers);

	$test = new CombinationTest;
	$pTest = new CombinationPreliminarTest;
	$perf = new performance;

	$perf->start_timer('p_test_1b1');
	//$results = $pTest->p_test_1b1($arrTest, $arrTest);
	$results = $pTest->p_test_1b1($winningNumbers, $winningNumbers);
	$perf->end_timer('p_test_1b1');
	//$results = $test->numElementsEqual($c1, $c2);

	//d($perf->timers);
	//d($perf->timeToReadable($perf->timers['p_test_1b1']['total']));

	$total = count($winningNumbers);
	$totalOccurance = 0;

	foreach($results as $k=>$v) {
		$totalOccurance += ($v['total']);
	}
	$percent = $totalOccurance/$total *100;
	//d($perf->timers['p_test_1b1']['total']/$total);
	echo "The following 5N were found in the current drawn lottery tickets:";
	echo "<ol>";
	foreach ($results as $key => $value) {
		$count = count($value['combinations']);
		echo "<li>$key: was found $count times in the following cominations:<ul>";
		foreach ($value['combinations'] as $key => $value) {
			echo "<li>$value</li>";
		}
		echo "</ul></li>";
	}
	echo "</ol>";

	//d($results);

	/*
	Comb 	count
	1 		2
	2		4
	3 		6
	*/