<?php 
	
	require_once("LF_Combination.php");
	require_once('LF_Restrictions.php');
	require_once("CombinationList.php");
	//require_once("Number.php");

	class LF_CombinationGenerator {

		public $wC = array();
		public $numOfCombinations = 0;
		public $attemptedCombinations = 0;
		public $currentBettingCombinations = array();

		public function LF_CombinationGenerator($args = null) {
			//$this->wC = new CombinationList();
			if(isset($args['wC'])) {
				//$this->wC->add($args['wC']);
				$this->wC =$args['wC'];
			}
			if(isset($args['numOfCombinations'])) {
				$this->numOfCombinations = $args['numOfCombinations'];
				$this->gen_FL_List($this->numOfCombinations);
			}
		}

		public function addBettingCombination($C) {
			$this->currentBettingCombinations[] = $C;

		}

		/*	Com todos os DF consecutivos (ex: 01-11-22-33-44-54)
			Generates the base Combination based on the Rule 1a1
			@return CombinationStatistic
		 */
		public function genRandCombination() {
			//1º N- 01 a 30; 2º N- 02 a 40; 3º N- 04 a 49; 4º N- 11 a 55; 5º N- 18 a 59; 6º N- 31 a 60;
			$list = array();
			$comb = array();

			//if its for generation initial value
			for ($i=0; $i < 15; $i++) {
				$comb[$i] = $this->genUniqueRand($list, 1, 25);
				$list[] = $comb[$i]->n;
			}
			//must return a CombinationStatistics
			return new LF_Combination($comb);
		}

		public function genUniqueRand($omittedNumberList, $min = 1, $max = 60) {

			$N = new Number(mt_rand($min, $max));

			while (in_array($N->n, $omittedNumberList)) {
				unset($N);
				$N = new Number(mt_rand($min, $max));
			}
			return $N;
		}

		public function make_seed()	{
			list($usec, $sec) = explode(' ', microtime());
  			return (float) $sec + ((float) $usec * 100000);
		}

		public function gen_FL_List($numOfCombinations, $clearCurrentCombinationList = false) {

			if($clearCurrentCombinationList) {
				clearBettingCombinations();
			}

			set_time_limit(60);
			$count = 0;
			//$cgList = new CombinationList();

			do {
				do {
					$c = $this->genRandCombination();
					//d($c->group2_2);
				} while (in_array($c, $this->currentBettingCombinations));
				$this->attemptedCombinations++;
				//d($this->test_FL_Combination($c));
				$id = count($this->wC)-1;
				if(isset($this->wC[$id])){
					$c->cal_Ns_ta($this->wC[$id]);
				}			

				if($this->test_FL_Combination($c)) {
					$this->addBettingCombination($c);
				}
				// if all is well we add it 
				
			} while ($numOfCombinations > count($this->currentBettingCombinations));

			return $this->currentBettingCombinations;
		}

		public function clearBettingCombinations(){
			$this->currentBettingCombinations = array();
			$this->attemptedCombinations = 0;
		}

		public function test_FL_Combination($C) {

			//echo Yii::trace(CVarDumper::dumpAsString($this->wC),'$this->wC');
			$id = count($this->wC);
			$C2 = $this->wC[$id-2];
			$C3 = $this->wC[$id-3];
			$C4 = $this->wC[$id-4];
			$C5 = $this->wC[$id-5];
			$C6 = $this->wC[$id-6];
			$C7 = $this->wC[$id-7];
			$C8 = $this->wC[$id-8];
			$C9 = $this->wC[$id-9];
			$C10 = $this->wC[$id-10];
			$prev_C = $this->wC[$id-1];
			$prev3_C_list = array($prev_C, $C2, $C3);
			$prev4_C_list = array($prev_C, $C2, $C3, $C4);
			$prev10_C_list = array($prev_C, $C2, $C3, $C4, $C5, $C6, $C7, $C8, $C9, $C10);


			$r =  new LF_Restrictions($this->wC);

			if(!$r->restrict_N0($C)) {return false;}
			if(!$r->restrict_N1($C)) {return false;}
			if(!$r->restrict_N14($C)) {return false;}
			if(!$r->restrict_D_config($C)) {return false;}
			if(!$r->restrict_accepted_D_config($C)) {return false;}
			if(!$r->restrict_D_config_limit($C, $prev_C)) {return false;}
			if(!$r->restrict_P_I($C)) {return false;}
			if(!$r->restrict_P_I_limit($C, $prev3_C_list)) {return false;}
			if(!$r->restrict_DF1_5($C)) {return false;}
			if(!$r->restrict_DF1_5_limit($C, $prev3_C_list)) {return false;}
			if(!$r->restrict_DF6_0s($C)) {return false;}
			if(!$r->restrict_DF6_0s_limit($C, $prev4_C_list)) {return false;}
			if(!$r->restrict_DFx3s($C)) {return false;}
			if(!$r->restrict_DFx3s_limit_a($C)) {return false;}
			if(!$r->restrict_DF_unique($C)) {return false;}
			if(!$r->restrict_DF_unique_limit($C, $prev3_C_list)) {return false;}
			if(!$r->restrict_N_consec($C)) {return false;}
			if(!$r->restrict_Ns_ta($C)) {return false;}
			if(!$r->restrict_Ns_ta_limit($C, $prev4_C_list)) {return false;}
			if(!$r->N_14_equal($C)) {return false;}
			if(!$r->restrict_1_2config($C, $prev10_C_list)) {return false;}

			return true;
		}
	}