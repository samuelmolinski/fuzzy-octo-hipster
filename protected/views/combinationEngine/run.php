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
	
	/*$t = array (	array ('rule_2_2_2','c'),
							array ('rule_2_2_1b','c'),
							array ('rule_2_2_1a','c'),
							array ('rule_2_2_1c','c'),
							array ('rule_1a1','c',),
							array ('rule_2_1a','c','list'),
							array ('rule_1a2','c'),
							array ('rule_1a8','c'),
							array ('rule_1a6','c'),
							array ('rule_1a5','c'),
							array ('rule_2_2_1d','c'),
							array ('rule_1a7','c'),
							array ('rule_2_1c','c'),
							array ('rule_2_2_1e','c'),
							array ('rule_1a3','c'),
							array ('rule_1a4','c'),
							array ('rule_1b3','c','list'),
							array ('rule_2_1b','c'),
							array ('rule_1b2','c','list'),
							array ('rule_1b1','c','list'),
							array ('rule_2_1_2a','c'),
							array ('rule_2_1_2b','c'),
							array ('rule_2_1_2c','c'),
							array ('rule_2_1_2d','c'),
						);*/
	//a:24:{i:0;a:2:{i:0;s:10:"rule_2_2_2";i:1;s:1:"c";}i:1;a:2:{i:0;s:11:"rule_2_2_1b";i:1;s:1:"c";}i:2;a:2:{i:0;s:11:"rule_2_2_1a";i:1;s:1:"c";}i:3;a:2:{i:0;s:11:"rule_2_2_1c";i:1;s:1:"c";}i:4;a:2:{i:0;s:8:"rule_1a1";i:1;s:1:"c";}i:5;a:3:{i:0;s:9:"rule_2_1a";i:1;s:1:"c";i:2;s:4:"list";}i:6;a:2:{i:0;s:8:"rule_1a2";i:1;s:1:"c";}i:7;a:2:{i:0;s:8:"rule_1a8";i:1;s:1:"c";}i:8;a:2:{i:0;s:8:"rule_1a6";i:1;s:1:"c";}i:9;a:2:{i:0;s:8:"rule_1a5";i:1;s:1:"c";}i:10;a:2:{i:0;s:11:"rule_2_2_1d";i:1;s:1:"c";}i:11;a:2:{i:0;s:8:"rule_1a7";i:1;s:1:"c";}i:12;a:2:{i:0;s:9:"rule_2_1c";i:1;s:1:"c";}i:13;a:2:{i:0;s:11:"rule_2_2_1e";i:1;s:1:"c";}i:14;a:2:{i:0;s:8:"rule_1a3";i:1;s:1:"c";}i:15;a:2:{i:0;s:8:"rule_1a4";i:1;s:1:"c";}i:16;a:3:{i:0;s:8:"rule_1b3";i:1;s:1:"c";i:2;s:4:"list";}i:17;a:2:{i:0;s:9:"rule_2_1b";i:1;s:1:"c";}i:18;a:3:{i:0;s:8:"rule_1b2";i:1;s:1:"c";i:2;s:4:"list";}i:19;a:3:{i:0;s:8:"rule_1b1";i:1;s:1:"c";i:2;s:4:"list";}i:20;a:2:{i:0;s:11:"rule_2_1_2a";i:1;s:1:"c";}i:21;a:2:{i:0;s:11:"rule_2_1_2b";i:1;s:1:"c";}i:22;a:2:{i:0;s:11:"rule_2_1_2c";i:1;s:1:"c";}i:23;a:2:{i:0;s:11:"rule_2_1_2d";i:1;s:1:"c";}}
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

<?php d($cg); ?>