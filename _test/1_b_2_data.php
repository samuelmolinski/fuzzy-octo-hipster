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
		$d = array();
		$d[] = (string)$combination->td[2];
		$d[] = (string)$combination->td[3];
		$d[] = (string)$combination->td[4];
		$d[] = (string)$combination->td[5];
		$d[] = (string)$combination->td[6];
		$d[] = (string)$combination->td[7];
		$c = new CombinationStatistics($d);
		$winningNumbers[] = $c;
		unset($c);
	}

	usort($winningNumbers, 'cmp_func');

	function cmp_func($A, $B) {
		$a = $A->id;
		$b = $B->id;
		return strcmp($a, $b);
	}

	$test = new CombinationTest;
	$pTest = new CombinationPreliminarTest;
	$perf = new performance;

	$perf->start_timer('p_test_1b2');
	//$results = $pTest->p_test_1b2($winningNumbers, $winningNumbers);
	$results = $pTest->p_test_1b2_data($winningNumbers);
	$perf->end_timer('p_test_1b2');

	$totalTime = $perf->timers['p_test_1b2']['total'];
	$count = count($winningNumbers);

	$tTotal = 0;
	$tRepeated = 0;

	$cRd_cRf_order = array('2211-2211','21111-2211','3111-2211','321-2211','3111-21111','321-21111','2211-3111','21111-3111','111111-21111','222-21111','411-21111','3111-3111','2211-21111','2211-111111','21111-21111','21111-111111','321-111111','3111-111111','2211-321','21111-321');
	echo "<p style='padding-left:2.5em;'><span  style='width:130px;display:inline-block;'>cRd_cRf</span><span  style='text-align:right;width:85px;display:inline-block;'>amount of combination</span><span  style='text-align:right;width:130px;display:inline-block;'>amount of<br /> repeation</span></p>";

	echo "<ol>";
	$tTotal = 0;
	$tRepeated = 0;
	foreach ($cRd_cRf_order as $k => $cRd_cRf) {
		if(!empty($results[$cRd_cRf])){		
			$total	= 0;
			$repeated = 0;
			$total = count($results[$cRd_cRf]['combinations']);
			$repeated = count($results[$cRd_cRf]['repeated']);

			echo "<li><span  style='width:130px;display:inline-block;'>$cRd_cRf</span><span  style='width:85px;display:inline-block;text-align:right;'>$total</span><span  style='text-align:right;width:130px;display:inline-block;'>$repeated</span></li>";
		} else {
			echo "<li><span style='width:130px;display:inline-block;'>$cRd_cRf</span><span  style='width:85px;display:inline-block;text-align:right;'>0</span><span  style='text-align:right;width:130px;display:inline-block;s'>0</span></li>";
		}
		$tTotal +=$total;
		$tRepeated +=$repeated;
	}
	$otherTotal = 1427-$tTotal;
	echo "</ol>";
	echo "<p style='padding-left:2.5em;'><span style='width:130px;display:inline-block;'>subtotal</span><span style='text-align:right;width:85px;display:inline-block;'>$tTotal</span><span style='text-align:right;width:130px;display:inline-block;'>$tRepeated</span></p>";
	echo "<p style='padding-left:2.5em;'><span style='width:130px;display:inline-block;'>Others</span><span style='text-align:right;width:85px;display:inline-block;'>$otherTotal</span><span style='text-align:right;width:130px;display:inline-block;'> --- </span></p>";
	echo "<p style='padding-left:2.5em;'><span style='width:130px;display:inline-block;'>Total</span><span style='text-align:right;width:85px;display:inline-block;'>1427</span><span style='text-align:right;width:130px;display:inline-block;'>$tRepeated</span></p>";

	/*echo "The following 4N-cRd/cDf were found in the current drawn lottery tickets:";
	echo "<ol>";
	foreach ($results as $key => $value) {
		$count = count($value['combinations']);
		echo "<li>$key: was found $count times in the following cominations:<ul>";
		foreach ($value['combinations'] as $key => $value) {
			echo "<li>$value</li>";
		}
		echo "</ul></li>";
	}
	echo "</ol>";*/

	//d($results);