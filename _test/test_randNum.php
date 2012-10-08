<?php
	
	require_once('../m_toolbox/m_toolbox.php');
	require_once('../Class_Performance.php');
	//require_once('Class_Combination.php');
	require_once('../Class_CombinationWinning.php');
	require_once('../Class_CombinationStatistics.php');
	//require_once('Class_CombinationTest.php');
	require_once('../Class_CombinationPreliminarTest.php');


	$test = new CombinationTest;
	$perf = new performance;


	$perf->start_timer('generateRandCombs');
	//$results = $pTest->p_test_1b1($arrTest, $arrTest
	//$results = $pTest->p_test_1b1($winningNumbers, $winningNumbers);
	//$results = $pTest->p_test_1b2($arrTest,$arrTest, 4);
	//$results = $pTest->p_test_1b2($sub,$sub);
	$randNum = $test->generateRandCombs(1000);
	$perf->end_timer('generateRandCombs');

	$totalTime = $perf->timers['generateRandCombs']['total'];
	$count = count($randNum);
	d($totalTime);
	d($count);
	d($totalTime/$count);

	$totalOccurance = 0;

	d($randNum);

	//echo "<p>Test 1.b.1: $percent% of the combinations contain 4 numbers that occured in previous winning combinations.</p>";