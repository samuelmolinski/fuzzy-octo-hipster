<h1>N1 and percentage of occurances</h1>
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

	$cRd = array();
	$results = array();
	$accepted = array('321','222','3111','2211');
	foreach ($winningNumbers as $k => $c) {
		if(in_array($c->cRd, $accepted)){
			if(!isset($cRd[$c->cRd])){$cRd[$c->cRd] = array();}
			if(!isset($cRd[$c->cRd][$c->print_cDd()])){$cRd[$c->cRd][$c->print_cDd()] = array();}
			$ts = createTriples($c);
			foreach ($ts as $triple) {
				if(!isset($cRd[$c->cRd][$c->print_cDd()][$triple])) {$cRd[$c->cRd][$c->print_cDd()][$triple] = 0;}
				$cRd[$c->cRd][$c->print_cDd()][$triple]++;
			}
		}
	}

	//d($cRd);

	foreach ($cRd as $_cRd => $cDds) {
		if(!isset($results[$_cRd])){$results[$_cRd] = array();}
		foreach ($cDds as $cDd => $triples) {
			//if(!isset($results[$_cRd][$cDd])){$results[$_cRd][$cDd] = array();}
			foreach ($triples as $triple => $count) {
				if($count < 2){
					//unset($cRd[$_cRd][$cDd][$triple]);
				} else {
					//d($cRd[$_cRd][$cDd][$triple]);

					if(!isset($results[$_cRd][$cDd])){$results[$_cRd][$cDd] = array();}
					$results[$_cRd][$cDd][$triple] = $count;
				}
			}
		}
	}

	/*foreach ($winningNumbers as $c) {
		if(!isset($results[$c->d[0]->n])){$results[$c->d[0]->n] = array(0,0);}
		$results[$c->d[0]->n][0]++;
	}
	d($count);

	foreach ($results as $k => $a) {
		$results[$k][1] = number_format ( $a[0]/$count*100 , 2 );
	}
	ksort($results);*/
	d($results);

	function createTriples($c){
		$r = array();
		foreach ($c->d as $N1) {
			foreach ($c->d as $N2) {
				if($N1 != $N2){
					foreach($c->d as $N3){
						if(($N3 != $N1)&&($N3 != $N2)){
							$a = array($N1->n,$N2->n,$N3->n);
							sort($a);
							if(!in_array($N1->n.$N2->n.$N3->n, $r)) {$r[] = $N1->n.$N2->n.$N3->n;}
						}
					}
				}
			}
		}
		return $r;
	}

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
	