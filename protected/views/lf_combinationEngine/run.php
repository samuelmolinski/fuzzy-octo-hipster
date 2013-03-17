<?php
/* @var $this CombinationEngineController */
	$t = $performance->timers['Over All']['total'];
	$time = $performance->print_time($t);

	echo "<h2>Results for $numOfCombinations combinations</h2>";
	echo "<h3>$numberOfWinningCombinations previons winning combinations</h3>";
	echo "<h3>Total tested numbers: $totalTested</h3>";
	echo "<h3>Total time: $time</h3>";
	if($saved){
		echo "<h3>Saved</h3>";
	} else {
		echo "<h3>Not Saved</h3>";
	}
	
	$count = 0;
?>
<div class="portlet-content">
    
	<table class="table table-striped">
		<caption><strong>Betting Combinations</strong></caption>
		<thead>
			<tr>
				<th>#</th>
				<th>Combinations</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach ($cg->currentBettingCombinations as $k => $c) {
					$count++;
					echo "<tr><td>$count</td><td>".$c->print_id()."</td></tr>";
				}
			?>
		</tbody>
	</table>
</div>

<?php 
	/*echo "<h3>Group Totals</h3>\n\r";
	echo "<ul>";
	for ($i=0; $i < 5; $i++) { 
		$gn = $i +1;
		echo "<li>Group $gn - {$sorted[$i]}</li>";
	}
	echo "</ul>";*/
	if(isset($save_error)){d($save_error);}
	
?>