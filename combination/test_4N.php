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
	require_once("CombinationStatistics.php");
	require_once("CombinationList.php");

	//got to get those old winning numbers
	$megaSc = mLoadXml( 'D_MEGA.HTM');
    $megaSc = $megaSc->body->table->xpath('tr');
    array_shift($megaSc);

	$p = new Performance();
    $winningNumbers = array();
    foreach($megaSc as $k=>$combination) {
        $d = (string)$combination->td[2].(string)$combination->td[3].(string)$combination->td[4].(string)$combination->td[5].(string)$combination->td[6].(string)$combination->td[7];
        //print_r($d.'.');
        $c = new CombinationStatistics($d);
        $winningNumbers[] = $c;
        unset($c);
    }

	// $c is the current combination
	// $list is the current list of excepted playable combinations


//lets start with true random 1000 generated combinations to test against each
$stats = array();
$tStats = array();
$cg = new CombinationGenerator();
$cl = new CombinationList($winningNumbers);
d($cl);
d($cl);

$p->start_timer("Over All");
$numOfCombinations = 1000;
$numberOfWinningCombinatinos = 1500;
for ($itr=0; $itr < 1; $itr++) { 

		public function rule_1b1($combination, $list, $threshold = 4) {
			foreach ($list as $j => $value) {
				if($this->numElementsEqual($combination, $value) >= $threshold) {
					echo("<li>")
				}
			}
			return TRUE;
		}
}
$p->end_timer("Over All");
$p->sortByTotalTime();

/*sort($rCombinations);
echo "<ol>";
foreach ($rCombinations as $k => $c) {
	echo "<li>".$c->print_id()."</li>";
}
echo "</ol>";*/