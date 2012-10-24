<?php 
	class CombinationGenerator {

		public function rule_a1() {
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
				$t = $v
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

		function rule_a2($comb) {
			$total = 0;
			//6N pares (even number) ou ímpares (odd or uneven number)
			foreach($comb as $k=>$N){
				$total += $N->n % 2;
			}
			//if the N are all even the total will be 0; if the N are all odd then the total will be 6
			if((0 == $total)||(6 == $total)){
				return FALSE;
			}
			return TRUE;
		}

		public function rule_a3($comb) {
			//6N em 3 D (ten) consecutivas
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

		public function rule_a4($comb) {
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
					if($finalDigits[i+1]!=$finalDigits[i]+1)){
						return TRUE;
					} 
				}
				return FALSE;
			} else {
				return TRUE;
			}
		}

		public function rule_a5() {
			//com o menor DF > 4 ou com o maior DF < 5 (05-15-26-28-37-49 ou 02-10-33-43-52-54)

		}
	}