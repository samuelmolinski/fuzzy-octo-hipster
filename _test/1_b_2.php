<h1>Test 1.b.2</h1>
<?php 
	
	ini_set('memory_limit', '512M');
	set_time_limit(0);
	
	require_once('../m_toolbox/m_toolbox.php');
	require_once('../Class_Performance.php');
	require_once('../Class_CombinationWinning.php');
	require_once('../Class_CombinationStatistics.php');
	require_once('../Class_CombinationPreliminarTest.php');

	$perf = new performance;
	$results = array();
	$t = 0;

	$perf->start_timer('p_test_1b2');
		for ($j=0; $j < 1000; $j++) { 
			$limit = 10000;
			$hits = 0;
			$tests = 0;
			$testCase = CombinationTest::randCombination();
				d($testCase);
			for ($i=0; $i < $limit; $i++) {
				$tests++;
				$rc = CombinationTest::randCombination();
				$numElemEqual =  CombinationTest::numElementsEqual($testCase, $rc);
				if ((4 == $numElemEqual['num'])&&($testCase->cRd == $rc->cRd)&&($testCase->cRf == $rc->cRf)) { 
					d($rc);
					d($numElemEqual);
					$hits++;
				}
				unset($rc);
			}
			$results[] = $hits/$tests;
		}
	$perf->end_timer('p_test_1b2');

	d($perf->timeToReadable($perf->timers['p_test_1b2']['total']));
	$totalTime = $perf->timers['p_test_1b2']['total'];
	foreach ($results as $key => $value) {
		$t += $value;
	}
	d($t);
	d(count($results));
	//d($hits/$tests);

	$percent = $t/count($results) * 100;
	//$percent2 = ($tests-$hits)/$tests * 100;
	echo "<p>Test 1.b.2:   $percent% of the combinations contain 4 numbers that occured in previous winning combinations.</p> <p>(%) - memory_get_peak_usage: ".memory_get_peak_usage()."bytes </p>";

	//d($winningNumbers);

	/*
	Comb 	count
	1 		2
	2		4
	3 		6
	*/