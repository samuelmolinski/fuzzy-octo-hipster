<h1>Test 2 N not used</h1>
<?php 
	
	set_time_limit(0);
	
	require_once('../../m_toolbox/m_toolbox.php');
	require_once('../Performance.php');
	require_once('../CombinationStatistics.php');

	$megaSc = mLoadXml('D_MEGA.HTM');
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
	$fails1 = 0;
	$fails2 = 0;
	$fails3 = 0;
	$fails4 = 0;
	foreach ($winningNumbers as $k => $c1) {
		echo "<li>";
		foreach ($winningNumbers as $k => $c2) {
			$equal = numElementsEqual($c1, $c2);
			if(($c1 != $c2)&&($equal > 3)) {
				echo "{$equal}N Equal, ";
				if($c1->cRd_cRf == $c2->cRd_cRf){
					echo "[cRd_cRf equal]";
					$fails1++;
				}
				if($c1->cDd == $c2->cDd){
					echo "[cDd equal]";
					$fails2++;
				}
				if($c1->cDf == $c2->cDf){
					echo "[cDf equal]";
					$fails3++;
				}
				if(($c1->cDf == $c2->cDf)&&($c1->cDd == $c2->cDd)){
					echo "[cDd_cDf equal]";
					$fails4++;
				}
			}

		}
		echo "</li>";
	}
	echo "</ol>";

	echo "Failed with 4N and cRd-cRf equal: $fails1";
	echo "Failed with 4N and cDd equal: $fails2";
	echo "Failed with 4N and cDf equal: $fails3";
	echo "Failed with 4N and cDd-cDf equal: $fails4";


		function numElementsEqual($c1, $c2) {
			$num = 0;
			if($c1 != $c2) {
				foreach ($c2->d as $key => $value) {
					if(in_array($value, $c1->d)) {
						$num++;
					}
				}
			} else {
				$num = 6;
			}
			return $num;
		}
	