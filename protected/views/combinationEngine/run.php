<?php
/* @var $this CombinationEngineController */
	$t = $performance->timers['Over All']['total'];
	$time = $performance->print_time($t);

	echo "<h2>Results for $numOfCombinations combinations</h2>";
	echo "<h3>$numberOfWinningCombinations previons winning combinations</h3>";
	echo "<h3>Total tested numbers: $totalTested</h3>";
	echo "<h3>Total time: $time</h3>";


	d(json_encode($cg->rule_1a1_ranges));
	d(json_encode($cg->groups_2_2));
	d(json_encode($tests));
	d(json_encode($cg->permited_1a8));

	echo "<ol>";
	foreach ($cg->currentBettingCombinations as $k => $c) {
		echo "<li>".$c->print_id()."</li>";
	}
	echo "</ol>";

