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

		public $rule_1a1_ranges = array(
			array('min'=>1,'max'=>30),
			array('min'=>2,'max'=>40),
			array('min'=>4,'max'=>49),
			array('min'=>11,'max'=>55),
			array('min'=>18,'max'=>59),
			array('min'=>31,'max'=>60)
		);
		public $permited_1a8;
		public $limit_2_1c;
		public $groups_2_1_2;
		public $configuration_2_1_2;
		public $groups_2_2;
		public $wCombs; // intended to be an array of all previous winning combinations
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
		public $rule_2_1c_prev_3n_in_last_10;
		public $last_N3 = array();

		public function CombinationGenerator($args = null) {
			$this->CL = new CombinationList;
			$this->currentBettingCombinations = array();
			mt_srand($this->make_seed());

			$this->restrictionsToBeChekced = array ( 
				array ('restrict_N_A1',		1, ), 
				/*array ('rule_b1_plus_b3',	1, ), 
				array ('rule_1a1',			1, ), 
				array ('rule_1a2',			1, ), 
				array ('rule_1a8',			1, ), 
				array ('rule_1a6',			1, ), 
				array ('rule_1a5a',			1, ), 
				array ('rule_1a5b',			1, ), 
				array ('rule_1a7',			1, ), 
				array ('rule_1a3',			1, ), 
				array ('rule_1a4',			1, ), 
				array ('rule_a1d1',			1, ), 
				array ('rule_1d',			1, ), 
				array ('rule_1b3',			1,	'list', ), 
				array ('rule_1b2',			1,	'list', ), 
				array ('rule_1b1',			1,	'list', ), 
				array ('rule_b1',			1, ), 
				array ('rule_b2',			1, ), 
				array ('rule_b3',			1, ), 
				array ('rule_b4a',			1, ), 
				array ('rule_b4b',			1, ), 
				array ('rule_b4c',			1, ), 
				array ('rule_b5a1',			1, ), 
				array ('rule_b5a2',			1, ), 
				array ('rule_b5a3',			1, ), 
				array ('rule_b5b1',			1, ), 
				array ('rule_b5b2',			1, ), 
				array ('rule_b5b3',			1, ), 
				array ('rule_b5c1',			1, ), 
				array ('rule_b5c2',			1, ), 
				array ('rule_b6a1',			1, )*/
			);
	
			$this->stats = array(
				"totalTested" => 0,
				"p" => new Performance()
			);

			// OLD STUFF BELOW

			$this->rule_2_2_2_total = 0;
			if(isset($args['permitted1a8'])){
				$this->permited_1a8 = $args['permitted1a8'];
			} else {
				$this->permited_1a8 = array('2211-2211',	'21111-2211',
											'3111-2211',	'321-2211',
											'3111-21111',	'321-21111',
											'2211-3111',	'21111-3111',
											'111111-21111',	'222-21111',
											'411-21111',	'3111-3111',
											'2211-21111',	'2211-111111',
											'21111-21111',	'21111-111111',
											'321-111111',	'3111-111111',
											'2211-321',		'21111-321',
											);
			}

			if(isset($args['group2_2'])){
				//$this->groups_2_2 = $args['group2_2'];
				$this->groups_2_2 = Yii::app()->params['cRd_cRf_groups'];
			} else {
				/*$this->groups_2_2 = array(
				array('2211-21111'),
				array('21111-21111','3111-21111'),
				array('321-21111','222-21111','111111-21111'),
				array('321-2211','3111-2211','2211-2211','21111-2211'),
				array('321-111111','311-111111','2211-111111','21111-111111'),
				array('2211-3111','21111-3111')
				);*/
				$this->groups_2_2 = Yii::app()->params['cRd_cRf_groups'];
			}

			if(isset($args['rule_2_2_2_limit'])){
				$this->rule_2_2_2_limit = $args['rule_2_2_2_limit'];
			} else {
				$this->rule_2_2_2_limit = .05;
			}

			if(isset($args['winningCombinations'])){
				$this->setWinningCombinations($args['winningCombinations']);
			}
		}

		// Replaces parts of the CombinationEngineController->actionRun() to remove engine logic to this class
		public function generateCombinations($previousTest_CL, $numOfCombinations = 100){
			//$CL = new CombinationList();

			set_time_limit(0);
			
	    	//$winningNumbers = array();
	    	//$cgSettings = array('winningCombinations'=>$CL, 'ranges1a1'=> unserialize($engineSettings->ranges1a1), 'permitted1a8'=> unserialize($engineSettings->permitted1a8), 'group2_2'=> unserialize($engineSettings->group2_2), 'rule_2_2_2_limit'=>$engineSettings->rule_2_2_2_limit);
	    	
	    	$numberOfWinningCombinations = count($this->wCombs);

			//starting the process
			
			$fail = 0;
			$count = 0;
			$comb = array();
			$testFailed = array();

			// the actual generation loop
			$this->stats["p"]->start_timer("Over All");
			do {
				do {
					$list = array();
					for ($i=0; $i < 6; $i++) { 
						$comb[$i] = $this->genUniqueRand($list);
						$list[] = $comb[$i]->n;
					}
					$c = new CombinationStatistics($comb);
					//d($c);				//d($c->group2_2); 
					
				} while (in_array($c, $this->currentBettingCombinations));

				$count++;
				$numTestsFailed = 0;
				$this->stats["p"]->start_timer("Average restriction test time");
				foreach ($this->restrictionsToBeChekced as $restriction) {
					$currentFunction = $restriction[0];
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
						if(empty($testFailed[$currentFunction])) {
							$testFailed[$currentFunction] = 0;
						}
						$testFailed[$currentFunction]++;

						if($numTestsFailed>= $this->threshold) {
							$fail++;
							$this->stats["p"]->plus_end_timer("Average restriction test time");
							continue 2;
						}
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

			//return $CL;
		}

		// Utility functions 

		public function addBettingCombination($C) {

			if($C->d[0]->n < 11){ $this->N1_possibilities['n1_10']++;}
			if(($C->d[0]->n >= 11) && ($C->d[0]->n <21)){ $this->N1_possibilities['n11_20']++;}
			if($C->d[0]->n >= 21){$this->N1_possibilities['n21_30']++;}

			$this->N1_possibilities['total']++;

			if(($this->rule_2_2_2_invalid == $C->group2_2)) {
				$this->rule_2_2_2_total++;
			}
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
		 * make_seed() primes the random number generator		 * 
		 **/
		public function make_seed() {
			list($usec, $sec) = explode(' ', microtime());
  			return (float) $sec + ((float) $usec * 100000);
		}

		/////////////////////////////////////////////////////
		////////	Restrictions below
		/////////////////////////////////////////////////////

		/**
		 * 
		 * Description: Restriction for N 
		 * Restriction prefix: restrict_N_
		 * 
		 **/

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
			$ranges = $this->rule_1a1_ranges;
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
					$comb[$i] = $this->genUniqueRand($list, 1, 60);
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
		public function restrict_N_B1($C){
			
		}

	}