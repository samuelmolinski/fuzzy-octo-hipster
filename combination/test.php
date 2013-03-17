<?php 
	require('Seed_LF.php');
	require('LF_Restrictions.php');

?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<title>Lotto Facil</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<style type="text/css">
		
		th, td {
			padding: .25em .5em;

		}
		.error1, .error2, .error3, .error4 {
			color: rgb(228, 81, 81);
			/*font-weight: 600;*/
		}
		#printID {
			color: #000;
		}

		#printID.error1 .printHTML_id-0 {
			color: rgb(228, 81, 81);
		}

		#printID.error2 .printHTML_id-1 {
			color: rgb(228, 81, 81);
		}

		#printID.error3 .printHTML_id-14 {
			color: rgb(228, 81, 81);
		}
		.key10.error1 .pass{
			display: none;
		}
		.key10 .fail{
			display: none;
		}
		.key10.error1 .fail{
			display: inline;
		}
		.key4, .key5, .key6 { /*display: none;*/}
	</style>
</head>
<body>
<?php 
	$test = new Seed_LF;
	$r = new LF_Restrictions;
	$configs = array();
	global $errors, $passed;
	$errors = array();
	$passed = array();

	function hasError($id, $key, $passed, $p2 = true, $p3 = true, $p4 = true) {

		global $errors, $pass;
		if(!isset($errors[$key])) {$errors[$key] = 0;}
		if(!isset($pass[$id])) {$pass[$id] = true;}		

		$class = "class='key$key";
		if(!$passed){
			$class .= " error1";
		}
		if(!$p2){
			$class .= " error2";
		}
		if(!$p3){
			$class .= " error3";
		}
		if(!$p4){
			$class .=  " error4";
		}
		if(!$passed || !$p2 || !$p3 || !$p4){
			$errors[$key]++;
			$pass[$id] = false;
		}
			return $class."'";
	}
	function isValid($passed, $p2 = true, $p3 = true, $p4 = true) {
		if(!$passed || !$p2 || !$p3 || !$p4){
			return false;
		}
		return true;
	}
?>
<table>
	<tr>
		<th>Test</th><th>Values</th><th>D</th><th>P/I</th><th>DF1/5</th><th>DF6/0=s</th><th>3DF=s</th><th>DF Único</th><th>N consec.</th><th>N=s t.a</th><th>restriction 1-2</th><th>14N = a</th>
	</tr>
	<?php 
		$wNc = count($test->wC);
		$table = array();
		$limit = 150;
		//$limit = $wNc-10;
		for ($i=0; $i < $limit; $i++) { 
			$id = $wNc-$i;
			$C = $test->wC[$id];
			$C1 = $test->wC[$id-1];
			$C2 = $test->wC[$id-2];
			$C3 = $test->wC[$id-3];
			$C4 = $test->wC[$id-4];
			$C5 = $test->wC[$id-5];
			$C6 = $test->wC[$id-6];
			$C7 = $test->wC[$id-7];
			$C8 = $test->wC[$id-8];
			$C9 = $test->wC[$id-9];
			$C10 = $test->wC[$id-10];
			$list = array($C1, $C2, $C3, $C4, $C5, $C6, $C7, $C8, $C9, $C10);

			$tr = '';
			$tr .= "\n\r<tr>";
			$tr .= "\n\r\t<td>$id</td>";
			$tr .= "\n\r\t<td id='printID' ".hasError($id, 0, $r->restrict_N0($C), $r->restrict_N1($C), $r->restrict_N14($C)).">".$C->printHTML_id()."</td>";

			//print D_config
			$tr .= "\n\r\t<td ".hasError($id, 1, $r->restrict_D_config($C), $r->restrict_accepted_D_config($C), $r->restrict_D_config_limit($C,$C1)).">";
			$temp = $C->D_config;
			$tr .= $temp[0];
			array_shift($temp);
			foreach ($temp as $key => $v) {
				$tr .= '-'.$v;
			}
			$tr .= "</td>";

			// print P/I
			$tr .= "\n\r\t<td ".hasError($id, 2, $r->restrict_P_I($C), $r->restrict_P_I_limit($C, $list)).">".$C->P_I.'-'.(15-$C->P_I)."</td>";

			//print DF1/5
			$tr .= "\n\r\t<td ".hasError($id, 3, $r->restrict_DF1_5($C), $r->restrict_DF1_5_limit($C, $list)).">".$C->DF1_5."</td>";

			//print DF6_0s
			$tr .= "\n\r\t<td ".hasError($id, 4, $r->restrict_DF6_0s($C), $r->restrict_DF6_0s_limit($C, $list)).">".$C->DF6_0s."</td>";

			//print DFx3s
			//$tr .= "\n\r\t<td ".hasError(5, $r->restrict_DFx3s($C), $r->restrict_DFx3s_limit_a($C, $list), $r->restrict_DFx3s_limit_b($C, $list)).">";
			$tr .= "\n\r\t<td ".hasError($id, 5, $r->restrict_DFx3s($C), $r->restrict_DFx3s_limit_a($C, $list)).">";
			$temp = $C->DFx3s;
			//d($temp);
			if(!empty($temp)){
				$tr .= $temp[0];
				array_shift($temp);
				foreach ($temp as $key => $v) {
					$tr .= ','.$v;
				}
			} else {
				$tr .= '-';
			}
			$tr .= "</td>";

			//print DF_unique
			$tr .= "\n\r\t<td ".hasError($id, 6, $r->restrict_DF_unique($C), $r->restrict_DF_unique_limit($C, $list)).">";
			$temp = $C->DF_unique;
			//d($temp);
			if(!empty($temp)){
				$tr .= $temp[0];
				array_shift($temp);
				foreach ($temp as $key => $v) {
					$tr .= ','.$v;
				}
			} else {
				$tr .= '-';
			}
			$tr .= "</td>";

			//print N_consec
			$tr .= "\n\r\t<td ".hasError($id, 7, $r->restrict_N_consec($C), $r->restrict_N_consec_limit($C), $r->restrict_N_consec_config_limit($C, $list)).">";
			$temp = $C->N_consec;
			krsort($temp);
			if(!empty($temp)){
				$first = true;
				foreach ($temp as $key => $v) {
					if($first) {
						$tr .= $key.'x'.$v;
					} else if($key != 1) {
						$tr .= ', '.$key.'x'.$v;
					} else {
						$tr .= ', '.$v;
					}
					$first = false;
				}
				if(!isset($temp[1])) {
					$tr .= ', 0';
				}
			} else {
				$tr .= '-';
			}
			$tr .= "</td>";

			$tr .= "\n\r\t<td ".hasError($id, 8, $r->restrict_Ns_ta($C), $r->restrict_Ns_ta_limit($C, $list)).">{$C->Ns_ta}</td>";
			$tr .= "\n\r\t<td ".hasError($id, 9, $r->restrict_1_2config($C, $list)).">{$C->config_1_2}</td>";
			$tr .= "\n\r\t<td ".hasError($id, 10, $r->N_14_equal($C, $list))."><span class='fail'>Fail</span><span class='pass'>Pass</span></td>";
			$tr .= "\n\r</tr>";
			$table[] = $tr;

			// get config information
			if( isValid($r->restrict_D_config($C))&&
				isValid($r->restrict_P_I($C))) {
				if(!isset($configs['1_2'][$C->config_a[0]])) {$configs['1_2'][$C->config_a[0]] = 0;}
				$configs['1_2'][$C->config_a[0]] ++;
			}
			if( isValid($r->restrict_D_config($C))&&
				isValid($r->restrict_DF_unique($C))) {
				if(!isset($configs['1_6'][$C->config_a[1]])) {$configs['1_6'][$C->config_a[1]] = 0;}
				$configs['1_6'][$C->config_a[1]] ++;
			}
			if( isValid($r->restrict_DFx3s($C))&&
				isValid($r->restrict_DF_unique($C))) {
				if(!isset($configs['5_6'][$C->config_a[2]])) {$configs['5_6'][$C->config_a[2]] = 0;}
				$configs['5_6'][$C->config_a[2]] ++;
			}
			if( isValid($r->restrict_DF_unique($C))&&
				isValid($r->restrict_N_consec($C))) {
				if(!isset($configs['6_7'][$C->config_a[3]])) {$configs['6_7'][$C->config_a[3]] = 0;}
				$configs['6_7'][$C->config_a[3]] ++;
			}
			if( isValid($r->restrict_DF1_5($C))&&
				isValid($r->restrict_DF6_0s($C))&&
				isValid($r->restrict_DF_unique($C))&&
				isValid($r->restrict_Ns_ta($C))) {
				if(!isset($configs['3_4_6_8'][$C->config_a[4]])) {$configs['3_4_6_8'][$C->config_a[4]] = 0;}
				$configs['3_4_6_8'][$C->config_a[4]] ++;
			}
		}

			$tr = '';
			$tr .= "\n\r<tr style='background: #cbb;'>";
			$tr .= "\n\r\t<td>Total<br>Errors</td>";
			foreach ($errors as $key => $error) {
				$tr .= "\n\r\t<td>$error</td>";
			}
			$tr .= "\n\r</tr>";
			$table[] = $tr;
		//$table = array_reverse($table);
		foreach ($table as $k => $tr) {
			echo $tr;
		}
	?>
</table>
<h2>Total Test Passing: <?php 
	$totalPassed = 0;
	foreach ($pass as $key => $value) {
		if($value) {$totalPassed++;}
	}
	echo $totalPassed;
 ?></h2>
<hr/>
<?php 
	$total = 0;

	if(count($configs['1_2']) > $total) $total = count($configs['1_2']);
	if(count($configs['1_6']) > $total) $total = count($configs['1_6']);
	if(count($configs['5_6']) > $total) $total = count($configs['5_6']);
	if(count($configs['6_7']) > $total) $total = count($configs['6_7']);
	if(count($configs['3_4_6_8']) > $total) $total = count($configs['3_4_6_8']);

	//d($total);
	/*d(count($configs['1_2']));
	d(count($configs['1_6']));
	d(count($configs['5_6']));
	d(count($configs['6_7']));
	d(count($configs['3_4_6_8']));
	d($configs); */
	$configs2 = array();
?>
<table>
	<tr>
		<th>1-2</th> <th>1-6</th> <th>5-6</th> <th>6-7</th> <th>3-4-6-8</th>
	</tr>
	<?php 
	foreach ($configs as $j => $con) {
		$newArr = array();
		foreach ($con as $key => $value) {
			$configs2[$j][] = array($key, $value);
		}		
		sort($configs2[$j]);
	}
	//d($configs2);
		for ($i=0; $i < $total; $i++) { 
			echo "<tr>";
			if(isset($configs2['1_2'][$i])) {
				echo "<td>".$configs2['1_2'][$i][0]." = ".$configs2['1_2'][$i][1]."</td>";
			} else {
				echo "<td>&nbsp;</td>";
			}
			if(isset($configs2['1_6'][$i])) {
				echo "<td>".$configs2['1_6'][$i][0]." = ".$configs2['1_6'][$i][1]."</td>";
			} else {
				echo "<td>&nbsp;</td>";
			}
			if(isset($configs2['5_6'][$i])) {
				echo "<td>".$configs2['5_6'][$i][0]." = ".$configs2['5_6'][$i][1]."</td>";
			} else {
				echo "<td>&nbsp;</td>";
			}
			if(isset($configs2['6_7'][$i])) {
				echo "<td>".$configs2['6_7'][$i][0]." = ".$configs2['6_7'][$i][1]."</td>";
			} else {
				echo "<td>&nbsp;</td>";
			}
			if(isset($configs2['3_4_6_8'][$i])) {
				echo "<td>".$configs2['3_4_6_8'][$i][0]." = ".$configs2['3_4_6_8'][$i][1]."</td>";
			} else {
				echo "<td>&nbsp;</td>";
			}
			echo "</tr>";
		}
	 ?>
</table>
</body>
</html>