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

		public $CL; /* required */
		public $currentBettingCombinations;  /* required */
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
		public $wCombs; // inteneded tobo an array of all previous winning combinations
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
			$this->rule_2_2_2_total = 0;
			$this->currentBettingCombinations = array();
			mt_srand($this->make_seed());
			//d($args);

			if(isset($args['ranges1a1'])){
				$this->rule_1a1_ranges = $args['ranges1a1'];
			} else {
				$this->rule_1a1_ranges = array(
						array('min'=>1,'max'=>30),
						array('min'=>2,'max'=>40),
						array('min'=>4,'max'=>49),
						array('min'=>11,'max'=>55),
						array('min'=>18,'max'=>59),
						array('min'=>31,'max'=>60)
					);
			}

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

		public function generateCombination(){
			$CL = new CombinationList();
			return $CL;
		}

		/**
		*	Restriction for N Restriction prefix - restrict_N_
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
				return $this->rule_1a1(new CombinationStatistics($comb), true);
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
		

	}