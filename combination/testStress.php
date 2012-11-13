<h1>Stress Test</h1><?php
	
	set_time_limit(0);
	error_reporting(E_ALL);

	if (!defined('ABSPATH')) {
		define('ABSPATH', dirname(__FILE__) . '/');
	}
	
	if (!defined('TESTPATH')) {
		define('TESTPATH', dirname(__FILE__) . '/_unitTesting/');
	}

	//required files
	require_once ('../m_toolbox/m_toolbox.php');
	require_once ('Performance.php');
	require_once ('CombinationGenerator.php');

	//got to get those old winning numbers
	//$megaSc = mLoadXml( 'd_megasc100.htm');
    //$megaSc = $megaSc->body->table->xpath('tr');
    array_shift($megaSc);

	$p = new Performance();
    $winningNumbers = array();
    /*foreach($megaSc as $k=>$combination) {
        $d = (string)$combination->td[2].(string)$combination->td[3].(string)$combination->td[4].(string)$combination->td[5].(string)$combination->td[6].(string)$combination->td[7];
        //print_r($d.'.');
        $c = new CombinationStatistics($d);
        $winningNumbers[] = $c;
        unset($c);
    }*/
	// init our performance timer

	//$p->sortByTotalTime();
	// $c is the current combination
	// $list is the current list of excepted playable combinations

	$tests_1a = array(array('rule_1a1', 'c'),
				   array('rule_1a2', 'c'),
				   array('rule_1a3', 'c'),
				   array('rule_1a4', 'c'),
				   array('rule_1a5', 'c'),
				   array('rule_1a6', 'c'),
				   array('rule_1a7', 'c'),
				   array('rule_1a8', 'c'),
				);

	$tests = array(array('rule_1a1', 'c'),
				   array('rule_1a2', 'c'),
				   array('rule_1a3', 'c'),
				   array('rule_1a4', 'c'),
				   array('rule_1a5', 'c'),
				   array('rule_1a6', 'c'),
				   array('rule_1a7', 'c'),
				   array('rule_1a8', 'c'),
				   array('rule_1b1', 'c', 'list'),
				   array('rule_1b2', 'c', 'list'),
				   array('rule_1b3', 'c', 'list'),
				   array('rule_2_1a', 'c', 'list'),
				   array('rule_2_1b', 'c'),
				   array('rule_2_1c', 'c'),
				   array('rule_2_2_1a', 'c'),
				   array('rule_2_2_1b', 'c'),
				   array('rule_2_2_1c', 'c'),
				   array('rule_2_2_1d', 'c'),
				   array('rule_2_2_1e', 'c'),
				   array('rule_2_2_2', 'c'),
				);

//lets start with true random 1000 generated combinations to test against each
$stats = array();
$tStats = array();
$p->start_timer("Over All");
$numOfCombinations = 100;
$numberOfWinningCombinatinos = 1500;
for ($itr=0; $itr < 1; $itr++) { 

	$p->start_timer('Inner');
	$p->start_timer('Random Winning Cominations');
	$cg = new CombinationGenerator();
	for($j =0; $j < $numberOfWinningCombinatinos; $j++){	
		$winningNumbers[] = $cg->rule_1a1(array(),TRUE);
	}
	$p->plus_end_timer('Random Winning Cominations');

	//make our combinationGenerator
	$rCombinations = array();
	$cg = new CombinationGenerator($winningNumbers);

	$stats['limit_2_1c'] = $cg->limit_2_1c;
	$stats['rule_2_2_1a_invalid'] = $cg->rule_2_2_1a_invalid;
	$stats['rule_2_2_1b_invalid'] = $cg->rule_2_2_1b_invalid;
	$stats['rule_2_2_1c_invalid'] = $cg->rule_2_2_1c_invalid;
	$stats['listRule_2_2_1e'] = $cg->listRule_2_2_1e;
	$stats['rule_2_2_2_invalid'] = $cg->rule_2_2_2_invalid;
	$tStats[] = $stats;
	$p->start_timer('True Random Cominations');
	for($j =0; $j < $numOfCombinations; $j++){	
		$list = array();
		for ($i=0; $i < 6; $i++) { 
			$comb[$i] = $cg->genUniqueRand($list, 1, 60);
			$list[] = $comb[$i]->n;
		}
		//must return a CombinationStatistics
		$rCombinations[] = new CombinationStatistics($comb);
	}
	$p->plus_end_timer("True Random Cominations");
	echo "<h2>Results for $numOfCombinations combinations</h2>";
	echo "<p>rule_2_2_1d_invalid ".$cg->rule_2_2_1d_invalid. "</p>";
	echo "<ul>";
	foreach ($tests as $j => $test) {
		$currentFunction = $test[0];
		$pass = 0;
		$fail = array();
		$list = array();
		$count = count($test);
		//echo "<li>$count requires \$list</li>";
		if(2 < $count) {
			//echo "<li>requires \$list</li>";
			$p->start_timer($test[0]);
			foreach ($rCombinations as $k => $c) {
				$r = $cg->$currentFunction($c, $cg->wCombs);
				if($r) {
					$pass++;
					$list[] = $c;
				}  else {
					$fail[] = $c;
				}
			}
			$p->plus_end_timer($test[0]);
		} else {
			$p->start_timer($test[0]);
			foreach ($rCombinations as $k => $c) {
				$r = $cg->$currentFunction($c);
				if($r) {
					$pass++;
					$list[] = $c;
				}  else {
					$fail[] = $c;
				}
			}
			$p->plus_end_timer($test[0]);
		}	
		$av = $p->timers[$test[0]]['total']/$numOfCombinations;
		echo "<li>".$test[0]." - (total time:".$p->timers[$test[0]]['total']." | average time: $av ) passed: $pass";
		sort($fail);
		echo "</li>";
	}
	echo "</ul>";
	d($stats);
	$p->plus_end_timer('Inner');
}
$p->end_timer("Over All");
$p->sortByTotalTime();
d($p);
d($tStats);

/*sort($rCombinations);
echo "<ol>";
foreach ($rCombinations as $k => $c) {
	echo "<li>".$c->print_id()."</li>";
}
echo "</ol>";*/