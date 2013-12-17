<?php 
	
	require_once("CombinationStatistics.php");
	require_once("CombinationList.php");
	//require_once("Number.php");

	class CombinationGenerator {
		/*
		Mega system
		The system is based in 4 types of restrictions: those related to the arrangement of Ns, pairs of cRd-cRf, cRd and cRf.
		There are 35 itens of restrictions distributed by the 4 types. 
		*/

		public $CL; 									/* required */
		public $wCombs; 								// intended to be an array of all previous winning combinations
		public $currentBettingCombinations;  			/* required */
		public $restrictionsToBeChecked;				/* required */
		public $threshold = 1;							/* required */

		public $N1_possibilities = array(				/* required */
			'n1_10'=>0,
			'n11_20'=>0,
			'n21_30'=>0,
			'total'=>0
		);

		public $stats = array();
		public $permited_cRd_cRf = array();
		public $lastOccuranceOf = array('cRd'=>array(), 'cRf'=>array());
		public $previousTest_60Nconfig;
		public $previous_60N = array();
		public $previous_18N = array();
		public $testPassed = array();
		public $testFailed = array();

		public $restrict_N_ranges = array(
			array('min'=>1,'max'=>25),
			array('min'=>2,'max'=>35),
			array('min'=>6,'max'=>45),
			array('min'=>18,'max'=>54),
			array('min'=>25,'max'=>59),
			array('min'=>38,'max'=>60)
		);

		public $total_N_limit = 0;
		public $total_N_values = array();

		/* old  variables */

		public $permited_1a8;
		public $limit_2_1c;
		public $groups_2_1_2;
		public $configuration_2_1_2;
		public $groups_2_2;
		public $rule_2_2_1a_invalid; // -1 if we do not use it, 0-4 to indicate which group to exclude
		public $rule_2_2_1b_invalid; // Boolean
		public $rule_2_2_1c_invalid; // Boolean
		public $rule_2_2_1d_invalid; // 0 if we do not use it
		public $listRule_2_2_1e;
		public $rule_2_2_2_invalid;
		public $rule_2_2_2_limit;
		public $rule_2_2_2_total;
		public $rule_2_1b_subList;
		public $last_cDf_21111;
		public $last_cRf_21111;

		public function CombinationGenerator($previousTest_CL = null) {

			if($previousTest_CL != null){
				$this->wCombs = array_reverse($previousTest_CL->toCombinations());

				if(count($this->wCombs) > 10){
					$previous_18N = array();
					for ($j=0; $j < 10; $j++) { 				
						for ($i=0; $i < 6; $i++) { 
							if(!isset($this->previous_60N[$this->wCombs[$j]->d[$i]->n])){
								$this->previous_60N[$this->wCombs[$j]->d[$i]->n] = 0;
							} 
							$this->previous_60N[$this->wCombs[$j]->d[$i]->n]++;			
						}
					}
					for ($j=0; $j < 3; $j++) { 				
						for ($i=0; $i < 6; $i++) { 
							if(!isset($this->previous_18N[$this->wCombs[$j]->d[$i]->n])){
								$this->previous_18N[$this->wCombs[$j]->d[$i]->n] = 0;
							} 
							$this->previous_18N[$this->wCombs[$j]->d[$i]->n]++;			
						}
					}
					$p = array();
					for ($j=1; $j < 11; $j++) { 				
						for ($i=0; $i < 6; $i++) { 
							if(!isset($p[$this->wCombs[$j]->d[$i]->n])) {
								$p[$this->wCombs[$j]->d[$i]->n] = 0;
							} 
							$p[$this->wCombs[$j]->d[$i]->n]++;			
						}
					}
					ksort($this->previous_60N);
					ksort($p);

					$this->previousTest_60Nconfig = $this->previous_xN_config($this->wCombs[0], $p);
				}

				// lets get the last occurance of ...
				foreach($this->wCombs as $k=> $c) {
					// cRd
					if (($c->cRd == 222)&&(!isset($this->lastOccuranceOf['cRd'][222]))) {
						$this->lastOccuranceOf['cRd'][222] = $c;
					}
					if (($c->cRd == 2211)&&(!isset($this->lastOccuranceOf['cRd'][2211]))) {
						$this->lastOccuranceOf['cRd'][2211] = $c;
					}
					if (($c->cRd == 411)&&(!isset($this->lastOccuranceOf['cRd'][411]))) {
						$this->lastOccuranceOf['cRd'][411] = $c;
					}
					if (($c->cRd == 321)&&(!isset($this->lastOccuranceOf['cRd'][321]))) {
						$this->lastOccuranceOf['cRd'][321] = $c;
					}
					if (($c->cRd == 3111)&&(!isset($this->lastOccuranceOf['cRd'][3111]))) {
						$this->lastOccuranceOf['cRd'][3111] = $c;
					}

					// cRf
					if (($c->cRf == 2211)&&(!isset($this->lastOccuranceOf['cRf'][2211]))) {
						$this->lastOccuranceOf['cRf'][2211] = $c;
					}
					if (($c->cRf == 111111)&&(!isset($this->lastOccuranceOf['cRf'][111111]))) {
						$this->lastOccuranceOf['cRf'][111111] = $c;
					}
					if (($c->cRf == 3111)&&(!isset($this->lastOccuranceOf['cRf'][3111]))) {
						$this->lastOccuranceOf['cRf'][3111] = $c;
					}
					if (($c->cRf == 21111)&&(!isset($this->lastOccuranceOf['cRf'][21111]))) {
						$this->lastOccuranceOf['cRf'][21111] = $c;
					}
				}
			}
			
			//echo Yii::trace(CVarDumper::dumpAsString($this->wCombs),'$previousTest_CL->toCombinations()');

			$this->CL = new CombinationList;
			$this->currentBettingCombinations = array();
			mt_srand($this->make_seed());

			$this->restrictionsToBeChekced = array ( 
				array ('restrict_N_A1',			1.0, ), 
				array ('restrict_N_B1',			1.0, ), 
				//array ('restrict_N_B2',			1.0, ), 
				array ('restrict_N_C1',			1.0, ), 
				array ('restrict_N_C2a',		1.0, ), 
				array ('restrict_N_C2b',		0.4, ), 
				array ('restrict_N_C3a',		0.4, ), 
				array ('restrict_N_C3b',		0.4, ), 
				array ('restrict_N_C3c',		1.0, ), 
				array ('restrict_N_D1',			1.0, ), 
				array ('restrict_N_D2',			0.4, ), 
				array ('restrict_N_D3a',		0.4, ), 
				array ('restrict_N_D3b',		0.4, ), 
				array ('restrict_N_D4',			0.4, ), 
				array ('restrict_N_E1',			0.4, ), 
				array ('restrict_N_E2',			0.4, ), 
				array ('restrict_N_F1',			0.4, ), 
				array ('restrict_N_F2',			1.0, ), 
				array ('restrict_N_F3',			1.0, ), 
				array ('restrict_N_H1',			0.4, ), 
				array ('restrict_N_H2a',		0.4, ), 
				array ('restrict_N_H2b',		0.4, ), 
				array ('restrict_N_I1',			1.0, ), 
				//array ('restrict_N_J1',			0.4, ), 
				array ('restrict_N_J2',			1.0, ), 
				array ('restrict_N_J3',			0.4, ), 
				array ('restrict_N_J4',			0.4, ), 
				array ('restrict_N_J5a',			0.4, ), 
				array ('restrict_N_J5b',			1.0, ), 
				array ('restrict_N_J5c',			1.0, ), 
				array ('restrict_N_J5d',			1.0, ), 
				array ('restrict_N_K1',			1.0, ), 
				array ('restrict_N_K2',			0.4, ), 
				array ('restrict_cRd_cRf_A1',	1.0, ), 
				array ('restrict_cRd_cRf_C1',	0.4, ), 
				array ('restrict_cRd_A1',		1.0, ), 
				array ('restrict_cRd_B1',		1.0, ), 
				array ('restrict_cRd_B2',		0.4, ), 
				array ('restrict_cRf_A1',		0.4, ), 
				array ('restrict_cRf_B1',		0.4, ), 
				array ('restrict_cRf_B2',		0.4, )
			);
	
			$this->stats = array(
				"totalTested" => 0,
				"p" => new Performance()
			);

			//$this->permited_cRd_cRf = Yii::app()->params['cRd_cRf_groups'];
			
			foreach (Yii::app()->params['cRd_cRf_groups'] as $arr => $cRd_cRf_group) {
				foreach ($cRd_cRf_group as $arr => $cRd_cRf) {
					$this->permited_cRd_cRf[] = $cRd_cRf;
				}
			}
			Yii::trace(CVarDumper::dumpAsString($this->permited_cRd_cRf), '$this->permited_cRd_cRf');

			/*$this->permited_cRd_cRf = array(
				'2211-21111','21111-21111','3111-21111',
				'321-21111','222-21111','111111-21111',
				'321-2211','3111-2211','2211-2211',
				'21111-2211','321-111111','3111-111111',
				'2211-111111','21111-111111','2211-3111','21111-3111'
			);*/
		
			for ($i=1; $i <= 60; $i++) { 
				$this->total_N_values[$i] = 0;
			}
		}

		// Replaces parts of the CombinationEngineController->actionRun() to remove engine logic to this class
		public function generateCombinations($previousTest_CL, $numOfCombinations = 100){
			set_time_limit(0);

			$this->total_N_limit = $numOfCombinations * .11;
			Yii::trace(CVarDumper::dumpAsString($this->total_N_limit),'$this->total_N_limit');

			// convert $previousTest_CL => wCombs[]
	    	
	    	$numberOfWinningCombinations = count($this->wCombs);

			//starting the process
			
			$fail = 0;
			$count = 0;
			$comb = array();
			$this->testPassed = array();
			$this->testFailed = array();

			// the actual generation loop
			$this->stats["p"]->start_timer("Over All");
			do {
				do {
					$list = array();
					/*for ($i=0; $i < 6; $i++) { 
						$comb[$i] = $this->genUniqueRand($list);
						$list[] = $comb[$i]->n;
					}*/
					$c = $this->restrict_N_A1(array(), true);
					//$c = new CombinationStatistics($comb);
					//d($c);				//d($c->group2_2); 
					
				} while (in_array($c, $this->currentBettingCombinations));

				$count++;
				$numTestsFailed = 0;
				$this->stats["p"]->start_timer("Average restriction test time");
				foreach ($this->restrictionsToBeChekced as $restriction) {
					$currentFunction = $restriction[0];
					if(empty($this->testPassed[$currentFunction])) {
						$this->testPassed[$currentFunction] = 0;
					}
					if(empty($this->testFailed[$currentFunction])) {
						$this->testFailed[$currentFunction] = 0;
					}
					if(2 < count($restriction)) {
						$this->stats["p"]->start_timer("$currentFunction");
						$r = $this->$currentFunction($c, $cg->wCombs);
						$this->stats["p"]->plus_end_timer("$currentFunction");
					} else {
						$this->stats["p"]->start_timer("$currentFunction");
						$r = $this->$currentFunction($c);	
						$this->stats["p"]->plus_end_timer("$currentFunction");
					}
					if(!$r){
						$numTestsFailed += $restriction[1];
						$this->testFailed[$currentFunction]++;

						if($this->testFailed[$currentFunction] >30000){
							//continue;
						}

						if($currentFunction == 'restrict_N_B2'){
							//Yii::trace(CVarDumper::dumpAsString($numTestsFailed),'$numTestsFailed');
							//Yii::trace(CVarDumper::dumpAsString(($numTestsFailed >= $this->threshold)),'($numTestsFailed >= $this->threshold)');
						}
						
						if($numTestsFailed >= $this->threshold) {
							$fail++;
							$this->stats["p"]->plus_end_timer("Average restriction test time");
							continue 2;
						}
					} else {
						//Debugging:for endless loops test purposes
						$this->testPassed[$currentFunction]++;
					}
					//Debugging:for endless loops test purposes
					if($count > 10000){
						//break;
					}
				}
				$this->stats["p"]->plus_end_timer("Average restriction test time");

				// Post approval processes

				$this->addBettingCombination($c);

			} while ($numOfCombinations > count($this->currentBettingCombinations));
			$this->stats["p"]->end_timer("Over All");
			$this->stats["p"]->sortByTotalTime();

			$this->stats["totalTested"] = $count;


			sort($this->currentBettingCombinations);
			
			//echo Yii::trace(CVarDumper::dumpAsString($testFailed),'$testFailed[$currentFunction]');

			$this->CL = new CombinationList($this->currentBettingCombinations);

		}

		// Utility functions 

		public function addBettingCombination($C) {

			if($C->d[0]->n < 11){ $this->N1_possibilities['n1_10']++;}
			if(($C->d[0]->n >= 11) && ($C->d[0]->n <21)){ $this->N1_possibilities['n11_20']++;}
			if($C->d[0]->n >= 21){$this->N1_possibilities['n21_30']++;}

			foreach ($C->d as $k => $N) {
				$this->total_N_values[(int)$N->n]++;
			}

			$this->N1_possibilities['total']++;

			/*if(($this->rule_2_2_2_invalid == $C->group2_2)) {
				$this->rule_2_2_2_total++;
			}*/
			$this->currentBettingCombinations[] = $C;
		}


		/**
		 * genUniqueRand() creates random numbers
		 **/
		public function genUniqueRand($omittedNumberList, $min = 1, $max = 60) {

			$N = new Number(mt_rand($min, $max));

			while (in_array($N->n, $omittedNumberList)) {
				unset($N);
				$N = new Number(mt_rand($min, $max));
			}
			return $N;
		}

		/**
		 * make_seed() primes the random number generator
		 **/
		public function make_seed() {
			list($usec, $sec) = explode(' ', microtime());
  			return (float) $sec + ((float) $usec * 100000);
		}

		public function previous_60N_config($C){
			$config = array();
			//print_r($this->rule_2_1c_prev_3n_in_last_10);
			foreach ($C->d as $d => $N) {
				if(isset($this->previous_60N[$N->n])) {
					$config[] = $this->previous_60N[$N->n];
				} else {
					$config[] = 0;
				}
			}
			return $config;
		}	

		/**
		 * [numElementsEqual description] Returns the number of N matching form the two combinations
		 * provided
		 * @param  CombinationStatistics $c1
		 * @param  CombinationStatistics $c2
		 * @return int - number of N matching
		 */
		public function numElementsEqual($c1, $c2) {
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

		/**
		 * [getTensConfig description]
		 * @param  CombinationStatistics $C 
		 * @return array  - array with the keys representing the tens place 
		 * and the value giving the number of occurences for a given Combination
		 */
		public function getTensConfig($C){
			$D1 = array();
			foreach ($C->d as $k => $N) {
				if(!isset($D1[$N->D])){$D1[$N->D]=0;}
				$D1[$N->D]++;
			}
			return $D1;
		}

		/**
		 * [getTensConfigN description] Gives the getTensConfig() but with the actual N obj
		 * @param  CombinationStatistics $C
		 * @return array  - array with the keys representing the tens place 
		 * and the value giving an array of Number objects
		 */
		public function getTensConfigN($C){
			$D = array();			
			foreach ($C->d as $k => $N) {
				if(!isset($D[$N->D])){$D1[$N->D] = array();}
				$D[$N->D][] = $N;
			}
			return $D;
		}

		/**
		 * [previous_xN_config description]
		 * @param  CombinationStatistics $C 
		 * @param  array() $previousNs - keys are the N with the value equal to the number of 
		 * occurences of each N, generally in the last 10 test
		 * @return array() - [0] N that didn't occure in the prior list, [1] N that occured 1 time
		 * in the prior list, [2] N that occured 2 or more times in the prior list
		 */
		public function previous_xN_config($C, $previousNs){			
			$xyz = array(0,0,0);
			foreach ($C->d as $k => $N) {
				if(isset($previousNs[$N->n])){
					if($previousNs[$N->n] > 1){
						$xyz[0]++;
					} elseif($previousNs[$N->n] == 1) {	
						$xyz[1]++;
					}
				} else {
					$xyz[2]++;
				}
			}
			return $xyz;
		}

		/////////////////////////////////////////////////////
		////////	Restrictions Below
		/////////////////////////////////////////////////////

		/*******************************************************************************
		 * 
		 * Description: Restriction for N 
		 * Restriction prefix: restrict_N_
		 * 
		 *******************************************************************************/

		/**
		 * [restrict_N_A1 description] generates the combination based on the intervals for each N
		 * @param  array   $C
		 * @param  boolean $generating
		 * @return boolean if used as a restriction or
		 * @return CombinationStatistics 
		 */
		public function restrict_N_A1($C = array(), $generating = false) {
			//1º N- 01 a 30; 2º N- 02 a 40; 3º N- 04 a 49; 4º N- 11 a 55; 5º N- 18 a 59; 6º N- 31 a 60;
			$list = array();
			$ranges = $this->restrict_N_ranges;
			//pre existing combination does this with recursion
			if (!empty($C) && $generating) {
				sort($C->d);

				foreach ($C->d as $key => $value) {
					$list[] = $value->n;
				}

				//checking ranges
				foreach ($C->d as $k => $Num) {
					$t = $Num->n;
					if (!(($ranges[$k]['min']<=$t)&&($ranges[$k]['max']>=$t))) {
						$C->d[$k] = $this->genUniqueRand($list, 1, 60);
						$list[$k] = $C->d[$k]->n;
						sort($C->d);
						//sort($list);
						//print_r($list);
						$C = $this->rule_1a1($C, $list, true);
						break;
					}
				}
				
				return $C;
			} elseif ($generating) {

				//if its for generation initial value
				for ($i=0; $i < 6; $i++) {
					$comb[$i] = $this->genUniqueRand($list, $this->restrict_N_ranges[$i]['min'], $this->restrict_N_ranges[$i]['max']);
					$list[] = $comb[$i]->n;
				}
				//must return a CombinationStatistics
				return new CombinationStatistics($comb);
			} else {
				//not generating, just checking if the value passes or fails
				//checking ranges
				foreach ($C->d as $k => $Num) {
					$t = $Num->n;
					if (!(($ranges[$k]['min']<=$t)&&($ranges[$k]['max']>=$t))) {
						return false;
					}
				}
			}

			return true;
		}
		
		/**
		 * [restrict_N_B1 description] checks the 1N to see if it compiles with the desired interval percentages
		 * @param  CombinationStatistics $C
		 * @return boolean 
		 */
		public function restrict_N_B1($C) {
			
			//lets keep the combinations N1 with in these ranges
			// 1-10 => 80%, 11-20 => 20%, 21-30 => 5% (of the total values possible for N1)
			//Yii::trace(CVarDumper::dumpAsString($this->N1_possibilities), '$this->N1_possibilities');
			if($this->N1_possibilities['total']>10) { // let it get some numbers first
				if($C->d[0]->n < 11){
					$num = (($this->N1_possibilities['n1_10'])/($this->N1_possibilities['total']));
					//Yii::trace(CVarDumper::dumpAsString($num), '$num n1_10');
					if($num<.80) {
						return true;
					} else {
						return false;
					}
				}
				if(($C->d[0]->n >= 11) && ($C->d[0]->n <21)){
					$num = ($this->N1_possibilities['n11_20'])/($this->N1_possibilities['total']);
					//Yii::trace(CVarDumper::dumpAsString($num), '$num n11_20');
					if($num<.20) {
						return true;
					} else {
						return false;
					}
				}
				if($C->d[0]->n >= 21){		
					$num = ($this->N1_possibilities['n21_30'])/($this->N1_possibilities['total']);
					//Yii::trace(CVarDumper::dumpAsString($num), '$num n21_30');
					if($num<.05) {
						return true;
					} else {
						return false;
					}
				}
			} else {
				return true;
			}
		}


		public function restrict_N_B2($C){
			foreach ($C->d as $k => $N) {
				if(($this->total_N_values[(int)$N->n] > $this->total_N_limit)) {
					//Yii::trace("(n=["+CVarDumper::dumpAsString((int)$N->n)+"])", '$this->total_N_values[(int)$N->n]');
					//Yii::trace("(["+CVarDumper::dumpAsString($this->total_N_values[(int)$N->n])+"])", '$this->total_N_values[(int)$N->n]');
					return false;
				}
			}
			return true;
		}

		/**
		 * [restrict_N_C1 description] all 6N in 3 consecutive tens
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_C1($C){			
			$tens = array();
			foreach ($C->d as $k => $N) {
				if(!in_array($N->D, $tens)) {
					$tens[] = $N->D;
				}
			}
			if(3 == count($tens)) {
				sort($tens);
				//d($tens);
				if(($tens[1]==$tens[0]+1)&&($tens[2]==$tens[0]+2)) {
					return FALSE;
				} else {
					return TRUE;
				}
			} else {
				return TRUE;
			}
		}

		/**
		 * [restrict_N_C2a description] 
		 * a - can not have no Ns in tens 0 (01-10) and tens 5 (51-60)
		 * b - can not have no Ns in tens 4 (41-50) and tens 5 (51-60)
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_C2a($C){
			$tens = array();
			foreach ($C->d as $N) {
				if(@$tens[$N->D]==null) {
					$tens[$N->D]=0;
				}
				$tens[$N->D]++;
			}
			// Part A
			if(empty($tens[0])&&empty($tens[5])) {
				return false;
			}
			// Part B
			if(empty($tens[4])&&empty($tens[5])) {
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_C2b description] 
		 * a - can not have no Ns in tens 0 (01-10) and tens 5 (51-60)
		 * b - can not have no Ns in tens 4 (41-50) and tens 5 (51-60)
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_C2b($C){
			$tens = array();
			foreach ($C->d as $N) {
				if(@$tens[$N->D]==null) {
					$tens[$N->D]=0;
				}
				$tens[$N->D]++;
			}
			// Part B
			if(empty($tens[4])&&empty($tens[5])) {
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_C3a description] Reject if it occurred in the last test
		 * a - 2N in the 1-3 tens place
		 * b - 4N in the 1-3 tens place
		 * c - 1N or 5N in the 1-3 tens place
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_C3a($C){
			$ft1 = 0; // N in the 1-3 tens place
			$ft2 = 0; // N in the 1-3 tens place
			foreach ($C->d as $N) {
				if($N->D <4){
					$ft1++;
				}
			}
			foreach ($this->wCombs[0]->d as $N) {
				if($N->D <4){
					$ft2++;
				}
			}
			//part a: 2N in the 1-3 tens place
			if(($ft1==2)&&($ft2==2)){
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_C3b description] Reject if it occurred in the last test
		 * a - 2N in the 1-3 tens place
		 * b - 4N in the 1-3 tens place
		 * c - 1N or 5N in the 1-3 tens place
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_C3b($C){
			$ft1 = 0; // N in the 1-3 tens place
			$ft2 = 0; // N in the 1-3 tens place
			foreach ($C->d as $N) {
				if($N->D <4){
					$ft1++;
				}
			}
			foreach ($this->wCombs[0]->d as $N) {
				if($N->D <4){
					$ft2++;
				}
			}

			//part b:  4N in the 1-3 tens place
			if(($ft1==4)&&($ft2==4)){
				return false;
			}

			return true;
		}

		/**
		 * [restrict_N_C3c description] Reject if it occurred in the last test
		 * a - 2N in the 1-3 tens place
		 * b - 4N in the 1-3 tens place
		 * c - 1N or 5N in the 1-3 tens place
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_C3c($C){
			$ft1 = 0; // N in the 1-3 tens place
			$ft2 = 0; // N in the 1-3 tens place
			foreach ($C->d as $N) {
				if($N->D <4){
					$ft1++;
				}
			}
			foreach ($this->wCombs[0]->d as $N) {
				if($N->D <4){
					$ft2++;
				}
			}

			//part c:  1N or 5N in the 1-3 tens place
			if((($ft1==1)||($ft1==5))&&(($ft2==1)||($ft2==5))) {
				return false;
			}

			return true;
		}

		/**
		 * [restrict_N_D1 description] Reject if 6N are even or odd
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_D1($C){
			$total = 0;
			$count = count($C->d); 

			foreach($C->d as $k=>$N){
				$total += $N->n % 2;
			}
			//if the N are all even the total will be 0; if the N are all odd then the total will be 6
			if((0 == $total)||($count == $total)){
				return FALSE;
			}
			return TRUE;
		}

		/**
		 * [restrict_N_D2 description] Reject if has 1N or 5N, even or odd, if it occurred in the last test
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_D2($C){
			$e1 = 0; //even num in $C
			$e2 = 0; //even num in $this->wCombs[0]
			foreach ($this->wCombs[0]->d as $N) {
				if($N->n%2 == 0){
					$e2++;
				}
			}

			if(($e2 == 1)||($e2 >= 5)) {				
				foreach ($C->d as $N) {
					if($N->n%2 == 0){
						$e1++;
					}
				}
				if(($e1 == 1)||($e1 >= 5)) {
					return false;
				}
			}
			return true;
		}

		/**
		 * [restrict_N_D3a description] Reject if has 4N odd, if it occurred in the last 2 test
		 * @param  CombinationStatistics $C
		 * @return boolean 
		 */
		public function restrict_N_D3a($C){

			$e1 = 0; //even num in $C
			$e2 = 0; //even num in $this->wCombs[0]
			$e3 = 0; //even num in $this->wCombs[0]

			foreach ($this->wCombs[0]->d as $N) {
				if($N->n%2 == 0){
					$e2++;
				}
			}

			foreach ($this->wCombs[1]->d as $N) {
				if($N->n%2 == 0){
					$e3++;
				}
			}

			if(($e2 <= 2)&&($e3 <= 2)) {				
				foreach ($C->d as $N) {
					if($N->n%2 == 0){
						$e1++;
					}
				}
				if($e1 <= 2) {
					return false;
				}
			}

			return true;
		}

		/**
		 * [restrict_N_D3b description] Reject if has 4N even, if it occurred in the last 2 test
		 * @param  CombinationStatistics $C
		 * @return boolean 
		 */
		public function restrict_N_D3b($C){

			$e1 = 0; //even num in $C
			$e2 = 0; //even num in $this->wCombs[0]
			$e3 = 0; //even num in $this->wCombs[0]

			foreach ($this->wCombs[0]->d as $N) {
				if($N->n%2 == 0){
					$e2++;
				}
			}

			foreach ($this->wCombs[1]->d as $N) {
				if($N->n%2 == 0){
					$e3++;
				}
			}

			if(($e2 >= 4)&&($e3 >= 4)) {				
				foreach ($C->d as $N) {
					if($N->n%2 == 0){
						$e1++;
					}
				}
				if($e1 >= 4) {
					return false;
				}
			}

			return true;
		}

		/**
		 * [restrict_N_D4 description] Reject if has 4N even, if it occurred in the last 2 test
		 * @param  CombinationStatistics $C
		 * @return boolean 
		 */
		public function restrict_N_D4($C){

			$e1 = 0; //even num in $C
			$e2 = 0; //even num in $this->wCombs[0]
			$e3 = 0; //even num in $this->wCombs[0]

			foreach ($this->wCombs[0]->d as $N) {
				if($N->n%2 == 0){
					$e2++;
				}
			}

			if(($e2 == 3)) {				
				foreach ($C->d as $N) {
					if($N->n%2 == 0){
						$e1++;
					}
				}
				if($e1 == 3) {
					return false;
				}
			}
			return true;
		}

		/**
		 * [restrict_N_E1 description] Reject if the smallest FD bigger than 3 or the largest FD lesser than 6
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_E1($C){
			$DFs = array();
			foreach ($C->d as $k => $N) {
				$DFs[] = $N->DF;
			}
			sort($DFs);
			if(($DFs[0] >= 3)||($DFs[5] <= 6)) {
				return FALSE;
			}
			return TRUE;
		}

		/**
		 * [restrict_N_E2 description] Rejects if all DF are consecutive
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_E2($C){
			$k = 0;
			$DFs = array();
			foreach ($C->d as $k => $N) {
				$DFs[] = $N->DF;
			}
			sort($DFs);

			$c = count($DFs);
			for ($i=0; $i < $c-1; $i++) { 
				if($DFs[$i+1]-$DFs[$i] <= 1) {
					$k++;
				}
			}
			if($k == $c) {
				return false;
			} 
			return true;
		}

		/**
		 * [restrict_N_F1 description] Reject if it contains Ndif = 1 (a triple or 2 pairs)
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_F1($C){			
			$count = count($C->d);
			$limit = 0;
			for ($i=0; $i < $count-1; $i++) { 
				if($C->d[$i]->n+1 == $C->d[$i+1]->n) { 
					$limit++;
					if($limit >= 2) {
						return FALSE;
					}
				}
			}
			return TRUE;
		}

		/**
		 * [restrict_N_F2 description] Reject combinations with three Ndif equal
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_F2($C){
			$count = count($C->d);
			$NDifs = array();
			$threeN_NDifs = array();
			for ($i=0; $i < $count-1; $i++) { 
				$diff = $C->d[$i+1]->n - $C->d[$i]->n+1;
				//$NDifs[] = $diff;
				if(@$threeN_NDifs[$diff] == null){
					$threeN_NDifs[$diff] = 0;
				}
				$threeN_NDifs[$diff]++;
			}
			//sort($NDifs);
			// part a (4b3)
			ksort($threeN_NDifs);
			foreach ($threeN_NDifs as $num_times) {
				if($num_times >=3) {
					return false;
				}
			}
			return TRUE;
		}

		/**
		 * [restrict_N_F3 description] Reject all 5 NDif larger than 6 or lesser than 6
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_F3($C) {

			$count = count($C->d);
			$NDifs = array();
			for ($i=0; $i < $count-1; $i++) { 
				$diff = $C->d[$i+1]->n - $C->d[$i]->n+1;
				$NDifs[] = $diff;
			}
			
			if($NDifs[0]> 6) {
				return false;
			}

			if($NDifs[count($NDifs)-1]< 6) {
				return false;
			}

			$freq = array_count_values($NDifs);
			foreach ($freq as $k => $NDif) {
				if($NDif>=3) {
					return FALSE;
				}
			}
			return true;
		}

		/**
		 * [restrict_N_H1 description] Reject if it has more than 1N equal to previous test
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_H1($C){
			if($this->numElementsEqual($C, $this->wCombs[0]) > 1){
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_H2 description] Reject if it has 0 or 3N equal to previous 3 test
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_H2a($C){	
			// 30-32-49-50-52-53		
			$prev = 0;
			$cur = 0;
			for ($i=0; $i < 3; $i++) { 
				$pe = $this->numElementsEqual($this->wCombs[0], $this->wCombs[$i+1]);
				$ce = $this->numElementsEqual($C, $this->wCombs[$i]);

				if(($pe == 0)||($pe == 3)) {
					$prev++;
				}
				if(($ce == 0)||($ce == 3)) {
					$cur++;
				}
			}
			if(($prev == 3)&&($cur == 3)) {
				return false;
			}
			return true;
		}

		/**
		 * [Restrict_N_H2b description] Reject if 2N equal to previous 3 test
		 * @param CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_H2b($C){	
			$prev = 0;
			$cur = 0;
			for ($i=0; $i < 3; $i++) { 
				$pe = $this->numElementsEqual($this->wCombs[0], $this->wCombs[$i+1]);
				$ce = $this->numElementsEqual($C, $this->wCombs[$i]);
				if($pe == 2) {
					$prev++;
				} 
				if($ce == 2) {
					$cur++;
				}
			}

			if(($prev==3)&&($cur==3)){
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_I1 description] Reject if 4N occured in the earlier 3 tests
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_I1($C){
			$count = 0;
			foreach ($C->d as $k => $N) {
				if(array_key_exists($N->n, $this->previous_18N)){
					$count++;
				}
			}			
			if($count > 3){
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_J1 description] Reject if more than 1N already given 3 or more times 
		 * in the previous 10 tests
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_J1($C){
			$config = $this->previous_60N_config($C);
			$count = 0;
			foreach ($config as $k => $c) {
				if($c > 2) {
					$count++;
				}
			}
			if($count > 3) {
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_J2 description] Reject if more than 3N in the last 10 test with 2 or more times
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_J2($C){
			$config = $this->previous_60N_config($C);
			$count = 0;
			foreach ($config as $k => $c) {
				if($c >= 2) {
					$count++;
				}
			}
			if($count > 3) {
				return false;
			}
			return true;

		}

		/**
		 * [restrict_N_J3 description] Reject if more than 3N in the last 10 test with 1 time
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_J3($C){
			$config = $this->previous_60N_config($C);
			$count = 0;
			foreach ($config as $k => $c) {
				if($c == 1) {
					$count++;
				}
			}
			if(($count == 0 )||($count > 3)) {
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_J4 description] Reject if more than 4N in the last 10 test with 0 time
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */	
		public function restrict_N_J4($C){
			$config = $this->previous_60N_config($C);
			$count = 0;
			foreach ($config as $k => $c) {
				if($c == 0) {
					$count++;
				}
			}
			if(($count == 0 )||($count > 4)) {
				return false;
			}
			return true;
		}

		/**
		 * [restrict_N_J5a description] Rejected if $C has the same previous 60N config as the last test
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_J5a($C){
			$xyz = $this->previous_xN_config($C, $this->previous_60N);
			$p_xyz = $this->previousTest_60Nconfig;

			if(($xyz[0] == $p_xyz[0])&&($xyz[1] == $p_xyz[1])&&($xyz[2] == $p_xyz[2])) {return false;}

			return true;
		}


		/**
		 * [restrict_N_J5b description]
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_J5b($C){
			$xyz = $this->previous_xN_config($C, $this->previous_60N);	

			// If any of the previous values where X = 3  or Y = 4 or Z = 4 we do not allow them now
			if (($this->previousTest_60Nconfig[0] == 3)&&($xyz[0] == 3)){return false;}

			return true;
		}


		/**
		 * [restrict_N_J5c description]
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_J5c($C){
			$xyz = $this->previous_xN_config($C, $this->previous_60N);	
			// If any of the previous values where X = 3  or Y = 4 or Z = 4 we do not allow them now
			if (($this->previousTest_60Nconfig[1] == 4)&&($xyz[1] == 4)){return false;}

			return true;
		}


		/**
		 * [restrict_N_J5d description]
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_N_J5d($C){
			$xyz = $this->previous_xN_config($C, $this->previous_60N);	
			// If any of the previous values where X = 3  or Y = 4 or Z = 4 we do not allow them now
			if (($this->previousTest_60Nconfig[2] == 4)&&($xyz[2] == 4)){return false;}

			return true;
		}

		/**
		 * [restrict_N_K1 description]
		 * @param  CombinationStatistics  $C
		 * @param  array  $list
		 * @param  integer $threshold
		 * @return boolean
		 */
		public function restrict_N_K1($C, $list = null, $threshold = 5){
			if($list == null) {
				$list = $this->wCombs;
			}
			foreach ($list as $j => $value) {
				if($this->numElementsEqual($C, $value) >= $threshold) {
					return FALSE;
				}
			}
			return TRUE;
		}

		/**
		 * [restrict_N_K2 description]
		 * @param  CombinationStatistics  $C
		 * @param  array  $list
		 * @param  integer $threshold
		 * @return boolean
		 */
		public function restrict_N_K2($C, $list = null, $threshold = 4){
			if($list == null) {
				$list = $this->wCombs;
			}
			foreach ($list as $j => $value) {
				if(($this->numElementsEqual($C, $value) >= $threshold)&&($C->cRd_cRf==$value->cRd_cRf)) {
					return FALSE;
				}
			}
			return TRUE;
		}

		
		/*******************************************************************************
		 * 
		 * Description: Restriction for pairs of cRd-cRf
		 * Restriction prefix: restrict_cRd_cRf
		 * 
		 *******************************************************************************/

		/**
		 * [restrict_cRd_cRf_A1 description] Reject is part of the 48 pairs of non-playable cRd-cRf
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_cRd_cRf_A1($C){
			if(in_array($C->cRd_cRf, $this->permited_cRd_cRf)) {
				return TRUE;
			}
			return FALSE;
		}

		/**
		 * [restrict_cRd_cRf_C1 description] Reject if the previous test was 2211-2111 or 21111-21111
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_cRd_cRf_C1($C){
			if(($this->wCombs[0]->cRd_cRf == '21111-111111') && ($C->cRd_cRf == $this->wCombs[0]->cRd_cRf) && ($C->cDf == $this->wCombs[0]->cDf)) {
				return false;
			}

			if( (($this->wCombs[0]->cRf == '2211')||($this->wCombs[0]->cRf == '111111')||($this->wCombs[0]->cRf == '3111')) && ($C->cRf == $this->wCombs[0]->cRf) && ($C->cDf == $this->wCombs[0]->cDf)) {
				return false;
			}
			return TRUE;
		}

		
		/*******************************************************************************
		 * 
		 * Description: Restriction for cRd
		 * Restriction prefix: restrict_cRd
		 * 
		 *******************************************************************************/

		/**
		 * [restrict_cRd_A1 description] if it occurred in the last tests
		 * @param  CombinationStatistics $C
		 * @return boolean 
		 */
		public function restrict_cRd_A1($C){

			if(('321' == $this->wCombs[0]->cRd)&&('321' == $C->cRd)){
				return false;
			}
			if(('3111' == $this->wCombs[0]->cRd)&&('3111' == $C->cRd)){
				return false;
			}
			$arr = array('222','111111');
			if((in_array($this->wCombs[0]->cRd, $arr)&&(in_array($C->cRd, $arr)))) {
				return false;
			}
			return true;
		}
		
		/**
		 * [restrict_cRd_B1 description] In its last occurrence of cRd 222, the same 2 tens with 2N 
		 * @param  CombinationStatistics $C 
		 * @return boolean
		 */
		public function restrict_cRd_B1($C){
			$D1 = $this->getTensConfig($C);			
			$count = 0;

			if(in_array($C->cRd, array(222, 2211, 321))) {			
				$D2 =  $this->getTensConfig($this->lastOccuranceOf['cRd'][$C->cRd]);			
				foreach ($D1 as $k => $nOccured) {
					if(($nOccured > 1)&&(isset($D2[$k]))&&($D2[$k] > 1)) {
						$count++;
					}
				}
				if($count >1){ return false; }
			}
			return true;
		}

		/**
		 * [restrict_cRd_B2 description] In its last occurrence of cRd 2211, the same 2 tens with 2N 
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_cRd_B2($C){
			$D1 =  $this->getTensConfig($C);		
			$count = 0;
			
			if(in_array($C->cRd, array(411, 321, 222, 3111, 2211))) {					
				$D2 =  $this->getTensConfig($this->lastOccuranceOf['cRd'][$C->cRd]);			
				foreach ($D1 as $k => $nOccured) {
					if(($nOccured > 1)&&(isset($D2[$k]))&&($D2[$k] > 1)) {
						$count++;
					}
				}
				if($count < 1){ return false; }
			}
			return true;
		}


		/*******************************************************************************
		 * 
		 * Description: Restriction for cRf
		 * Restriction prefix: restrict_cRf
		 * 
		 *******************************************************************************/

		/**
		 * [restrict_cRf_A1 description] if it occurred in the last test 2211, 111111, 3111
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_cRf_A1($C){
			if(('2211' == $this->wCombs[0]->cRf)&&('2211' == $C->cRf)){
				return false;
			}
			if(('111111' == $this->wCombs[0]->cRf)&&('111111' == $C->cRf)){
				return false;
			}
			if(('3111' == $this->wCombs[0]->cRf)&&('3111' == $C->cRf)){
				return false;
			}
			return true;
		}

		/**
		 * [restrict_cRf_B1 description] 21111 In its last occurrence if with the same FD in 2N
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_cRf_B1($C){			
			$D1 = $this->getTensConfigN($C);
			$D2 = $this->getTensConfigN($this->lastOccuranceOf["cRf"][21111]);
			//Yii::trace(CVarDumper::dumpAsString($D1),'$D1');
			//Yii::trace(CVarDumper::dumpAsString($D2),'$D2');

			foreach ($D1 as $k => $arrN1) {
				if(count($arrN1) > 1){
					foreach ($D2 as $j => $arrN2) {
						if(count($arrN2) > 1){
							$haystack = array();
							foreach ($arrN2 as $k => $N) {
								$haystack[] = $N->DF;
							}
							$c = 0;
							foreach ($arrN1 as $k => $N) {
								if(in_array($arrN1[0]->DF, $haystack)){
									$c++;
								}
							}
							if($c >1) {
								return false;
							} else {
								return true;
							}						
						}
					}
				}
			}
			return true;
		}


		/**
		 * [restrict_cRf_B2 description] 21111 In its last occurrence with 0 or greater than 2 FD equal to the 4 FD represented by the “1111”
		 * @param  CombinationStatistics $C
		 * @return boolean
		 */
		public function restrict_cRf_B2($C){			
			$D1 = $this->getTensConfigN($C);
			$D2 = $this->getTensConfigN($this->lastOccuranceOf["cRf"][21111]);

			$DF1 = array();

			foreach ($D1 as $k => $arrN1) {
				if(count($arrN1) == 1){
					$DF1[] = $arrN1[0]->DF;					
				}
			}
			foreach ($D2 as $k => $arrN2) {
				if(count($arrN2) == 1){
					$DF2[] = $arrN2[0]->DF;					
				}
			}

			$shared = count(array_intersect($DF1, $DF2));

			if(($shared == 0)|| ($shared > 2)) {
				return false;
			}
			return true;
		}
	}