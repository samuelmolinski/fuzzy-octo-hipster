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
	// $c is the current combination
	// $list is the current list of excepted playable combinations

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

//lets start with 1000 generated combinations to test against each

for($i =0; $i < 1000; $i++){
	'c'ombinations[] = $cg->rule_1a1(array(), True)
}