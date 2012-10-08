<h1>Test 1.b.1</h1>
<?php 
	
	ini_set('memory_limit', '512M');
	set_time_limit(0);
	
	require_once('../m_toolbox/m_toolbox.php');
	require_once('../Class_Performance.php');
	require_once('../Class_CombinationWinning.php');
	require_once('../Class_CombinationStatistics.php');
	require_once('../Class_CombinationPreliminarTest.php');

	$perf = new performance;

	$perf->start_timer('p_test_1b1');
		$limit = 1000000;
		$hits = 0;
		$tests = 0;
		$testCase = CombinationTest::randCombination();
			d($testCase);
		for ($i=0; $i < $limit; $i++) {
			$tests++;
			$rc = CombinationTest::randCombination();
			//d($rc);
			$numElemEqual =  CombinationTest::numElementsEqual($testCase, $rc);
			//d($numElemEqual);
			if (5 == $numElemEqual['num']) { 
				d($rc);
				d($numElemEqual);
				$hits++;
			}
			unset($rc);
		}
	$perf->end_timer('p_test_1b1');

	d($perf->timeToReadable($perf->timers['p_test_1b1']['total']));
	$totalTime = $perf->timers['p_test_1b1']['total'];
	d($hits);
	d($tests);
	d($hits/$tests);

	$percent = $hits/$tests * 100;
	$percent2 = ($tests-$hits)/$tests * 100;
	echo "<p>Test 1.b.2:   $percent% of the combinations contain 4 numbers that occured in previous winning combinations.</p> <p>($percent2%) - memory_get_peak_usage: ".memory_get_peak_usage()."bytes </p>";