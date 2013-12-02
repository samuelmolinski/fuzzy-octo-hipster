<?php
	class Number {
		public $n; // the numbers value (usually from 01-60)
		public $D; // which tens group it belongs. values 0-5
		public $DF; // final digit

		public function Number($v) {
			if(is_numeric($v)&&(0<$v)&&(61>$v)){
				if(2>strlen((string)$v)) {
					$this->n = '0'.$v;
				} else {
					$this->n = (string)$v;
				}
				
				$this->set_D(); //tens group: 1-10, 11-20, etc
				$this->set_DF();
			} 
		}

		public function set_DF() {
			$offset = strlen($this->n)-1;
			$this->DF = $this->n[$offset];
		}

		public function set_D(){
			$v = $this->n;
			if ((1 <= $v)&&($v <=10)){
				$this->D = 0;
			} elseif ((11 <= $v)&&($v <=20)){
				$this->D = 1;
			} elseif ((21 <= $v)&&($v <=30)){
				$this->D = 2;
			} elseif ((31 <= $v)&&($v <=40)){
				$this->D = 3;
			} elseif ((41 <= $v)&&($v <=50)){
				$this->D = 4;
			} elseif ((51 <= $v)&&($v <=60)){
				$this->D = 5;
			}
		}
	}