<?php 
	class CombinationGenerator {

		public $limit_2_1c;

		/*	Com todos os DF consecutivos (ex: 01-11-22-33-44-54)
			Generates the base Combination based on the Rule 1a1
			@return CombinationStatistic
		 */
		public function rule_1a1() {
			//1º N- 01 a 30; 2º N- 02 a 40; 3º N- 04 a 49; 4º N- 11 a 55; 5º N- 18 a 59; 6º N- 31 a 60;
			$comb = array();
			$list = array();
			$ranges = array(array('min'=>1,'max'=>30),
							array('min'=>2,'max'=>40),
							array('min'=>4,'max'=>49),
							array('min'=>11,'max'=>55),
							array('min'=>18,'max'=>59),
							array('min'=>31,'max'=>60)
							);
			// sort them by boxes
			for ($i=0; $i < 6; $i++) { 
				$comb[$i] = genUniqueRand($list, 1, 60);
				$list[] = $comb[$i];
			}
			sort($r);

			foreach ($comb as $k => $v) {
				$t = $v;
				if (!(($ranges[$k]['min']<=$t->n)&&($ranges[$k]['max']>=$t->n))) {
					$comb[$k] = genUniqueRand($list, $ranges[$k]['min'], $ranges[$k]['max']);
					$list[] = $comb[$k];
				}
			}

			return $comb;
		}

		private function genUniqueRand($comb, $min, $max) {
			
			$N = new Number(mt_rand($min, $max));

			while (in_array($N, $comb)) {
				$N = new Number(mt_rand($min, $max));
				//add additional test
				/*if((6 == count($comb))&&($this->rule_a2($comb))) {
					continue;
				}*/
			}
		}

		/*	6N pares (even number) ou ímpares (odd or uneven number)
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		function rule_1a2($comb) {
			$total = 0;
			$count = count($comb); 

			foreach($comb as $k=>$N){
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
		public function rule_1a3($comb) {

			$tens = array();
			foreach ($comb as $k => $n) {
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
		public function rule_1a4($comb) {
			$finalDigits = array();
			foreach ($comb as $k => $n) {
				if(!in_array($n->DF, $finalDigits)) {
					$finalDigits[] = $n->DF;
				}
			}

			sort($finalDigits);
			$last = count($finalDigits)-1;
			if($finalDigits[$last]<=$finalDigits[0]+5){
				for ($i=0; $i < $last; $i++) { 
					if($finalDigits[i+1]!=$finalDigits[i]+1){
						return TRUE;
					} 
				}
				return FALSE;
			} else {
				return TRUE;
			}
		}

		/*	Com o menor DF > 4 ou com o maior DF < 5 (05-15-26-28-37-49 ou 02-10-33-43-52-54)
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a5($comb) {

			$DFs = array();
			foreach ($comb as $k => $N) {
				$DFs[] = $N->DF;
			}
			sort($DFs);
			if(($DFs[0] > 4)||($DFs[5] < 5)) {
				return FALSE;
			}
			return TRUE;
		}

		/*	Com 2 NDif = 1 (~ 1 trinca ou 2 duplas de N consecutivos)
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a6($comb){
			$count = count($comb);
			$limit = 0;
			for ($i=0; $i < $count; $i++) { 
				if($comb[$i]->n+1 == $comb[$i+1]->n) { 
					$limit++;
				}
				if($limit >= 2) {
					return FALSE;
				}
			}
			return TRUE;
		}		

		/*	Com 3 NDif iguais e/ou com todos os NDif > 6 ou < 6
			@param array of Numbers(class)
			@return TRUE if it passes the rule and 
			False if it fails
		 */
		public function rule_1a7($comb){
			$count = count($comb);
			$limit = 0;
			$NDifs = array();
			for ($i=0; $i < $count; $i++) { 
				$NDifs[] = $comb[$i]->n+1 - $comb[$i+1]->n
			}
			sort($NDifs);
			if(($NDifs[0]>6)||($NDifs[4]<6)) {
				return FALSE;
			}
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
		public function rule_1a8($comb){
			$C = new Combination($comb);
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
			$subComb = '';
			if($c1 != $c2) {
				foreach ($c2->d as $key => $value) {
					if(in_array($value, $c1->d)) {
						$num++;
					}
				}
			}
			if(($c1 == $c2)||($num==6)) {
				return array('num'=>-1,'subComb'=>$subComb);
			}
				return array('num'=>$num,'subComb'=>$subComb);
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
				$return = $this->numElementsEqual($combination, $value);
				if($return['num'] >= $threshold) {
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
				$return = $this->numElementsEqual($combination, $value);
				if(($return['num'] == $threshold)&&($value->cRd_cRf == $combination->cRd_cRf)) {
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
						$limits['c1'][] == $cDf;
					}					
				}
				if(count($limits['c1'])>=21) {break;}
			}
			//c2
			foreach ($winningCombinations as $key => $value) {
				if($value->cDd == '2211') {
					if(!in_array($value->cDd, $limits['c2'])) {
						$limits['c2'][] == $value->cDd;
					}					
				}
				if(count($limits['c2'])>=9) {break;}
			}
			//c3
			foreach ($winningCombinations as $key => $value) {
				if($value->cDd == '21111') {
					if(!in_array($value->cDd, $limits['c3'])) {
						$limits['c3'][] == $value->cDd;
					}					
				}
				if(count($limits['c3'])>=3) {break;}
			}
			//c4
			foreach ($winningCombinations as $key => $value) {
				if($value->cDf == '111111') {
					if(!in_array($value->cDf, $limits['c4'])) {
						$limits['c4'][] == $value->cDf;
					}					
				}
				if(count($limits['c4'])>=21) {break;}
			}
			//c5
			foreach ($winningCombinations as $key => $value) {
				if($value->cDf == '2211 ') {
					$cDf = preg_replace('/(?<!\()[0-9](?!\()/', '', $value->cDf);
					if(!in_array($cDf, $limits['c5'])) {
						$limits['c5'][] == $cDf;
					}					
				}
				if(count($limits['c5'])>=5) {break;}
			}
			//c6
			foreach ($winningCombinations as $key => $value) {
				if($value->cDd == '3111') {
					if(!in_array($value->cDd, $limits['c6'])) {
						$limits['c6'][] == $value->cDd;
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

	}