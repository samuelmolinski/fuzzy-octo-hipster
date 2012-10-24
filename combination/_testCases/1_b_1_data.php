<h1>Test 1.b.1</h1>
<?php 
	
	set_time_limit(0);
	
	require_once('../m_toolbox/m_toolbox.php');
	require_once('../Class_Performance.php');
	require_once('../Class_CombinationStatistics.php');
	require_once('../Class_CombinationWinning.php');
	require_once('../Class_CombinationTest.php');
	require_once('../Class_CombinationPreliminarTest.php');

	$megaSc = mLoadXml('d_megasc.htm');
	$megaSc = $megaSc->body->table->xpath('tr');
	array_shift($megaSc);

	$winningNumbers = array();
	foreach($megaSc as $k=>$combination) {
		$c = new CombinationWinning;
		//d($combination);
		//d($c);
		$c->date = (string)$combination->td[1];
		$c->d[] = (string)$combination->td[2];
		$c->d[] = (string)$combination->td[3];
		$c->d[] = (string)$combination->td[4];
		$c->d[] = (string)$combination->td[5];
		$c->d[] = (string)$combination->td[6];
		$c->d[] = (string)$combination->td[7];
		$c->gen_id();
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