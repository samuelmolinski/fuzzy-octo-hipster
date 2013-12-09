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
	
	$cRd_cRf = array();

	d(count($winningNumbers));	
	$count = count($winningNumbers);

	foreach ($winningNumbers as $k => $c1) {
		foreach ($winningNumbers as $k => $c2) {
			$equal = numElementsEqual($c1, $c2);
			if(($c1 != $c2)&&($equal > 3)) {
				if($c1->cRd_cRf == $c2->cRd_cRf){
					$N_same = array();
					foreach ($c1->d as $N1) {
						foreach ($c2->d as $N2) {
							if($N1->n == $N2->n) {
								$N_same[] = $N2->n;
							}
						}
					}
					if(!isset($cRd_cRf[$c1->cRd_cRf])) { $cRd_cRf[$c1->cRd_cRf] = array();}
					$cRd_cRf[$c1->cRd_cRf][] = $N_same;
				}
			}
		}
	}

	//d($cRd_cRf);

	
	echo "<ol>";

	$fails1 = 0;
	$fails2 = 0;
	$fails3 = 0;
	$fails4 = 0;

	foreach ($cRd_cRf as $cRdcRf => $N4s) {
		echo "<li>[$cRdcRf]</br>";
		foreach ($N4s as $k => $N4) {
			sort($N4);
			echo "{$N4[0]}-{$N4[1]}-{$N4[2]}-{$N4[3]}, &nbsp;&nbsp;";
		}
		echo "</li>";
	}
	echo "</ol>";


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
	