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
		public $rule_2_2_1d_invalid; // -1 if we do not use it
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
					array('411-21111','321-21111','222-21111','11111-21111','321-2211','321-111111','3111-3111', '2211-321', '21111-321')
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

		public function setWinningCombinations($wCombs){
			// this assumes chronological order (most recent drawings are last)
			// need the more recent drawings first so use "array_reverse"
			$this->CL->add($wCombs);
			$this->wCombs = array_reverse($this->CL->toCombinations());
			$this->rule_2_1b_subList = array_slice($this->wCombs, 0, 3, FALSE);
			$this->generate2_1cLimit();
			$this->generateRule_2_1_2();
			$this->rule_2_2_1a_invalid = $this->check_rule_2_2_1a();
			$this->rule_2_2_1b_invalid = $this->rule_2_2_1b($this->wCombs[0], TRUE);
			$this->rule_2_2_1c_invalid = $this->rule_2_2_1c($this->wCombs[0], TRUE);
			$this->rule_2_2_1d_invalid = $this->rule_2_2_1d($this->wCombs[1], TRUE, $this->rule_2_2_1d($this->wCombs[0], TRUE));
			$this->genrateListRule_2_2_1e();
			$this->checkRule_2_2_2();
		}

		public function addBettingCombination($C) {
			if(($this->rule_2_2_2_invalid)||(0 == count($this->currentBettingCombinations))||((!$this->rule_2_2_2_invalid)&&($this->rule_2_2_2_limit >($this->rule_2_2_2_total/count($this->currentBettingCombinations))))) {
				$this->currentBettingCombinations[] = $C;
				$this->rule_2_2_2_limit++;
			}
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

		public function genUniqueRand($comb, $min = 1, $max = 60) {

			$N = new Number(mt_rand($min, $max));

			while (in_array($N->n, $comb)) {
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
			//print_r($list);
			foreach ($list as $j => $value) {
				if($this->numElementsEqual($combination, $value) >= $threshold) {
					//print_r($combination);
					//print_r($value);
					//print_r($this->numElementsEqual($combination, $value));
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
			print_r("\ncombination->cRf : ");
			print_r($combination->cRf);
			print_r("\ncombination->cRd : ");
			print_r($combination->cRd);
			if($combination->cRf == '21111') {
				$cDfs = '';
				foreach ($combination->cDf as $k => $vDF) {
					if($vDF==1){
						$cDfs .= $k;
					}
				}
				print_r("\ncDfs = ".$cDfs.' ');
				if(in_array($cDfs, $this->limit_2_1c['c1'])) {
					return FALSE;
				}					
			}
			//c2
			if($combination->cRd == '2211') {
			print_r("\ncombination->print_cDd() : ");
				print_r($combination->print_cDd());
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

		/*public function generateRule_2_1_2() {
			$groups = array('1_5'=>array(), '6_10'=>array(), 'terms'=>array());
			for ($i=0; $i < 5; $i++) {
				foreach ($this->wCombs[$i]->d as $key => $N) {
					if(!array_key_exists($N->n, $groups['1_5'])){
						$groups['1_5'][$N->n] = 0;
					}
					$groups['1_5'][$N->n]++;
				}
			}
			for ($i=5; $i < 9; $i++) {
				foreach ($this->wCombs[$i]->d as $key => $N) {
					if(1<=@$groups['6_10'][$N->n]) {
						if(!array_key_exists($N->n, $groups['6_10'])) {
							$groups['6_10'][$N->n] = 0;
						}
						$groups['6_10'][$N->n]++;
					}
				}				
			}
			// check the number of matching N's in previous tests
			for ($i=0; $i < 2; $i++) {
				//print_r($this->wCombs[$i]->d);
				foreach ($this->wCombs[$i]->d as $key => $N) {
					//print_r($N->n);
					if(!array_key_exists($N->n, $groups['1_5'])){ 
						$groups['1_5'][$N->n] = 0;
					}
					$groups['1_5'][$N->n]++;
				}
				$this->groups_2_1_2 = $groups;
			}
		}*/

		public function generateRule_2_1_2() {
			$groups = array(array(), array());
			for ($i=0; $i < 5; $i++) {
				foreach ($this->wCombs[$i]->d as $key => $N) {
					if(!array_key_exists($N->n, $groups[0])){
						$groups[0][] = $N->n;
					}
				}
			}
			for ($i=5; $i < 9; $i++) {
				foreach ($this->wCombs[$i]->d as $key => $N) {
					if(!array_key_exists($N->n, $groups[0])&&!array_key_exists($N->n, $groups[1])) {
						$groups[1][] = $N->n;
					}
				}				
			}
			for ($i=1; $i < 61; $i++) {
				if(!array_key_exists($i, $groups[0])&&!array_key_exists($i, $groups[1])) {
					$groups[2][] = $i;
				}		
			}
			$this->groups_2_1_2 = $groups;
		}

		public function combinationConfiguration($C, $offset = 0) {
			$config = array();
			$temp = array();
			$tCount = 0;
			for ($i = 0+$offset; $i < 6+$offset; $i++) {
				$count = 0;
				foreach ($this->wCombs[$i]->d as $k => $N) {
					if(!in_array($N, $C->d)&&!in_array($N->n, $temp)) {
						$temp[] = $N->n;
						$count++;
					}
				}
			}
			$tCount += $count;
			$config[] = $count;
			for ($i = 6+$offset; $i <= 10+$offset; $i++) { 
				$count = 0;
				foreach ($this->wCombs[$i]->d as $k => $N) {					
					if(!in_array($N, $C->d)&&!in_array($N->n, $temp)) {
						$temp[] = $N->n;
						$count++;
					}
				}
			}
			$tCount += $count;
			$config[] = $count;
			$config[] = 6 - $tCount;
			$config['N'] = $temp;
			return $config;
		}

		public function generateConfiguration_2_1_2() {
			$this->configuration_2_1_2 = array();

			for ($i=0; $i < 2; $i++) { 
				$this->configuration_2_1_2[] = $this->combinationConfiguration($this->wCombs[$i], $i);
			}
		}

		//a-it cannot have more than 4N in any of the 3(2) classes; (obs:6,4 million combinations don't fit)
		public function rule_2_1_2a($C) {
			$numMatched = 0;
			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$this->groups_2_1_2['1-5'])) {
					$numMatched++;
				}
			}
			if((4 <= $numMatched)||(1 > $numMatched)) {
				return false;
			}
			foreach ($C->d as $k => $N) {
				if(in_array($N->n,$this->groups_2_1_2['6_10'])) {
					$numMatched++;
				}
			}
			if(4 <= $numMatched){
				return false;
			} 
			foreach ($C->d as $k => $N) {
				if(!in_array($N->n,$this->groups_2_1_2['1-5'])&&!in_array($N->n,$this->groups_2_1_2['6_10'])) {
					$numMatched++;
				}
			}
			if(4 <= $numMatched){
				return false;
			} else {
				return true;
			}
		}
		//b-a “configuration” (amount of N, from the first on, occurred in each class) happened in the last test cannot repeat in the next 2 tests, unless it is 222, 231, 312 or 321 which cannot happen only in the next test;
		public function rule_2_1_2b($C) {
			$cConfig = $this->combinationConfiguration($C);
			$onetimelimit = array(array(2,2,2), array(2,3,1), array(3,1,2), array(3,2,1));
			if($cConfig == $this->configuration_2_1_2[0]) {
				return false;
			}
			if((!in_array($cConfig, $onetimeLimit))&&($cConfig == $this->configuration_2_1_2[1])) {
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
								if(($N->d = $tens)&&(in_array($N->n,$this->groups_2_1_2[$i]))){
									$count++;
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
								if(($N->df = $df)&&(in_array($N->n,$this->groups_2_1_2[$i]))){
									$count++;
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

		}

		public function check_rule_2_2_1a(){
			foreach ($this->groups_2_2 as $k => $gp) {
				$fiveGroupsPairs = 0;
				if(in_array($this->wCombs[0], $gp)){
					$fiveGroupsPairs++;
				}
				if(in_array($this->wCombs[1], $gp)){
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

		public function rule_2_2_1b($combination, $override = False){
			if(!$this->rule_2_2_1b_invalid || $override) {
				$c = 0;
				foreach ($combination->d as $k => $v) {
					if($v->n <=30) {$c++;}
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

			if((1 > $this->rule_2_2_1d_invalid) || $override) {

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

		/*public function genrateListRule_2_2_1e() {
			$list = array();
			$list2 = array();
			$final =  array();
			foreach ($this->wCombs[0]->d as $k => $N) {	
				for ($i=1; $i < 4; $i++) { 							
					if(in_array($N, $this->wCombs[$i]->d)){
						if(!array_key_exists($N->n, $list)) {
							$list[$N->n] = 0;
						} 
						$list[$N->n]++;
					}
				}
			}
			//print_r($list);

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
			//print_r($list2);
			$count = count($list);
			$count2 = count($list2);
			if($count == $count2) {
				$this->listRule_2_2_1e = $count;
			} elseif((($count==0)||($count==3))&&(3 == $count+$count2)) {
				$this->listRule_2_2_1e = 3;
			} else {
				$this->listRule_2_2_1e = 0;
			}
			$this->listRule_2_2_1e = $final;
		}*/
		public function genrateListRule_2_2_1e() {
			$list = array();
			$list2 = array();
			$final =  array();
			foreach ($this->wCombs[0]->d as $k => $N) {	
				for ($i=1; $i < 4; $i++) { 							
					if(in_array($N, $this->wCombs[$i]->d)){
						if(!array_key_exists($N->n, $list)) {
							$list[$N->n] = 0;
						} 
						$list[$N->n]++;
						if ($list[$N->n] == 3) {
							$final[] = $N->n;
						}
					}
				}
			}
			//print_r($list);

			foreach ($this->wCombs[1]->d as $k => $N) {	
				for ($i=2; $i < 5; $i++) { 							
					if(in_array($N, $this->wCombs[$i]->d)){
						if(!array_key_exists($N->n, $list2)) {
							$list2[$N->n] = 0;
						} 
						$list2[$N->n]++;						
						if ($list2[$N->n] == 3) {
							$final[] = $N->n;
						}
					}
				}
			}
			//print_r($list2);

			$this->listRule_2_2_1e = $final;
		}

		/*public function rule_2_2_1e($C, $override = False) {
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
		}*/
		public function rule_2_2_1e($C) {
			foreach ($C->d as $k => $N) {
				if(in_array($N->n, $this->listRule_2_2_1e)){
					return false;
				}
			}
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
			
			//d($list);
			foreach ($list as $group => $occured) {
				if(2 > $occured) {
					return $this->rule_2_2_2_invalid = $group;

				}
			}
			return $this->rule_2_2_2_invalid = -1;
		}

		public function Rule_2_2_2($C) {
			$count = count($this->currentBettingCombinations);
			if((-1 != $this->rule_2_2_1a_invalid)&&$count&&($this->rule_2_2_2_limit <($this->rule_2_2_2_total/$count))) {
				return false;
			}

			return true;
		}
	}