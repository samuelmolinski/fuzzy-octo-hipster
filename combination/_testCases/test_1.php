<h1>Test A.a & B.b</h1>
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
		$Ns = array();
		foreach ($C->d as $k => $N) {
			for ($j=1; $j < 11; $j++) { 
				if(in_array($N, $winningNumbers[$cN-$j]->d)){
					if(!array_key_exists($N->n, $Ns)) {
						$Ns[$N->n] = 1;
					}
					$Ns[$N->n]++;
				}				
			}
		}
		$record[$i] = $Ns;
	}

	d($record);


	