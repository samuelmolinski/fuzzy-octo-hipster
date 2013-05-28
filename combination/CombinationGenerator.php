<?php 
	
	require_once("CombinationStatistics.php");
	require_once("CombinationList.php");
	//require_once("Number.php");

	class CombinationGenerator {


		public $CL;
		public $currentBettingCombinations;
		public $rule_1a1_ranges;
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
				$this->groups_2_2 = $args['group2_2'];
			} else {
				$this->groups_2_2 = array(
					array('2211-21111'),
					array('2211-3111','2211-2211','2211-111111'),
					array('21111-21111','3111-21111'),
					array('3111-2211','3111-111111','21111-3111','21111-2211','21111-111111'),
					array('411-21111','321-21111','222-21111','111111-21111','321-2211','321-111111','3111-3111', '2211-321', '21111-321')
				);
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

		public function returnConfig(){
			$config = array(
							'limit_2_1c'=> $this->limit_2_1c,
							'groups_2_1_2'=> $this->groups_2_1_2,
							'configuration_2_1_2'=> $this->configuration_2_1_2,
							'rule_2_2_1a_invalid'=> $this->rule_2_2_1a_invalid,
							'rule_2_2_1b_invalid'=> $this->rule_2_2_1b_invalid,
							'rule_2_2_1c_invalid'=> $this->rule_2_2_1c_invalid,
							'rule_2_2_1d_invalid'=> $this->rule_2_2_1d_invalid,
							'listRule_2_2_1e'=> $this->listRule_2_2_1e,
							'$rule_2_2_2_invalid'=> $this->rule_2_2_2_invalid,
							'rule_2_2_2_limit'=> $this->rule_2_2_2_limit,
							'rule_2_2_2_total'=> $this->rule_2_2_2_total,
							);

			return $config;
		}

		public function setWinningCombinations($wCombs){
			// this assumes chronological order (most recent drawings are last)
			// need the more recent drawings first so use "array_reverse"
			$this->CL->add($wCombs);
			$this->wCombs = array_reverse($this->CL->toCombinations());
			$this->rule_2_1b_subList = array_slice($this->wCombs, 0, 3, FALSE);
			$this->generate2_1cLimit();
			$this->groups_2_1_2 = $this->generateRule_2_1_2();
			$this->configuration_2_1_2 = $this->generateConfiguration_2_1_2();
			$this->rule_2_2_1a_invalid = $this->check_rule_2_2_1a();
			$this->rule_2_2_1b_invalid = $this->rule_2_2_1b($this->wCombs[0], TRUE);
			$this->rule_2_2_1c_invalid = $this->rule_2_2_1c($this->wCombs[0], TRUE);
			$this->rule_2_2_1d_invalid = $this->rule_2_2_1d($this->wCombs[1], TRUE, $this->rule_2_2_1d($this->wCombs[0], TRUE));
			$this->checkRule_2_2_1e();
			$this->checkRule_2_2_2();
		}

		public function addBettingCombination($C) {
			if(($this->rule_2_2_2_invalid == $C->group2_2)) {
				$this->rule_2_2_2_total++;
			}
			$this->currentBettingCombinations[] = $C;
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

		public function genUniqueRand($omittedNumberList, $min = 1, $max = 60) {

			$N = new Number(mt_rand($min, $max));

			while (in_array($N->n, $omittedNumberList)) {
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
				//print_r($finalDigits[$i].'-'.$finalDigits[$i+1].'|');
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
			if(($DFs[0] >= 3)||($DFs[5] <= 6)) {
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
			for ($i=0; $i < $count-1; $i++) { 
				if($C->d[$i]->n+1 == $C->d[$i+1]->n) { 
					$limit++;
					if($limit >= 2) {
						return FALSE;
					}
				}
			}
			//print_r($limit."\n");
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
			if(in_array($C->cRd_cRf, $this->permited_1a8)) {
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
		public function rule_1b1($combination, $list, $threshold = 5) {
			foreach ($list as $j => $value) {
				if($this->numElementsEqual($combination, $value) >= $threshold) {
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
			//print_r($list);
			foreach ($list as $j => $value) {
				if(($this->numElementsEqual($combination, $value) >= $threshold)&&($value->cRd_cRf == $combination->cRd_cRf)) {
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
 
		public function generate2_1cLimit(){
			$limits = array('c1'=>array(),'c2'=>array(),'c3'=>array(),'c4'=>array(),'c5'=>array(),'c6'=>array(), 'c7'=>array());
			//c1
			foreach ($this->wCombs as $key => $value) {

				if($value->cRf == '21111') {
					$cDfs = '';
					foreach ($value->cDf as $k => $vDF) {
						if($vDF==1){
							$cDfs .= $k;
						}
					}
					if(!in_array($cDfs, $limits['c1'])) {
						$limits['c1'][] = $cDfs;
					}	
					if(count($limits['c1'])>=21) {break;}
				}
			}
			//c2
			foreach ($this->wCombs as $key => $value) {
				if($value->cRd == '2211') {
					if(!in_array($value->cDd, $limits['c2'])) {
						$limits['c2'][] = $value->print_cDd();
					}					
				}
				if(count($limits['c2'])>=6) {break;}
			}
			//c3
			foreach ($this->wCombs as $key => $value) {
				if($value->cRd == '21111') {
					if(!in_array($value->cDd, $limits['c3'])) {
						$limits['c3'][] = $value->print_cDd();
					}					
				}
				if(count($limits['c3'])>=3) {break;}
			}
			//c4
			foreach ($this->wCombs as $key => $value) {
				if($value->cRf == '111111') {
					if(!in_array($value->cDf, $limits['c4'])) {
						$limits['c4'][] = $value->print_cDf();
					}					
				}
				if(count($limits['c4'])>=21) {break;}
			}
			//c5
			foreach ($this->wCombs as $key => $value) {
				if($value->cRf == '2211') {
					$cDfs = '';
					foreach ($value->cDf as $k => $vDF) {
						if($vDF==2){
							$cDfs .= $k;
						}
					}
					//$cDf = preg_replace('/(?<!\()[0-9](?!\()/', '', $value->cDf);
					if(!in_array($cDfs, $limits['c5'])) {
						$limits['c5'][] = $cDfs;
					}					
				}
				if(count($limits['c5'])>=5) {break;}
			}
			//c6
			foreach ($this->wCombs as $key => $value) {
				if($value->cRd == '3111') {
					if(!in_array($value->cDd, $limits['c6'])) {
						$limits['c6'][] = $value->print_cDd();
					}					
				}
				if(count($limits['c6'])>=6) {break;}
			}
			//c7
			foreach ($this->wCombs as $key => $value) {
				if($value->cRd == '321') {
					if(!in_array($value->cDd, $limits['c7'])) {
						$limits['c7'][] = $value->print_cDd();
					}					
				}
				if(count($limits['c7'])>=12) {break;}
			}
			$this->limit_2_1c = $limits;
		}

		public function rule_2_1a($combination, $list){
			//d(count($list));
			return $this->rule_1b1($combination, $this->currentBettingCombinations);
		}

		public function rule_2_1b($combination) {
			//d(count($this->rule_2_1b_subList));
			return $this->rule_1b1($combination, $this->rule_2_1b_subList);
		}

		public function rule_2_1c($combination) {
			//c1
			/*print_r("\ncombination->cRf : ");
			print_r($combination->cRf);
			print_r("\ncombination->cRd : ");
			print_r($combination->cRd);*/
			if($combination->cRf == '21111') {
				$cDfs = '';
				foreach ($combination->cDf as $k => $vDF) {
					if($vDF==1){
						$cDfs .= $k;
					}
				}
				//print_r("\ncDfs = ".$cDfs.' ');
				if(in_array($cDfs, $this->limit_2_1c['c1'])) {
					return FALSE;
				}					
			}
			//c2
			if($combination->cRd == '2211') {
				//print_r("\ncombination->print_cDd() : ");
				//print_r($combination->print_cDd());
				if(in_array($combination->print_cDd(), $this->limit_2_1c['c2'])) {
					return FALSE;
				}					
			}
			//c3
			if($combination->cRd == '21111') {
				if(in_array($combination->print_cDd(), $this->limit_2_1c['c3'])) {
					return FALSE;
				}					
			}
			//c4
			if($combination->cRf == '111111') {
				if(in_array($combination->print_cDf(), $this->limit_2_1c['c4'])) {
					return FALSE;
				}					
			}
			//c5
			if($combination->cRf == '2211') {
				$cDfs = '';
				foreach ($combination->cDf as $k => $vDF) {
					if($vDF==2){
						$cDfs .= $k;
					}
				}
				if(in_array($cDfs, $this->limit_2_1c['c5'])) {
					return FALSE;
				}					
			}
			//c6
			if($combination->cRd == '3111') {
				if(in_array($combination->print_cDd(), $this->limit_2_1c['c6'])) {
					return FALSE;
				}					
			}
			//c7
			if(('321' == $this->wCombs[0]->cRd)&&('321' == $combination->cRd)){
				return false;
			}
			//c8
			$arr = array('411','222','111111');
			if((in_array($this->wCombs[0]->cRd, $arr)&&(in_array($combination->cRd, $arr)))){
				return false;
			}
			//c9
			$arr = array('3111','321');
			if((in_array($this->wCombs[0]->cRf, $arr)&&(in_array($combination->cRf, $arr)))) {
				return false;
			}
			return TRUE;
		}

		public function generateRule_2_1_2($offset = 0) {
			if((10+$offset)<=count($this->wCombs)){
				$class1 = array();
				$class2 = array();
				$class3 = array();
				for ($i=0+$offset; $i < 5+$offset; $i++) {
					foreach ($this->wCombs[$i]->d as $key => $N) {
						if(!in_array($N->n,$class1)){
							$class1[] = $N->n;
						}
					}
				}
				for ($i=5+$offset; $i < 9+$offset; $i++) {
					foreach ($this->wCombs[$i]->d as $key => $N) {
						if(!in_array($N->n, $class1)&&!in_array($N->n, $class2)) {
							$class2[] = $N->n;
						}
					}				
				}
				for ($i=1; $i < 61; $i++) {
					if(!in_array($i, $class1)&&!in_array($i, $class2)) {
						$class3[] = $i;
					}		
				}
				sort($class1);
				sort($class2);
				sort($class3);
				$g = array($class1,$class2,$class3);
				$cD = array(array(),array(),array());
				$dF = array(array(),array(),array());

				for ($j=0; $j < 3; $j++) { 
					foreach ($g[$j] as $k => $n) {
						// sort by tens
						$N = new Number($n);
						switch($N->n) {
							case ((1 <= $N->n)&&($N->n <=10)):
								$cD[$j][0][] = $N->n;
								break;
							case ((11 <= $N->n)&&($N->n <=20)):
								$cD[$j][1][] = $N->n;
								break;
							case ((21 <= $N->n)&&($N->n <=30)):
								$cD[$j][2][] = $N->n;
								break;
							case ((31 <= $N->n)&&($N->n <=40)):
								$cD[$j][3][] = $N->n;
								break;
							case ((41 <= $N->n)&&($N->n <=50)):
								$cD[$j][4][] = $N->n;
								break;
							case ((51 <= $N->n)&&($N->n <=60)):
								$cD[$j][5][] = $N->n;
								break;
						}
						$dF[$j][$N->DF][] = $N->n;
						unset($N);
					}
				}
				ksort($dF[0]);
				ksort($dF[1]);
				ksort($dF[2]);
				return array($g, $cD, $dF);
			} else {
				return array(array(array(),array(),array(),array(),array(),array()),array(),array());
			}
		}

		public function combinationConfiguration($C, $list = array()) {
			if(!$list) {
				$list = $this->groups_2_1_2;
			}
			$config = array();
			$numMatched = 0;
			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$list[0][0])) {
					$numMatched++;
				}
			}
			$config[] = $numMatched;
			$numMatched = 0;

			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$list[0][1])) {
					$numMatched++;
				}
			}
			$config[] = $numMatched;
			$numMatched = 0;

			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$list[0][2])) {
					$numMatched++;
				}
			}
			$config[] = $numMatched;

			return $config;
		}

		public function generateConfiguration_2_1_2() {
			//if(11<=count($this->wCombs)) {
				$c = array();
				//print_r("\n Setting configuration_2_1_2 -");

				for ($i=0; $i < 2; $i++) { 
					$rule = $this->generateRule_2_1_2($i+1);
					$c[] = $this->combinationConfiguration($this->wCombs[$i], $rule);
				}

				return $c;
			/*} else {
				return FALSE;
			}*/
			
		}

		//a-it cannot have more than 4N in any of the 3(2) classes; (obs:6,4 million combinations don't fit)
		public function rule_2_1_2a($C) {
			$numMatched = 0;
			//does it match the first class, 1-5
			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$this->groups_2_1_2[0][0])) {
					$numMatched++;
				}
			}
			if((4 < $numMatched)||(1 > $numMatched)) {
				return false;
			}
			$numMatched = 0;
			//does it match the first class, 6-10
			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$this->groups_2_1_2[0][1])) {
					$numMatched++;
				}
			}
			if(4 < $numMatched){
				return false;
			} 
			$numMatched = 0;
			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$this->groups_2_1_2[0][2])) {
					$numMatched++;
				}
			}
			if(4 < $numMatched){
				return false;
			} else {
				return true;
			}
		}
		//b-a “configuration” (amount of N, from the first on, occurred in each class) happened in the last test cannot repeat in the next 2 tests, unless it is 222, 231, 312 or 321 which cannot happen only in the next test;
		public function rule_2_1_2b($C) {
			$cConfig = $this->combinationConfiguration($C);
			//print_r("\n cConfig :");
			//print_r($cConfig);
			$oneTimeLimit = array(array(2,2,2), array(2,3,1), array(3,1,2), array(3,2,1));
			if($cConfig == $this->configuration_2_1_2[0]) {
				return false;
			}
			if((!in_array($cConfig, $oneTimeLimit))&&($cConfig == $this->configuration_2_1_2[1])) {
				return false;
			}
			return true;
		}

		//c-it cannot have more than 2N that belong to the same ten and/ or the same DF of  a single class;
		public function rule_2_1_2c($C) {
			//if more than 2N in the same tens
			// does it even have more than 2N in the same tensw using cRd to check
			if((false !== strpos($C->cRd, '3'))||(false !== strpos($C->cRd, '4'))){
				// if it does we find the range to search, range greater than 2
				foreach ($C->cDd as $tens => $v) {
					if($v > 2) {
						// check it agains all 3 classes
						for ($i=0; $i < 3; $i++) { 
							$count = 0;
							foreach ($C->d as $N) {
								// check only N inside the range and if is matches we count.
								if(($N->d = $tens)&&(in_array($N->n,$this->groups_2_1_2[0][$i]))){
									$count++;

									//print_r("\n count :");
									//print_r($count);
								}
								if($count > 2) {
									return false;
								}
							}
						}
						// only one can exist so we will break
						break;
					}
				}
			}

			//if more than 2N in the DF
			// does it even have more than 2N in the same DF using cRf to check
			if(false !== strpos($C->cRf, '3')) {
				// if it does we find the range to search, range greater than 2
				foreach ($C->cDf as $df => $v) {
					if($v > 2) {
						//b check it agains all 3 classes
						for ($i=0; $i < 3; $i++) { 
							$count = 0;
							foreach ($C->d as $N) {
								// check only N inside the range and if is matches we count.
								if(($N->df = $df)&&(in_array($N->n,$this->groups_2_1_2[0][$i]))){
									$count++;
									/*print_r("\n count :");
									print_r($count);*/
								}
								if($count > 2) {
									return false;
								}
							}
						}
						// only one can exist so we will break
						break;
					}
				}
			}
			return true;

		}

		//d-it cannot have 2 pairs of N of two tens or of two DF in a single class.
		public function rule_2_1_2d($C) {
			//does it match any 4 numbers in the group?
			//print_r($this->groups_2_1_2);
			for ($h=1; $h < 3; $h++) { 				
				for ($i=0; $i < 3; $i++) { 
					$count = 0;
					foreach ($this->groups_2_1_2[$h][$i] as $k => $class) {
						$curCount = 0;			
						for($j=0; $j < 5; $j++) {
							if((in_array($C->d[$j]->n, $class))) {
								$curCount++;
								//print_r("\n curCount :");
								//print_r($curCount);
							}
							if($curCount>2){
								$count++;
								//print_r("\n count :");
								//print_r($count);						
							}
						}
					}
					if($count>=2){
						return false;
					}
				}
				return true;
			}
		}

		public function check_rule_2_2_1a(){
			foreach ($this->groups_2_2 as $k => $gp) {
				$fiveGroupsPairs = 0;
				if(in_array($this->wCombs[0]->cRd_cRf, $gp)){
					$fiveGroupsPairs++;
				}
				if(in_array($this->wCombs[1]->cRd_cRf, $gp)){
					$fiveGroupsPairs++;
				}
				if($fiveGroupsPairs > 1) {
					return $k;
				}
			}
			return -1;
		}

		public function rule_2_2_1a($combination){
			if((-1 != $this->rule_2_2_1a_invalid)&&(in_array($combination->cRd_cRf, $this->groups_2_2[$this->rule_2_2_1a_invalid]))){
				return FALSE;				
			}
			return TRUE;
		}

		public function rule_2_2_1b($combination, $override = False){ // $this->wCombs[0]
			if(!$this->rule_2_2_1b_invalid || $override) {
				$c = 0;
				foreach ($combination->d as $k => $v) {
					if($v->n <=30) {$c++;}
				}
				if(($c==2)||($c==4)) {
					return FALSE;
				}
			}
			if(!$this->rule_2_2_1b_invalid || $override) {
				$c = 0;
				$d = 0;
				foreach ($combination->d as $k => $v) {
					if($v->n <=30) {$c++;}
				}
				foreach ($this->wCombs[1]->d as $k => $v) {
					if($v->n <=30) {$d++;}
				}
				if(($c==3)&&($d==3)) {
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
					$total += $N->n % 2;
				}
				//if the N are all even the total will be 0; if the N are all odd then the total will be 6
				if((1 == $total)||($count-1 == $total)){
					return FALSE;
				}
			}	
			return TRUE;
		}
		/*
			2N consecutivos, caso eles tenham ocorrido nos 2 últimos testes; 13% 19 milh
		*/
		public function rule_2_2_1d($C, $override = False, $carryOver = 0) {

			if((1 < $this->rule_2_2_1d_invalid) || $override) {

				$count = count($C->d);
				$limit = 0;
				for ($i=0; $i < $count-1; $i++) { 
					if($C->d[$i]->n+1 == $C->d[$i+1]->n) { 						
						$limit++;
						if($limit >= 1) {
							if (!$override) {
								return false;
							} else {
								return ++$carryOver;
							}							
						}
					}
				}
			}

			if (!$override) {
				return true;
			} else {
				return $carryOver;
			}	
		}

		public function checkRule_2_2_1e() {
			if(6<=count($this->wCombs)) {
				$list = array();
				$list2 = array();
				$final =  array();
				foreach ($this->wCombs[0]->d as $k => $N) {	
					for ($i=1; $i < 4; $i++) { 							
						if(in_array($N, $this->wCombs[$i]->d)){
							if(!array_key_exists($N->n, $list)) {
								$list[$N->n] = 1;
							} 
							//$list[$N->n]++;
						}
					}
				}
        		/*print_r("\nlist: ");
				print_r($list);*/

				foreach ($this->wCombs[1]->d as $k => $N) {	
					for ($i=2; $i < 5; $i++) { 							
						if(in_array($N, $this->wCombs[$i]->d)){
							if(!array_key_exists($N->n, $list2)) {
								$list2[$N->n] = 0;
							} 
							$list2[$N->n]++;	
						}
					}
				}
				/*print_r("\nlist2: ");
				print_r($list2);*/

				$count = count($list);
				$count2 = count($list2);
				/*print_r("\ncount: ");
				print_r($count);
				print_r("\ncount2: ");
				print_r($count2);*/
				$ct = $count+$count2;
				/*print_r("\n ct: ");
				print_r($ct);*/
				if($count == $count2) {
					//print_r("\n -equal- ");
					if(0 == $count) {
						$this->listRule_2_2_1e = 3;
					} else {
						$this->listRule_2_2_1e = $count;
					}					
				} elseif((($count==0)||($count==3))&&(3 == $ct)) {
					$this->listRule_2_2_1e = 3;
				} else {
					//print_r("\n -inequal- ");
					$this->listRule_2_2_1e = 0;
				}
			}
			//$this->listRule_2_2_1e = $final;
		}

		public function rule_2_2_1e($C, $override = False) {
			$list = array();
			if($this->listRule_2_2_1e){
				foreach ($C->d as $k => $N) {	
					for ($i=0; $i < 3; $i++) { 							
						if(in_array($N, $this->wCombs[$i]->d)){
							if(!array_key_exists($N->n, $list)) {
								$list[$N->n] = 0;
							} 
							$list[$N->n]++;
						}
					}
				}
				$count = count($list);
				if($count == 0) {
					$count == 3;
				}
				if($count == $this->listRule_2_2_1e){
					return FALSE;
				}
				
			} 
			return true;
		}
		
		public function rule_2_2_1f($C) {
			$c1 = $this->wCombs[0];
			$c2 = $this->wCombs[1];
			$e1 = $this->numElementsEqual($C, $c1);
			$e2 = $this->numElementsEqual($C, $c2);

			if($e1 >= 2) {
				//d('false');
				return false;
			}
			//d($e1);
			$n3 = array();
			foreach ($c1->cDd as $n => $v) {
				if($v >= 2) {
					$n3[] = $n;
				}
			}
			//d($n3);
			foreach ($n3 as $k => $c) {
				if($C->cDd[$c] == 2) {
					//d('found false');
					return false;
				}
			}
			if(($C->cDd[0]==0)&&($C->cDd[5]==0)) {
				d('found false 2');
				return FALSE;
			}
			/*d($C->cDd[0]);
			d($C->cDd[1]);
			print_r('<pre>');
			print_r(' -true- ');
			print_r('</pre>');*/
			return true;
		}

		public function checkRule_2_2_2() {

			$list = array();
			foreach ($this->groups_2_2 as $key => $group) {
				if(in_array($this->wCombs[0]->cRd_cRf, $group)){
					if(!@$list[$key]){
						$list[$key] = 0;
					}
					$list[$key]++;
				}
			}				
			
			//print_r("\n List:");
			//print_r($list);
			foreach ($list as $group => $occured) {
				if(1 <= $occured) {
					return $this->rule_2_2_2_invalid = $group;

				}
			}
			return $this->rule_2_2_2_invalid = -1;
		}

		public function rule_2_2_2($C) {
			$count = count($this->currentBettingCombinations);
			//d($C->group2_2);
			if(($this->rule_2_2_1a_invalid == -1) &&
				($this->rule_2_2_2_invalid == $C->group2_2) &&		//if it is not invalid (equal to -1)
				$count && // and the number of the combinations is not 0 (we should add it to the set anyways if there are none)
				($this->rule_2_2_2_limit <($this->rule_2_2_2_total/$count))) {		// and the total is not more than the limit
				return false;
			}

			return true;
		}
	}