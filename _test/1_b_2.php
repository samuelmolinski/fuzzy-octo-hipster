<h1>Test 1.b.2</h1>
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
		$c->id = 'blah';
		$winningNumbers[] = $c;
		unset($c);
	}

	usort($winningNumbers, 'cmp_func');

	function cmp_func($A, $B) {
		$a = $A->id;
		$b = $B->id;
		return strcmp($a, $b);
	}

	//d($winningNumbers);

	//d($winningNumbers);	

	$test = new CombinationTest;
	$pTest = new CombinationPreliminarTest;
	$cs1 = new CombinationStatistics;
	$c1 = new Combination;
	$c2 = new Combination;
	$c3 = new Combination;
	$c4 = new Combination;
	$c5 = new Combination;
	$c6 = new Combination;
	$c7 = new Combination;
	$c8 = new Combination;
	$c9 = new Combination;
	$perf = new performance;

	$cs1->set_d(array('01','02','06','16','19','46'));

	$c1->set_d(array('01','02','06','16','19','46'));
	$c2->set_d(array('01','02','06','19','27','46'));
	$c3->set_d(array('01','03','06','19','27','46'));
	$c4->set_d(array('01','05','06','27','42','46'));
	$c5->set_d(array('01','05','07','27','42','59'));
	$c6->set_d(array('19','31','39','44','53','59'));
	$c7->set_d(array('01','03','06','19','27','46'));
	$c8->set_d(array('01','03','06','19','27','46'));
	$c9->set_d(array('01','03','06','19','27','46'));

	$cs1->gen_id();

	$c1->gen_id();
	$c2->gen_id();
	$c3->gen_id();
	$c4->gen_id();
	$c5->gen_id();
	$c6->gen_id();
	$c7->gen_id();
	$c8->gen_id();
	$c9->gen_id();

	$cs1->populateStats();

	$arrTest = array($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9);

	$winningStats = array();
	
	$perf->start_timer('p_test_1b2');

	foreach ($winningNumbers as $key => $value) {
		$n = new CombinationStatistics;
		$n->set_d($value->d);
		$n->gen_id();	
		$n->populateStats();
		$winningStats[] = $n;
		unset($n);
	}
	//$results = $pTest->p_test_1b1($arrTest, $arrTest
	//$results = $pTest->p_test_1b1($winningNumbers, $winningNumbers);
	$results = $winningStats;
	$perf->end_timer('p_test_1b2');
	//$results = $test->numElementsEqual($c1, $c2);
	d(json_encode($winningStats[0]));

	d($results);
	//d($perf->timers);
	d($perf->timeToReadable($perf->timers['p_test_1b2']['total']));
	$totalTime = $perf->timers['p_test_1b2']['total'];
	$count = count($winningNumbers);
	d($totalTime);
	d($count);
	d($totalTime/$count);

	$total = count($winningNumbers);
	$totalOccurance = 0;

	foreach($results as $k=>$v) {
		$totalOccurance += ($v['total']/2);
	}
	$percent = $totalOccurance/$total *100;
	echo "<p>Test 1.b.1: $percent% of the combinations contain 5 numbers that occured in previous winning combinations.</p>";
	//d($winningNumbers);

	/*
	Comb 	count
	1 		2
	2		4
	3 		6
	*/