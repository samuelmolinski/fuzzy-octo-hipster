<?php
	class Number {
		public $n; // the numbers value (usually from 1-60)
		public $D; // which tens group it belongs. values 0-5
		public $DF; // final digit

		public function Number($v) {
			if(count((string)$v)==2) { 
				$this->$n = $v;
				$this->set_D();
				$this->set_DF();
			} 
		}

		public function set_DF() {
			$this->DF = $this->n[1];
		}

		public function set_D(){
			switch($this->$n) {
				case ((1 <= $v)&&($v <=10)):
					$this->D = 0;
					break;
				case ((11 <= $v)&&($v <=20)):
					$this->D = 1;
					break;
				case ((21 <= $v)&&($v <=30)):
					$this->D = 2;
					break;
				case ((31 <= $v)&&($v <=40)):
					$this->D = 3;
					break;
				case ((41 <= $v)&&($v <=50)):
					$this->D = 4;
					break;
				case ((51 <= $v)&&($v <=60)):
					$this->D = 5;
					break;
			}
		}
	}