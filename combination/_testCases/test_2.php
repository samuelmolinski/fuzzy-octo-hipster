<h1>Test 2 N not used</h1>
<?php 
	
	set_time_limit(0);
	
	require_once('../../m_toolbox/m_toolbox.php');
	require_once('../Performance.php');
	require_once('../CombinationStatistics.php');

	$megaSc = mLoadXml('d_megasc.htm');
	$megaSc = $megaSc->body->table->xpath('tr');
	array_shift($megaSc);

	$winningNumbers = array();
	foreach($megaSc as $k=>$combination) {
		$d = array();
		//d($c);
		//$c->date = (string)$combination->td[1];
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

	//d($winningNumbers);

	d(count($winningNumbers));	
	$count = count($winningNumbers);
	$record = array();
	for ($i=1; $i < 101; $i++) {
		$cN =  $count - $i;
		$C = $winningNumbers[$cN];
		$Ds = array();
		//d($C->d);
		foreach ($C->d as $k => $N) {
			if(!array_key_exists($N->D, $Ds)) {
				$Ds[$N->D] = 0;
			}
			$Ds[$N->D]++;
		}
		$record[$i] = $Ds;
	}

	//d($record);

	echo "<span style='margin-left: 1em;width:70px;display:inline-block;'>1-10</span><span style='width:70px;display:inline-block;'>11-20</span><span style='width:70px;display:inline-block;'>21-30</span><span style='width:70px;display:inline-block;'>31-40</span><span style='width:70px;display:inline-block;'>41-50</span><span style='width:70px;display:inline-block;'>51-60</span>";
	echo "<ol>";
	foreach ($record as $k => $test) {
		echo "<li>";
		for ($i=0; $i < 6; $i++) { 
			echo "<span style='width:70px;display:inline-block;'>";
			if(!array_key_exists($i, $test)){
				echo 'no';
			}
			echo "</span>";
		}
		echo "</li>";
	}
	echo "</ol>";
	