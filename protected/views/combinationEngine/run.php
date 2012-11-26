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
	


	d(serialize($cg->rule_1a1_ranges));
	d(serialize($cg->groups_2_2));
	d(serialize($tests));
	d(serialize($cg->permited_1a8));
	/*echo "<ol>";
	foreach ($cg->currentBettingCombinations as $k => $c) {
		echo "<li>".$c->print_id()."</li>";
	}
	echo "</ol>";*/

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