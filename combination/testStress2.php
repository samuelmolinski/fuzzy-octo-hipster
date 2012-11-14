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
	//$megaSc = mLoadXml( 'd_megasc100.htm');
    //$megaSc = $megaSc->body->table->xpath('tr');
    //array_shift($megaSc);
$numOfCombinations = 120;
$numberOfWinningCombinatinos = 1500;
    $winningNumbers = array();
    /*foreach($megaSc as $k=>$combination) {
        $d = (string)$combination->td[2].(string)$combination->td[3].(string)$combination->td[4].(string)$combination->td[5].(string)$combination->td[6].(string)$combination->td[7];
        //print_r($d.'.');
        $c = new CombinationStatistics($d);
        $winningNumbers[] = $c;
        unset($c);
    }*/
    $cg = new CombinationGenerator();
    for($j =0; $j < $numberOfWinningCombinatinos; $j++){	
		$winningNumbers[] = $cg->rule_1a1(array(),TRUE);
	}
    //make our combinationGenerator
	$cg = new CombinationGenerator($winningNumbers);
	// init our performance timer
	$p = new Performance();
	// $c is the current combination
	// $list is the current list of excepted playable combinations

	$tests_pre = array(array('rule_1a1', 'c'),
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

	$tests = array(
				   array('rule_2_2_1b', 'c'),
				   array('rule_2_2_1c', 'c'),
				   array('rule_1a4', 'c'),
				   array('rule_1a2', 'c'),
				   array('rule_1a3', 'c'),
				   array('rule_1a1', 'c'),
				   array('rule_1a8', 'c'),
				   array('rule_2_2_2', 'c'),
				   array('rule_2_1a', 'c', 'list'),
				   array('rule_2_2_1a', 'c'),
				   array('rule_2_2_1d', 'c'),
				   array('rule_1a6', 'c'),
				   array('rule_2_2_1e', 'c'),
				   array('rule_2_1c', 'c'),
				   array('rule_2_1b', 'c'),
				   array('rule_1a5', 'c'),
				   array('rule_1a7', 'c'),
				   array('rule_1b2', 'c', 'list'),
				   array('rule_1b3', 'c', 'list'),
				   array('rule_1b1', 'c', 'list'),
				);

	$tests2 = array(
				   array('rule_2_2_2', 'c'),
				   array('rule_2_2_1a', 'c'),
				   array('rule_1a1', 'c'),
				   array('rule_2_2_1b', 'c'),
				   array('rule_2_1a', 'c', 'list'),
				   array('rule_1a2', 'c'),
				   array('rule_1a8', 'c'),
				   array('rule_1a6', 'c'),
				   array('rule_1a5', 'c'),
				   array('rule_2_2_1d', 'c'),
				   array('rule_2_2_1c', 'c'),
				   array('rule_1a7', 'c'),
				   array('rule_2_1c', 'c'),
				   array('rule_2_2_1e', 'c'),
				   array('rule_1a3', 'c'),
				   array('rule_1a4', 'c'),
				   array('rule_2_1b', 'c'),
				   array('rule_1b3', 'c', 'list'),
				   array('rule_1b2', 'c', 'list'),
				   array('rule_1b1', 'c', 'list'),
				);
	$tests3 = array(
				   array('rule_2_2_2', 'c'),
				   array('rule_2_2_1b', 'c'),
				   array('rule_2_2_1a', 'c'),
				   array('rule_2_2_1c', 'c'),
				   array('rule_1a1', 'c'),
				   array('rule_2_1a', 'c', 'list'),
				   array('rule_1a2', 'c'),
				   array('rule_1a8', 'c'),
				   array('rule_1a6', 'c'),
				   array('rule_1a5', 'c'),
				   array('rule_2_2_1d', 'c'),
				   array('rule_1a7', 'c'),
				   array('rule_2_1c', 'c'),
				   array('rule_2_2_1e', 'c'),
				   array('rule_1a3', 'c'),
				   array('rule_1a4', 'c'),
				   array('rule_1b3', 'c', 'list'),
				   array('rule_2_1b', 'c'),
				   array('rule_1b2', 'c', 'list'),	// *
				   array('rule_1b1', 'c', 'list'),	// *
				);

//lets start with true random 1200 generated combinations to test against each

echo "<h2>Results for $numOfCombinations combinations</h2>";
echo "<ul>";
$p->start_timer("Over All");
$fail = 0;
$count = 0;
$comb = array();
$genTmp = 0;
do {
	//create Combination 
	do {
		$genTmp++;
		$list = array();
		for ($i=0; $i < 6; $i++) { 
			$comb[$i] = $cg->genUniqueRand($list);
			$list[] = $comb[$i]->n;
		}
		$c = new CombinationStatistics($comb);
	} while (in_array($c, $cg->currentBettingCombinations));
	$count++;
	foreach ($tests3 as $j => $test) {
		$currentFunction = $test[0];
		if(2 < count($test)) {
			//echo "<li>requires \$list</li>";
			$r = $cg->$currentFunction($c, $cg->wCombs);
			if(!$r) {
				$fail++;
				continue 2;
			}
		} else {
			$r = $cg->$currentFunction($c);
			
			if(!$r) {
				$fail++;
				continue 2;
			}
		}
	}
	// if all is well we add it 
	$cg->currentBettingCombinations[] = $c;
	//if($genTmp > $numOfCombinations) break;
} while ($numOfCombinations > count($cg->currentBettingCombinations));
$p->end_timer("Over All");
echo "</ul>";

$p->sortByTotalTime();
//d($cg->currentBettingCombinations);
d($count);
d($p);
d($tests3);

sort($cg->currentBettingCombinations);
echo "<ol>";
foreach ($cg->currentBettingCombinations as $k => $c) {
	echo "<li>".$c->print_id()."</li>";
}
echo "</ol>";
