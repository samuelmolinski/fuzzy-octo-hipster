<?php
	ini_set('memory_limit', '512M');
	set_time_limit(0);
	
	require_once('../../m_toolbox/m_toolbox.php');
	include("../CombinationStatistics.php");
	include("../CombinationGenerator.php");

	$C1445 = new CombinationStatistics('051932414958');
	$C1444 = new CombinationStatistics('020527284855');
	$C1443 = new CombinationStatistics('122032485254');

	$C1437 = new CombinationStatistics('222326373848');
	$C1436 = new CombinationStatistics('011323243057');
	$C1435 = new CombinationStatistics('041545475052');
	$C1434 = new CombinationStatistics('031822345558');

	$CL = new CombinationList(array($C1444,$C1445));
	$CG = new CombinationGenerator(array('winningCombinations'=>$CL));

	$CL2 = new CombinationList(array($C1434,$C1435));
	$CG2 = new CombinationGenerator(array('winningCombinations'=>$CL2));

	d($C1445);
	d($C1444);
	/*d($C1437);
	d($C1436);
	d($C1435);*/

	//d($CG);
	d($CG2);