<?php
	
	set_time_limit(0);

	if (!defined('ABSPATH')) {
		define('ABSPATH', dirname(__FILE__) . '/');
	}
	
	if (!defined('TESTPATH')) {
		define('TESTPATH', dirname(__FILE__) . '/_unitTesting/');
	}

	//required files
	require_once ('../m_toolbox/m_toolbox.php');
	require_once (TESTPATH .'AllTests.php');

	start();

	function start() {
		$test = new AllTests();	
		
        //$test->addFile(TESTPATH .'CombinationGeneratorTest.php');
        $test->addFile(TESTPATH .'CombinationTest.php');
        $test->addFile(TESTPATH .'NumberTest.php');
	}

?>