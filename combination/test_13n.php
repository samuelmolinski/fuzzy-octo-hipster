<?php 
	require('Seed_LF.php');
	require('LF_Restrictions.php');
	set_time_limit(0);
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<title>Lotto Facil</title>
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
		.error1 .pass{
			display: none;
		}
		.fail{
			display: none;
		}
		.error1 .fail{
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
	global $errors;
	$errors = array();

	function hasError($key, $passed, $p2 = true, $p3 = true, $p4 = true) {

		global $errors;
		if(!isset($errors[$key])) {$errors[$key] = 0;}
	

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
		<th>Test</th><th>Values</th><th>X N = a</th>
	</tr>
	<?php 
		$wNc = count($test->wC);
		$table = array();
		$limit = 150;
		$limit = $wNc-10;
		//d($r->N_X_equal($test->wC[25]));
		for ($i=0; $i < $wNc; $i++) { 
			$id = $wNc-$i;
			$C = $test->wC[$id];
		//}
		//foreach ($test->wC as $id => $C) {

			$tr = '';
			$tr .= "\n\r<tr>";
			$tr .= "\n\r\t<td>$id</td>";
			$tr .= "\n\r\t<td id='printID' >".$C->printHTML_id()."</td>";
			$tr .= "\n\r\t<td>".$r->N_X_equal($C, $id)."</td>";
			$tr .= "\n\r</tr>";
			$table[] = $tr;
		}
			

		$tr .= "\n\r<tr style='background: #cbb;'>";
		$tr .= "\n\r\t<td>Total<br>Errors</td>";
		$tr .= "\n\r\t<td></td>";
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
</body>
</html>