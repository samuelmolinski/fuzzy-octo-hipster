<?php 
	class CombinationGenerator {

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
		public funciton rule_1a6($comb){
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
		public funciton rule_1a7($comb){
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
		public funciton rule_1a8($comb){
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
	}