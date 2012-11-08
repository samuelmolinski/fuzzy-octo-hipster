<h1>Stress Test</h1><?php
	
	set_time_limit(0);

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
	$megaSc = mLoadXml( 'd_megasc100.htm');
    $megaSc = $megaSc->body->table->xpath('tr');
    array_shift($megaSc);

    $winningNumbers = array();
    foreach($megaSc as $k=>$combination) {
        $d = (string)$combination->td[2].(string)$combination->td[3].(string)$combination->td[4].(string)$combination->td[5].(string)$combination->td[6].(string)$combination->td[7];
        //print_r($d.'.');
        $c = new CombinationStatistics($d);
        $winningNumbers[] = $c;
        unset($c);
    }
    //make our combinationGenerator
	$cg = new CombinationGenerator($winningNumbers);
	// init our performance timer
	$p = new Performance();
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
$numOfCombinations = 100;
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
$p->end_timer("True Random Cominations");
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
			$r = $cg->$currentFunction($c, $list);
			if($r) {
				$pass++;
				$list[] = $c;
			}  else {
				$fail[] = $c;
			}
		}
		$p->end_timer($test[0]);
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
		$p->end_timer($test[0]);
	}	
	$av = $p->timers[$test[0]]['total']/$numOfCombinations;
	echo "<li>".$test[0]." - (total time:".$p->timers[$test[0]]['total']." | average time: $av ) passed: $pass";
	sort($fail);
	echo "<ol>";
	foreach ($fail as $k => $c) {
		echo "<li>".$c->print_id()."</li>";
	}
	echo "</ol>";
	echo "</li>";
	//echo($test[0]);
	//d($p->timers[$test[0]]['total']);
}

echo "</ul>";

/*sort($rCombinations);
echo "<ol>";
foreach ($rCombinations as $k => $c) {
	echo "<li>".$c->print_id()."</li>";
}
echo "</ol>";*/