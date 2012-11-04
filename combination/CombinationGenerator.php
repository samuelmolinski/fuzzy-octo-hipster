<?php 
	
	require_once("CombinationStatistics.php");
	require_once("Number.php");

	class CombinationGenerator {

		public $rule_1a1_ranges;
		public $limit_2_1c;
		public $groups_2_2;
		public $wCombs; // inteneded tobo an array of all previous winning combinations
		public $rule_2_2_1a_invalid; // -1 if we do not use it, 0-4 to indicate which group to exclude
		public $rule_2_2_1b_invalid; // Boolean
		public $rule_2_2_1c_invalid; // Boolean
		public $rule_2_2_1d_invalid; // -1 if we do not use it

		public function CombinationGenerator($winningCombinations = null) {
			//seed the random mt_rand()
			mt_srand($this->make_seed());
			$this->rule_1a1_ranges = array(
					array('min'=>1,'max'=>30),
					array('min'=>2,'max'=>40),
					array('min'=>4,'max'=>49),
					array('min'=>11,'max'=>55),
					array('min'=>18,'max'=>59),
					array('min'=>31,'max'=>60)
				);
			if($winningCombinations != null) {
				$this->wCombs = $winningCombinations;
			}

			$this->groups_2_2 = array(
				array('2211-21111'),
				array('2211-3111','2211-2211','2211-111111'),
				array('21111-21111','3111-21111'),
				array('3111-2211','3111-111111','21111-3111','21111-2211','21111-111111'),
				array('411-21111','321-21111','222-21111','11111-21111','321-2211','321-111111','3111-3111', '2211-321', '21111-321')
			);

			//$this->rule_2_2_1a_invalid = $this->check_rule_2_2_1a();
			//$this->rule_2_2_1b_invalid = $this->rule_2_2_1b($this->wCombs[0], TRUE);
			//$this->rule_2_2_1c_invalid = $this->rule_2_2_1c($this->wCombs[0], TRUE);
			//$this->rule_2_2_1c_invalid = $this->rule_2_2_1d($this->wCombs[1], TRUE, $this->rule_2_2_1d($this->wCombs[0], TRUE));
		}

		/*	Com todos os DF consecutivos (ex: 01-11-22-33-44-54)
			Generates the base Combination based on the Rule 1a1
			@return CombinationStatistic
		 */
		public function rule_1a1($C = array(), $generating = false) {
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

		public function genUniqueRand($comb, $min, $max) {
			
			$N = new Number(mt_rand($min, $max));

			while (in_array($N, $comb)) {
				unset($N);
				$N = new Number(mt_rand($min, $max));
			}
			return $N;
		}

		public function make_seed()
		{
			list($usec, $sec) = explode(' ', microtime());
  			return (float) $sec + ((float) $usec * 100000);
		}

		/*	6N pares (even number) ou ímpares (odd or uneven number)
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		function rule_1a2($C) {
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

		/*	6N em 3 D (ten) consecutivas
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a3($C) {

			$tens = array();
			foreach ($C->d as $k => $n) {
				if(!in_array($n->D, $tens)) {
					$tens[] = $n->D;
				}
			}
			if(3 == count($tens)) {
				sort($tens);
				if(($tens[1]==$tens[0]+1)&&($tens[2]==$tens[0]+2)) {
					return FALSE;
				} else {
					return TRUE;
				}
			} else {
				return FALSE;
			}
		}

		/*	Com todos os DF consecutivos (ex: 01-11-22-33-44-54)
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a4($C) {
			$finalDigits = array();
			foreach ($C->d as $k => $n) {
				if(!in_array($n->DF, $finalDigits)) {
					$finalDigits[] = $n->DF;
				}
			}

			sort($finalDigits);
			$last = count($finalDigits)-1;
			if($finalDigits[$last]<=$finalDigits[0]+5){
				for ($i=0; $i < $last; $i++) {
				print_r($finalDigits[$i].'-'.$finalDigits[$i+1].'|');
				//print_r($finalDigits[$i+1]);
					if(($finalDigits[$i+1]!=$finalDigits[$i]+1)&&($finalDigits[$i+1]!=$finalDigits[$i])){
						return TRUE;
					} 
				}
				return FALSE;
			} else {
				return TRUE;
			}
		}

		/*	Com o menor DF >= 4 ou com o maior DF <= 5 (05-15-26-28-37-49 ou 02-10-33-43-52-54)
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a5($C) {

			$DFs = array();
			foreach ($C->d as $k => $N) {
				$DFs[] = $N->DF;
			}
			sort($DFs);
			if(($DFs[0] >= 4)||($DFs[5] <= 5)) {
				return FALSE;
			}
			return TRUE;
		}

		/*	Com 2 NDif = 1 (~ 1 trinca ou 2 duplas de N consecutivos)
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a6($C){
			$count = count($C->d);
			$limit = 0;
			for ($i=0; $i < $count-2; $i++) { 
				if($C->d[$i]->n+1 == $C->d[$i+1]->n) { 
					$limit++;
					if($limit >= 2) {
						return FALSE;
					}
				}
			}
			return TRUE;
		}		

		/*	Com 3 NDif iguais e/ou com todos os NDif > 6 ou < 6
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a7($C){
			$count = count($C->d);
			$limit = 0;
			$NDifs = array();
			for ($i=0; $i < $count-1; $i++) { 
				$NDifs[] = $C->d[$i+1]->n - $C->d[$i]->n+1;
			}
			sort($NDifs);
			$freq = array_count_values($NDifs);
			foreach ($freq as $k => $NDif) {
				if($NDif>=3) {
					return FALSE;
				}
			}
			return TRUE;
		}

		/*	Com os 44 pares de cRd-cRf não jogáveis
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a8($C){
			$permited = array(	'2211-2211',	'21111-2211',
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
			if(in_array($C->cRd_cRf, $permited)) {
				return TRUE;
			}
			return FALSE;
		}

		// Part b

		/*	Required subfunction for 1b tests
			@param Coombination(class)
			@param array of Coombination(class), usually previous
			@return TRUE if it passes the rule and 
			False if it fails
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

		/*	com $threshold N iguais ao ocorrido num teste anterior
			Used for rule 1b1, 2.1a, 2.1b
			@param Coombination(class)
			@param array of Coombination(class), usually previous test values
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_matchingNumberThreshold($combination, $list, $threshold = 5) {
			foreach ($list as $j => $value) {
				if($this->numElementsEqual($combination, $value) >= $threshold) {
					print_r($value->print_id());
					return FALSE;
				}
			}
			return TRUE;
		}

		/*	com 4 N iguais ao ocorrido em determinado par de cRd-cRf 
			@param Coombination(class)
			@param array of Coombination(class), usually previous test values
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1b2($combination, $list, $threshold = 4) {
			
			foreach ($list as $j => $value) {
				//$return = $this->numElementsEqual($combination, $value);
				if(($this->numElementsEqual($combination, $value) == $threshold)&&($value->cRd_cRf == $combination->cRd_cRf)) {
					return FALSE;
				}
			}
			return TRUE;
		}

		/*	com fator de eliminação de par de cRd-cRf já ocorrido 
			@param Coombination(class)
			@param array of Coombination(class), usually previous test values
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1b3($combination, $list) {
			foreach ($list as $k => $c) {
				if(($combination->foe == $c->foe)) {
					return FALSE;
				}				
			}
			return TRUE;
		}

		// part 2
 
		public function generate2_1cLimit($winningCombinations){
			$limits = array('c1'=>array(),'c2'=>array(),'c3'=>array(),'c4'=>array(),'c5'=>array(),'c6'=>array());
			//c1
			foreach ($winningCombinations as $key => $value) {
				if($value->cDf == '21111') {
					$cDf = preg_replace('/[0-9]\([0-9]\)/', '', $value->cDf);
					if(!in_array($cDf, $limits['c1'])) {
						$limits['c1'][] = $cDf;
					}					
				}
				if(count($limits['c1'])>=21) {break;}
			}
			//c2
			foreach ($winningCombinations as $key => $value) {
				if($value->cDd == '2211') {
					if(!in_array($value->cDd, $limits['c2'])) {
						$limits['c2'][] = $value->cDd;
					}					
				}
				if(count($limits['c2'])>=9) {break;}
			}
			//c3
			foreach ($winningCombinations as $key => $value) {
				if($value->cDd == '21111') {
					if(!in_array($value->cDd, $limits['c3'])) {
						$limits['c3'][] = $value->cDd;
					}					
				}
				if(count($limits['c3'])>=3) {break;}
			}
			//c4
			foreach ($winningCombinations as $key => $value) {
				if($value->cDf == '111111') {
					if(!in_array($value->cDf, $limits['c4'])) {
						$limits['c4'][] = $value->cDf;
					}					
				}
				if(count($limits['c4'])>=21) {break;}
			}
			//c5
			foreach ($winningCombinations as $key => $value) {
				if($value->cDf == '2211 ') {
					$cDf = preg_replace('/(?<!\()[0-9](?!\()/', '', $value->cDf);
					if(!in_array($cDf, $limits['c5'])) {
						$limits['c5'][] = $cDf;
					}					
				}
				if(count($limits['c5'])>=5) {break;}
			}
			//c6
			foreach ($winningCombinations as $key => $value) {
				if($value->cDd == '3111') {
					if(!in_array($value->cDd, $limits['c6'])) {
						$limits['c6'][] = $value->cDd;
					}					
				}
				if(count($limits['c6'])>=6) {break;}
			}
			$this->limit_2_1c = $limits;
		}

		public function rule_2_1c($combination, $list) {
			//c1
			if($combination->cDf == '21111') {
				$cDf = preg_replace('/[0-9]\([0-9]\)/', '', $combination->cDf);
				if(!in_array($cDf, $this->limit_2_1c['c1'])) {
					return FALSE;
				}					
			}
			//c2
			if($combination->cDd == '2211') {
				if(!in_array($combination->cDd, $this->limit_2_1c['c2'])) {
					return FALSE;
				}					
			}
			//c3
			if($combination->cDd == '21111') {
				if(!in_array($combination->cDd, $this->limit_2_1c['c3'])) {
					return FALSE;
				}					
			}
			//c4
			if($combination->cDf == '111111') {
				if(!in_array($combination->cDf, $this->limit_2_1c['c4'])) {
					return FALSE;
				}					
			}
			//c5
			if($combination->cDf == '2211 ') {
				$cDf = preg_replace('/(?<!\()[0-9](?!\()/', '', $combination->cDf);
				if(!in_array($cDf, $this->limit_2_1c['c5'])) {
					return FALSE;
				}					
			}
			//c6
			if($combination->cDd == '3111') {
				if(!in_array($combination->cDd, $this->limit_2_1c['c6'])) {
					return FALSE;
				}					
			}
			return TRUE;
		}

		public function check_rule_2_2_1a(){
			$forbidden = -1;
			foreach ($this->groups_2_2 as $k => $gp) {
				$fiveGroupsPairs = 0;
				if(in_array($this->wCombs[0], $gp)){
					$fiveGroupsPairs++;
				}
				if(in_array($this->wCombs[1], $gp)){
					$fiveGroupsPairs++;
				}
				if(in_array($this->wCombs[2], $gp)){
					$fiveGroupsPairs++;
				}
				if($fiveGroupsPairs > 1) {
					$forbidden = $k;
					break;
				}
			}
			if(3 != count($fiveGroupsPairs)){
				return $forbidden;
			}
			return -1;
		}

		public function rule_2_2_1a($combination){
			if((-1 >= $this->rule_2_2_1a_invalid)&&(in_array($combination->cRd_cRf, $this->groups_2_2[$this->rule_2_2_1a_invalid]))){
				return FALSE;				
			}
			return TRUE;
		}

		public function rule_2_2_1b($combination, $override = False){
			if(!$this->rule_2_2_1b_invalid || $override) {
				$c = 0;
				foreach ($combination->d as $k => $v) {
					if($v <=30) {$c++;}
				}
				if(($c==1)||($c==5)) {
					return FALSE;
				}
			}
			return TRUE;
		}

		public function rule_2_2_1c($combination, $override = False) {
			if(!$this->rule_2_2_1c_invalid || $override) {
				$total = 0;
				$count = count($combination->d); 

				foreach($combination->d as $k=>$N){
					$total += $N % 2;
				}
				//if the N are all even the total will be 0; if the N are all odd then the total will be 6
				if((1 == $total)||($count-1 == $total)){
					return FALSE;
				}
			}	
			return TRUE;
		}

		public function rule_2_2_1d($combination, $override = False, $carryOver = 0) {
			if(!(-1 == $this->rule_2_2_1d_invalid) || $override) {
				$count = count($combination->d);
				$limit = 0;
				for ($i=0; $i < $count-1; $i++) { 
					if($combination->d[$i]+1 == $combination->d[$i+1]) { 						
						$limit++;
						if($limit >= 1) {
							return $carryOver++;
						}
					}
				}
			}	
			return $carryOver;
		}

	}